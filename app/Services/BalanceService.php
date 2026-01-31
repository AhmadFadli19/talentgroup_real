<?php

namespace App\Services;

use App\Models\User;
use App\Models\Transaction;
use App\Models\BalanceHistory;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class BalanceService
{
    /**
     * Add balance to user account with comprehensive error handling
     */
    public function addBalance(User $user, float $amount, Transaction $transaction = null, User $processedBy = null, string $description = null): array
    {
        try {
            DB::beginTransaction();

            // Validate amount
            if ($amount <= 0) {
                throw new Exception('Amount must be greater than 0');
            }

            // Get current balance
            $balanceBefore = $user->balance ?? 0;
            $balanceAfter = $balanceBefore + $amount;

            // Update user balance
            $user->update(['balance' => $balanceAfter]);

            // Create balance history record
            $balanceHistory = BalanceHistory::create([
                'user_id' => $user->id,
                'transaction_id' => $transaction?->id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description ?? 'Balance added',
                'created_by' => $processedBy?->id ?? auth()->id(),
                'metadata' => [
                    'transaction_type' => $transaction?->type,
                    'payment_method' => $transaction?->payment_method,
                    'reference_number' => $transaction?->reference_number,
                ]
            ]);

            // Log audit
            AuditLog::log(
                'balance_add',
                "Added balance of Rp " . number_format($amount) . " to user {$user->name}",
                User::class,
                $user->id,
                ['balance' => $balanceBefore],
                ['balance' => $balanceAfter],
                [
                    'amount' => $amount,
                    'transaction_id' => $transaction?->id,
                    'processed_by' => $processedBy?->id ?? auth()->id(),
                ]
            );

            DB::commit();

            Log::info('Balance added successfully', [
                'user_id' => $user->id,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'transaction_id' => $transaction?->id,
                'processed_by' => $processedBy?->id ?? auth()->id(),
            ]);

            return [
                'success' => true,
                'message' => 'Balance added successfully',
                'data' => [
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'amount_added' => $amount,
                    'balance_history_id' => $balanceHistory->id,
                ]
            ];

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to add balance', [
                'user_id' => $user->id,
                'amount' => $amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Log failed attempt
            try {
                AuditLog::log(
                    'balance_add_failed',
                    "Failed to add balance of Rp " . number_format($amount) . " to user {$user->name}: " . $e->getMessage(),
                    User::class,
                    $user->id,
                    null,
                    null,
                    [
                        'amount' => $amount,
                        'error' => $e->getMessage(),
                        'transaction_id' => $transaction?->id,
                    ]
                );
            } catch (Exception $auditException) {
                Log::error('Failed to log audit for failed balance addition', [
                    'original_error' => $e->getMessage(),
                    'audit_error' => $auditException->getMessage(),
                ]);
            }

            return [
                'success' => false,
                'message' => 'Failed to add balance: ' . $e->getMessage(),
                'error_code' => 'BALANCE_ADD_FAILED',
            ];
        }
    }

    /**
     * Deduct balance from user account with comprehensive error handling
     */
    public function deductBalance(User $user, float $amount, Transaction $transaction = null, User $processedBy = null, string $description = null): array
    {
        try {
            DB::beginTransaction();

            // Validate amount
            if ($amount <= 0) {
                throw new Exception('Amount must be greater than 0');
            }

            // Get current balance
            $balanceBefore = $user->balance ?? 0;

            // Check if user has sufficient balance
            if ($balanceBefore < $amount) {
                throw new Exception('Insufficient balance. Current balance: Rp ' . number_format($balanceBefore) . ', Required: Rp ' . number_format($amount));
            }

            $balanceAfter = $balanceBefore - $amount;

            // Update user balance
            $user->update(['balance' => $balanceAfter]);

            // Create balance history record
            $balanceHistory = BalanceHistory::create([
                'user_id' => $user->id,
                'transaction_id' => $transaction?->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'description' => $description ?? 'Balance deducted',
                'created_by' => $processedBy?->id ?? auth()->id(),
                'metadata' => [
                    'transaction_type' => $transaction?->type,
                    'payment_method' => $transaction?->payment_method,
                    'reference_number' => $transaction?->reference_number,
                ]
            ]);

            // Log audit
            AuditLog::log(
                'balance_deduct',
                "Deducted balance of Rp " . number_format($amount) . " from user {$user->name}",
                User::class,
                $user->id,
                ['balance' => $balanceBefore],
                ['balance' => $balanceAfter],
                [
                    'amount' => $amount,
                    'transaction_id' => $transaction?->id,
                    'processed_by' => $processedBy?->id ?? auth()->id(),
                ]
            );

            DB::commit();

            Log::info('Balance deducted successfully', [
                'user_id' => $user->id,
                'amount' => $amount,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'transaction_id' => $transaction?->id,
                'processed_by' => $processedBy?->id ?? auth()->id(),
            ]);

            return [
                'success' => true,
                'message' => 'Balance deducted successfully',
                'data' => [
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'amount_deducted' => $amount,
                    'balance_history_id' => $balanceHistory->id,
                ]
            ];

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Failed to deduct balance', [
                'user_id' => $user->id,
                'amount' => $amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Log failed attempt
            try {
                AuditLog::log(
                    'balance_deduct_failed',
                    "Failed to deduct balance of Rp " . number_format($amount) . " from user {$user->name}: " . $e->getMessage(),
                    User::class,
                    $user->id,
                    null,
                    null,
                    [
                        'amount' => $amount,
                        'error' => $e->getMessage(),
                        'transaction_id' => $transaction?->id,
                    ]
                );
            } catch (Exception $auditException) {
                Log::error('Failed to log audit for failed balance deduction', [
                    'original_error' => $e->getMessage(),
                    'audit_error' => $auditException->getMessage(),
                ]);
            }

            return [
                'success' => false,
                'message' => 'Failed to deduct balance: ' . $e->getMessage(),
                'error_code' => 'BALANCE_DEDUCT_FAILED',
            ];
        }
    }

    /**
     * Get user balance history with pagination
     */
    public function getBalanceHistory(User $user, int $perPage = 15): array
    {
        try {
            $histories = BalanceHistory::where('user_id', $user->id)
                ->with(['transaction', 'createdBy'])
                ->latest()
                ->paginate($perPage);

            return [
                'success' => true,
                'data' => $histories,
            ];

        } catch (Exception $e) {
            Log::error('Failed to get balance history', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to get balance history: ' . $e->getMessage(),
                'error_code' => 'BALANCE_HISTORY_FAILED',
            ];
        }
    }

    /**
     * Validate balance operation
     */
    public function validateBalanceOperation(User $user, float $amount, string $operation = 'add'): array
    {
        try {
            // Basic validations
            if (!$user || !$user->exists) {
                return [
                    'valid' => false,
                    'message' => 'User not found',
                    'error_code' => 'USER_NOT_FOUND',
                ];
            }

            if ($amount <= 0) {
                return [
                    'valid' => false,
                    'message' => 'Amount must be greater than 0',
                    'error_code' => 'INVALID_AMOUNT',
                ];
            }

            if ($amount > 100000000) { // 100 million limit
                return [
                    'valid' => false,
                    'message' => 'Amount exceeds maximum limit of Rp 100,000,000',
                    'error_code' => 'AMOUNT_EXCEEDS_LIMIT',
                ];
            }

            // For deduction operations
            if ($operation === 'deduct') {
                $currentBalance = $user->balance ?? 0;
                if ($currentBalance < $amount) {
                    return [
                        'valid' => false,
                        'message' => 'Insufficient balance. Current: Rp ' . number_format($currentBalance) . ', Required: Rp ' . number_format($amount),
                        'error_code' => 'INSUFFICIENT_BALANCE',
                    ];
                }
            }

            return [
                'valid' => true,
                'message' => 'Validation passed',
            ];

        } catch (Exception $e) {
            Log::error('Balance validation failed', [
                'user_id' => $user->id ?? null,
                'amount' => $amount,
                'operation' => $operation,
                'error' => $e->getMessage(),
            ]);

            return [
                'valid' => false,
                'message' => 'Validation failed: ' . $e->getMessage(),
                'error_code' => 'VALIDATION_ERROR',
            ];
        }
    }
}