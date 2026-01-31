<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
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

    public function index(Request $request)
    {
        try {
            $query = Transaction::with(['user', 'processedBy']);

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by type
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            // Filter by payment method
            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            // Filter by user
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }

            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $transactions = $query->latest()->paginate(20);

            // Get statistics for dashboard cards
            $stats = [
                'pending_count' => Transaction::where('status', 'pending')->count(),
                'confirmed_today' => Transaction::where('status', 'success')->whereDate('updated_at', today())->count(),
                'total_amount_today' => Transaction::whereDate('created_at', today())->sum('amount'),
                'failed_count' => Transaction::where('status', 'failed')->count(),
            ];

            // Get filter options
            $users = User::select('id', 'name')->get();

            return view('bank.transactions.index', compact('transactions', 'users', 'stats'));

        } catch (\Exception $e) {
            \Log::error('Transaction index error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load transactions. Please try again.');
        }
    }

    public function show(Transaction $transaction)
    {
        try {
            $transaction->load(['user', 'processedBy', 'balanceHistories.createdBy']);

            return view('bank.transactions.show', compact('transaction'));

        } catch (\Exception $e) {
            \Log::error('Transaction show error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load transaction details. Please try again.');
        }
    }

    public function confirm(Transaction $transaction)
    {
        try {
            if ($transaction->status !== 'pending') {
                return back()->with('error', 'Transaction is not in pending status.');
            }

            return view('bank.transactions.confirm', compact('transaction'));

        } catch (\Exception $e) {
            \Log::error('Transaction confirm view error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load confirmation page. Please try again.');
        }
    }

    public function processConfirmation(Request $request, Transaction $transaction)
    {
        try {
            $validator = Validator::make($request->all(), [
                'notes' => 'nullable|string|max:1000',
                'confirm' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (!$request->confirm) {
                return back()->with('error', 'Please confirm the transaction.');
            }

            $result = $this->transactionService->confirmTransaction(
                $transaction,
                Auth::user(),
                ['notes' => $request->notes]
            );

            if ($result['success']) {
                AuditLog::log(
                    'transaction_confirmed_via_web',
                    "Transaction {$transaction->id} confirmed via web interface",
                    Transaction::class,
                    $transaction->id,
                    null,
                    null,
                    ['notes' => $request->notes]
                );

                return redirect()->route('bank.transactions.show', $transaction)
                    ->with('success', $result['message']);
            } else {
                return back()->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            \Log::error('Transaction confirmation error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to confirm transaction. Please try again.');
        }
    }

    public function reject(Transaction $transaction)
    {
        try {
            if ($transaction->status !== 'pending') {
                return back()->with('error', 'Transaction is not in pending status.');
            }

            return view('bank.transactions.reject', compact('transaction'));

        } catch (\Exception $e) {
            \Log::error('Transaction reject view error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load rejection page. Please try again.');
        }
    }

    public function processRejection(Request $request, Transaction $transaction)
    {
        try {
            $validator = Validator::make($request->all(), [
                'reason' => 'required|string|max:1000',
                'confirm' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (!$request->confirm) {
                return back()->with('error', 'Please confirm the rejection.');
            }

            $result = $this->transactionService->rejectTransaction(
                $transaction,
                Auth::user(),
                $request->reason
            );

            if ($result['success']) {
                AuditLog::log(
                    'transaction_rejected_via_web',
                    "Transaction {$transaction->id} rejected via web interface",
                    Transaction::class,
                    $transaction->id,
                    null,
                    null,
                    ['reason' => $request->reason]
                );

                return redirect()->route('bank.transactions.show', $transaction)
                    ->with('success', $result['message']);
            } else {
                return back()->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            \Log::error('Transaction rejection error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to reject transaction. Please try again.');
        }
    }

    public function manualTopup(User $user)
    {
        try {
            return view('bank.transactions.manual-topup', compact('user'));

        } catch (\Exception $e) {
            \Log::error('Manual topup view error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to load manual topup page. Please try again.');
        }
    }

    public function processManualTopup(Request $request, User $user)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric|min:1000|max:10000000',
                'notes' => 'required|string|max:1000',
                'reference_number' => 'nullable|string|max:100',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Create manual topup transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'type' => 'topup',
                'amount' => $request->amount,
                'status' => 'success',
                'payment_method' => 'manual',
                'description' => 'Manual topup by bank officer',
                'processed_by' => Auth::id(),
                'processed_at' => now(),
                'bank_notes' => $request->notes,
                'reference_number' => $request->reference_number ?? 'MANUAL_' . time(),
                'fee_amount' => 0,
                'net_amount' => $request->amount,
                'metadata' => [
                    'manual_topup' => true,
                    'processed_by' => Auth::id(),
                    'processed_at' => now(),
                ]
            ]);

            // Add balance
            $balanceResult = $this->balanceService->addBalance(
                $user,
                $request->amount,
                $transaction,
                Auth::user(),
                "Manual topup by bank officer: " . $request->notes
            );

            if ($balanceResult['success']) {
                AuditLog::log(
                    'manual_topup_created',
                    "Manual topup of Rp " . number_format($request->amount) . " created for user {$user->name}",
                    Transaction::class,
                    $transaction->id,
                    null,
                    $transaction->toArray(),
                    [
                        'amount' => $request->amount,
                        'notes' => $request->notes,
                        'reference_number' => $request->reference_number,
                    ]
                );

                return redirect()->route('bank.transactions.show', $transaction)
                    ->with('success', 'Manual topup created successfully.');
            } else {
                return back()->with('error', $balanceResult['message']);
            }

        } catch (\Exception $e) {
            \Log::error('Manual topup error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to process manual topup. Please try again.');
        }
    }

    public function bulkAction(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'transaction_ids' => 'required|array',
                'transaction_ids.*' => 'exists:transactions,id',
                'action' => 'required|in:confirm,reject',
                'notes' => 'nullable|string|max:1000',
                'reason' => 'required_if:action,reject|string|max:1000',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $transactions = Transaction::whereIn('id', $request->transaction_ids)
                ->where('status', 'pending')
                ->get();

            if ($transactions->isEmpty()) {
                return back()->with('error', 'No pending transactions found.');
            }

            $successCount = 0;
            $failCount = 0;

            foreach ($transactions as $transaction) {
                if ($request->action === 'confirm') {
                    $result = $this->transactionService->confirmTransaction(
                        $transaction,
                        Auth::user(),
                        ['notes' => $request->notes]
                    );
                } else {
                    $result = $this->transactionService->rejectTransaction(
                        $transaction,
                        Auth::user(),
                        $request->reason
                    );
                }

                if ($result['success']) {
                    $successCount++;
                } else {
                    $failCount++;
                }
            }

            $message = "Bulk action completed: {$successCount} successful, {$failCount} failed.";
            
            if ($failCount > 0) {
                return back()->with('warning', $message);
            } else {
                return back()->with('success', $message);
            }

        } catch (\Exception $e) {
            \Log::error('Bulk action error: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to process bulk action. Please try again.');
        }
    }
}