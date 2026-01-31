<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class TransactionService
{
    protected $balanceService;

    public function __construct(BalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Process topup transaction with comprehensive error handling
     */
    public function processTopup(User $user, array $data): array
    {
        try {
            DB::beginTransaction();

            // Validate input data
            $validation = $this->validateTopupData($data);
            if (!$validation['valid']) {
                return $validation;
            }

            $amount = $data['amount'];
            $paymentMethod = $data['payment_method'];
            $referenceNumber = $data['reference_number'] ?? null;

            // Calculate fees
            $feeAmount = $this->calculateTopupFee($amount, $paymentMethod);
            $netAmount = $amount - $feeAmount;

            // Create transaction record
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'topup',
                'amount' => $amount,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'description' => "Top up balance via {$paymentMethod}",
                'reference_number' => $referenceNumber ?? $this->generateReferenceNumber(),
                'fee_amount' => $feeAmount,
                'net_amount' => $netAmount,
                'metadata' => [
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'requested_at' => now(),
                ]
            ]);

            // Log audit
            AuditLog::log(
                'topup_initiated',
                "User {$user->name} initiated topup of Rp " . number_format($amount) . " via {$paymentMethod}",
                Transaction::class,
                $transaction->id,
                null,
                $transaction->toArray(),
                [
                    'amount' => $amount,
                    'payment_method' => $paymentMethod,
                    'fee_amount' => $feeAmount,
                    'net_amount' => $netAmount,
                ]
            );

            // Process based on payment method
            $result = $this->processPaymentMethod($transaction, $paymentMethod, $data);

            if ($result['success']) {
                DB::commit();
                
                Log::info('Topup transaction created successfully', [
                    'transaction_id' => $transaction->id,
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'payment_method' => $paymentMethod,
                    'status' => $transaction->status,
                ]);

                return [
                    'success' => true,
                    'message' => $result['message'],
                    'data' => [
                        'transaction' => $transaction->fresh(),
                        'payment_info' => $result['payment_info'] ?? null,
                    ]
                ];
            } else {
                DB::rollBack();
                return $result;
            }

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Topup transaction failed', [
                'user_id' => $user->id,
                'data' => $data,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Log failed attempt
            try {
                AuditLog::log(
                    'topup_failed',
                    "Topup failed for user {$user->name}: " . $e->getMessage(),
                    null,
                    null,
                    null,
                    null,
                    [
                        'user_id' => $user->id,
                        'data' => $data,
                        'error' => $e->getMessage(),
                    ]
                );
            } catch (Exception $auditException) {
                Log::error('Failed to log audit for failed topup', [
                    'original_error' => $e->getMessage(),
                    'audit_error' => $auditException->getMessage(),
                ]);
            }

            return [
                'success' => false,
                'message' => 'Topup failed: ' . $e->getMessage(),
                'error_code' => 'TOPUP_FAILED',
            ];
        }
    }

    /**
     * Confirm transaction by bank officer
     */
    public function confirmTransaction(Transaction $transaction, User $bankOfficer, array $data = []): array
    {
        try {
            DB::beginTransaction();

            // Validate transaction can be confirmed
            if ($transaction->status !== 'pending') {
                throw new Exception('Transaction is not in pending status');
            }

            if (!$bankOfficer->isBank()) {
                throw new Exception('Only bank officers can confirm transactions');
            }

            // Update transaction
            $transaction->update([
                'status' => 'success',
                'processed_by' => $bankOfficer->id,
                'processed_at' => now(),
                'bank_notes' => $data['notes'] ?? null,
                'metadata' => array_merge($transaction->metadata ?? [], [
                    'confirmed_by' => $bankOfficer->id,
                    'confirmed_at' => now(),
                    'confirmation_notes' => $data['notes'] ?? null,
                ])
            ]);

            // Add balance if it's a topup
            if ($transaction->isTopup()) {
                $balanceResult = $this->balanceService->addBalance(
                    $transaction->user,
                    $transaction->net_amount,
                    $transaction,
                    $bankOfficer,
                    "Topup confirmed by bank officer"
                );

                if (!$balanceResult['success']) {
                    throw new Exception('Failed to add balance: ' . $balanceResult['message']);
                }
            }

            // Log audit
            AuditLog::log(
                'transaction_confirmed',
                "Transaction {$transaction->id} confirmed by bank officer {$bankOfficer->name}",
                Transaction::class,
                $transaction->id,
                ['status' => 'pending'],
                ['status' => 'success'],
                [
                    'confirmed_by' => $bankOfficer->id,
                    'notes' => $data['notes'] ?? null,
                    'amount' => $transaction->amount,
                ]
            );

            DB::commit();

            Log::info('Transaction confirmed successfully', [
                'transaction_id' => $transaction->id,
                'confirmed_by' => $bankOfficer->id,
                'amount' => $transaction->amount,
            ]);

            return [
                'success' => true,
                'message' => 'Transaction confirmed successfully',
                'data' => [
                    'transaction' => $transaction->fresh(),
                ]
            ];

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Transaction confirmation failed', [
                'transaction_id' => $transaction->id,
                'bank_officer_id' => $bankOfficer->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Transaction confirmation failed: ' . $e->getMessage(),
                'error_code' => 'CONFIRMATION_FAILED',
            ];
        }
    }

    /**
     * Reject transaction by bank officer
     */
    public function rejectTransaction(Transaction $transaction, User $bankOfficer, string $reason): array
    {
        try {
            DB::beginTransaction();

            // Validate transaction can be rejected
            if ($transaction->status !== 'pending') {
                throw new Exception('Transaction is not in pending status');
            }

            if (!$bankOfficer->isBank()) {
                throw new Exception('Only bank officers can reject transactions');
            }

            // Update transaction
            $transaction->update([
                'status' => 'failed',
                'processed_by' => $bankOfficer->id,
                'processed_at' => now(),
                'failure_reason' => $reason,
                'bank_notes' => $reason,
                'metadata' => array_merge($transaction->metadata ?? [], [
                    'rejected_by' => $bankOfficer->id,
                    'rejected_at' => now(),
                    'rejection_reason' => $reason,
                ])
            ]);

            // Log audit
            AuditLog::log(
                'transaction_rejected',
                "Transaction {$transaction->id} rejected by bank officer {$bankOfficer->name}: {$reason}",
                Transaction::class,
                $transaction->id,
                ['status' => 'pending'],
                ['status' => 'failed'],
                [
                    'rejected_by' => $bankOfficer->id,
                    'reason' => $reason,
                    'amount' => $transaction->amount,
                ]
            );

            DB::commit();

            Log::info('Transaction rejected', [
                'transaction_id' => $transaction->id,
                'rejected_by' => $bankOfficer->id,
                'reason' => $reason,
            ]);

            return [
                'success' => true,
                'message' => 'Transaction rejected successfully',
                'data' => [
                    'transaction' => $transaction->fresh(),
                ]
            ];

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Transaction rejection failed', [
                'transaction_id' => $transaction->id,
                'bank_officer_id' => $bankOfficer->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Transaction rejection failed: ' . $e->getMessage(),
                'error_code' => 'REJECTION_FAILED',
            ];
        }
    }

    /**
     * Validate topup data
     */
    private function validateTopupData(array $data): array
    {
        if (!isset($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
            return [
                'valid' => false,
                'success' => false,
                'message' => 'Invalid amount',
                'error_code' => 'INVALID_AMOUNT',
            ];
        }

        if ($data['amount'] < 10000) {
            return [
                'valid' => false,
                'success' => false,
                'message' => 'Minimum topup amount is Rp 10,000',
                'error_code' => 'AMOUNT_TOO_LOW',
            ];
        }

        if ($data['amount'] > 10000000) {
            return [
                'valid' => false,
                'success' => false,
                'message' => 'Maximum topup amount is Rp 10,000,000',
                'error_code' => 'AMOUNT_TOO_HIGH',
            ];
        }

        if (!isset($data['payment_method']) || !in_array($data['payment_method'], ['bank_transfer', 'e_wallet', 'credit_card'])) {
            return [
                'valid' => false,
                'success' => false,
                'message' => 'Invalid payment method',
                'error_code' => 'INVALID_PAYMENT_METHOD',
            ];
        }

        return ['valid' => true];
    }

    /**
     * Calculate topup fee based on payment method
     */
    private function calculateTopupFee(float $amount, string $paymentMethod): float
    {
        $feeRates = [
            'bank_transfer' => 0.005, // 0.5%
            'e_wallet' => 0.01,       // 1%
            'credit_card' => 0.029,   // 2.9%
        ];

        $rate = $feeRates[$paymentMethod] ?? 0;
        $fee = $amount * $rate;

        // Minimum fee
        $minFee = 1000; // Rp 1,000
        return max($fee, $minFee);
    }

    /**
     * Process payment method specific logic
     */
    private function processPaymentMethod(Transaction $transaction, string $paymentMethod, array $data): array
    {
        switch ($paymentMethod) {
            case 'bank_transfer':
                return $this->processBankTransfer($transaction);
            
            case 'e_wallet':
                return $this->processEWallet($transaction, $data);
            
            case 'credit_card':
                return $this->processCreditCard($transaction, $data);
            
            default:
                throw new Exception('Unsupported payment method');
        }
    }

    /**
     * Process bank transfer (requires manual confirmation)
     */
    private function processBankTransfer(Transaction $transaction): array
    {
        $vaNumber = '1234' . str_pad($transaction->user_id, 8, '0', STR_PAD_LEFT) . str_pad($transaction->id, 4, '0', STR_PAD_LEFT);
        
        $transaction->update([
            'metadata' => array_merge($transaction->metadata ?? [], [
                'va_number' => $vaNumber,
                'bank_name' => 'BCA',
                'expires_at' => now()->addHours(24),
            ])
        ]);

        return [
            'success' => true,
            'message' => 'Please transfer to the provided virtual account number. Your balance will be updated after payment confirmation.',
            'payment_info' => [
                'va_number' => $vaNumber,
                'bank_name' => 'BCA',
                'amount' => $transaction->amount,
                'expires_at' => now()->addHours(24)->format('Y-m-d H:i:s'),
            ]
        ];
    }

    /**
     * Process e-wallet (simulate instant payment)
     */
    private function processEWallet(Transaction $transaction, array $data): array
    {
        // Simulate payment processing
        $transaction->update([
            'status' => 'success',
            'processed_at' => now(),
            'metadata' => array_merge($transaction->metadata ?? [], [
                'payment_provider' => 'GoPay',
                'payment_id' => 'GP' . time() . rand(1000, 9999),
            ])
        ]);

        // Add balance immediately
        $balanceResult = $this->balanceService->addBalance(
            $transaction->user,
            $transaction->net_amount,
            $transaction,
            null,
            "E-wallet topup processed automatically"
        );

        if (!$balanceResult['success']) {
            throw new Exception('Failed to add balance: ' . $balanceResult['message']);
        }

        return [
            'success' => true,
            'message' => 'Payment successful! Your balance has been updated.',
            'payment_info' => [
                'payment_provider' => 'GoPay',
                'payment_status' => 'success',
            ]
        ];
    }

    /**
     * Process credit card (simulate instant payment)
     */
    private function processCreditCard(Transaction $transaction, array $data): array
    {
        // Simulate payment processing
        $transaction->update([
            'status' => 'success',
            'processed_at' => now(),
            'metadata' => array_merge($transaction->metadata ?? [], [
                'payment_provider' => 'Visa',
                'payment_id' => 'CC' . time() . rand(1000, 9999),
                'card_last_four' => '****',
            ])
        ]);

        // Add balance immediately
        $balanceResult = $this->balanceService->addBalance(
            $transaction->user,
            $transaction->net_amount,
            $transaction,
            null,
            "Credit card topup processed automatically"
        );

        if (!$balanceResult['success']) {
            throw new Exception('Failed to add balance: ' . $balanceResult['message']);
        }

        return [
            'success' => true,
            'message' => 'Payment successful! Your balance has been updated.',
            'payment_info' => [
                'payment_provider' => 'Visa',
                'payment_status' => 'success',
            ]
        ];
    }

    /**
     * Generate unique reference number
     */
    private function generateReferenceNumber(): string
    {
        return 'TXN' . date('Ymd') . strtoupper(substr(uniqid(), -6));
    }
}