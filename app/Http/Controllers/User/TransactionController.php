<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\TransactionService;
use App\Services\BalanceService;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    protected $transactionService;
    protected $balanceService;

    public function __construct(TransactionService $transactionService, BalanceService $balanceService)
    {
        $this->transactionService = $transactionService;
        $this->balanceService = $balanceService;
    }

    public function index()
    {
        try {
            $user = Auth::user();
            $transactions = Transaction::where('user_id', $user->id)
                ->with(['course', 'processedBy'])
                ->latest()
                ->paginate(15);

            return view('user.transactions', compact('transactions'));

        } catch (\Exception $e) {
            \Log::error('User transactions index error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load transactions. Please try again.');
        }
    }

    public function topup()
    {
        try {
            return view('user.topup');

        } catch (\Exception $e) {
            \Log::error('User topup view error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load topup page. Please try again.');
        }
    }

    public function processTopup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:10000|max:10000000',
                'payment_method' => 'required|in:bank_transfer,e_wallet,credit_card',
                'reference_number' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $user = Auth::user();
            
            $result = $this->transactionService->processTopup($user, $request->all());

            if ($result['success']) {
                $transaction = $result['data']['transaction'];
                
                // Log user activity
                AuditLog::log(
                    'user_topup_initiated',
                    "User initiated topup of Rp " . number_format($request->amount),
                    Transaction::class,
                    $transaction->id,
                    null,
                    null,
                    [
                        'amount' => $request->amount,
                        'payment_method' => $request->payment_method,
                    ]
                );

                if ($transaction->status === 'success') {
                    return redirect()->route('user.transactions.index')
                        ->with('success', $result['message']);
                } else {
                    return redirect()->route('user.transactions.index')
                        ->with('info', $result['message']);
                }
            } else {
                return back()->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            \Log::error('User topup process error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to process topup. Please try again.');
        }
    }

    public function show(Transaction $transaction)
    {
        try {
            // Check if transaction belongs to current user
            if ($transaction->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access to transaction.');
            }

            $transaction->load(['course', 'processedBy', 'balanceHistories.createdBy']);

            return view('user.transaction-detail', compact('transaction'));

        } catch (\Exception $e) {
            \Log::error('User transaction show error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load transaction details. Please try again.');
        }
    }

    public function balanceHistory()
    {
        try {
            $user = Auth::user();
            $result = $this->balanceService->getBalanceHistory($user);

            if ($result['success']) {
                $balanceHistories = $result['data'];
                return view('user.balance-history', compact('balanceHistories'));
            } else {
                return back()->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            \Log::error('User balance history error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load balance history. Please try again.');
        }
    }

    public function midtransCallback(Request $request)
    {
        try {
            // This would handle Midtrans payment notifications
            // For demo purposes, we'll create a simple callback handler
            
            $transactionId = $request->input('order_id');
            $status = $request->input('transaction_status');
            
            $transaction = Transaction::where('reference_number', $transactionId)->first();
            
            if ($transaction && $transaction->status === 'pending') {
                if ($status === 'settlement' || $status === 'capture') {
                    $result = $this->transactionService->confirmTransaction(
                        $transaction,
                        null, // System confirmation
                        ['notes' => 'Confirmed via payment gateway callback']
                    );

                    if ($result['success']) {
                        \Log::info('Transaction confirmed via callback', [
                            'transaction_id' => $transaction->id,
                            'midtrans_status' => $status,
                        ]);
                    }
                } elseif ($status === 'cancel' || $status === 'expire' || $status === 'deny') {
                    $result = $this->transactionService->rejectTransaction(
                        $transaction,
                        null, // System rejection
                        "Payment {$status} via payment gateway"
                    );

                    if ($result['success']) {
                        \Log::info('Transaction rejected via callback', [
                            'transaction_id' => $transaction->id,
                            'midtrans_status' => $status,
                        ]);
                    }
                }
            }

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            \Log::error('Midtrans callback error: ' . $e->getMessage());
            
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function confirmPayment($transactionId)
    {
        try {
            $transaction = Transaction::where('id', $transactionId)
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->first();

            if (!$transaction) {
                return redirect()->route('user.transactions.index')
                    ->with('error', 'Transaction not found or already processed.');
            }

            // For demo purposes, allow manual confirmation for bank transfer
            if ($transaction->payment_method === 'bank_transfer') {
                $result = $this->transactionService->confirmTransaction(
                    $transaction,
                    null, // User confirmation
                    ['notes' => 'Confirmed by user (demo mode)']
                );

                if ($result['success']) {
                    return redirect()->route('user.transactions.index')
                        ->with('success', 'Payment confirmed successfully! Your balance has been updated.');
                } else {
                    return redirect()->route('user.transactions.index')
                        ->with('error', $result['message']);
                }
            }

            return redirect()->route('user.transactions.index')
                ->with('error', 'This transaction cannot be manually confirmed.');

        } catch (\Exception $e) {
            \Log::error('User payment confirmation error: ' . $e->getMessage());
            
            return redirect()->route('user.transactions.index')
                ->with('error', 'Failed to confirm payment. Please try again.');
        }
    }
}