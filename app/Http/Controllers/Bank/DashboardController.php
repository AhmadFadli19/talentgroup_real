<?php

namespace App\Http\Controllers\Bank;

use Carbon\Carbon;
use App\Models\User;
use App\Models\AuditLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BalanceHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get statistics
            $stats = [
                'pending_transactions' => Transaction::where('status', 'pending')->count(),
                'today_transactions' => Transaction::whereDate('created_at', today())->count(),
                'total_transaction_amount' => Transaction::where('status', 'success')->sum('amount') ?? 0,
                'total_users' => User::where('role_id', 2)->count(), // Regular users
                'today_topups' => Transaction::where('type', 'topup')
                    ->whereDate('created_at', today())
                    ->count(),
                'pending_topups' => Transaction::where('type', 'topup')
                    ->where('status', 'pending')
                    ->count(),
            ];

            // Get recent pending transactions
            $pendingTransactions = Transaction::where('status', 'pending')
                ->with(['user', 'processedBy'])
                ->latest()
                ->limit(10)
                ->get();

            // Get recent successful transactions
            $recentTransactions = Transaction::where('status', 'success')
                ->with(['user', 'processedBy'])
                ->latest()
                ->limit(10)
                ->get();

            // Get transaction statistics by payment method
            $paymentMethodStats = Transaction::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
                ->where('status', 'success')
                ->groupBy('payment_method')
                ->get();

            // Get daily transaction chart data (last 7 days)
            $dailyStats = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as amount')
            )
                ->where('created_at', '>=', now()->subDays(7))
                ->where('status', 'success')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return view('bank.dashboard', compact(
                'stats',
                'pendingTransactions',
                'recentTransactions',
                'paymentMethodStats',
                'dailyStats'
            ));
        } catch (\Exception $e) {
            Log::error('Bank dashboard error: ' . $e->getMessage());

            return back()->with('error', 'Failed to load dashboard data. Please try again.');
        }
    }

    public function userBalanceHistory(User $user)
    {
        try {
            $balanceHistories = BalanceHistory::where('user_id', $user->id)
                ->with(['transaction', 'createdBy'])
                ->latest()
                ->paginate(20);

            return view('bank.user-balance-history', compact('user', 'balanceHistories'));
        } catch (\Exception $e) {
            Log::error('User balance history error: ' . $e->getMessage());

            return back()->with('error', 'Failed to load balance history. Please try again.');
        }
    }

    public function auditLogs(Request $request)
    {
        try {
            $query = AuditLog::with('user');

            // Filter by action
            if ($request->filled('action')) {
                $query->where('action', $request->action);
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

            $auditLogs = $query->latest()->paginate(50);

            // Get filter options
            $actions = AuditLog::select('action')->distinct()->pluck('action');
            $users = User::select('id', 'name')->get();

            return view('bank.audit-logs', compact('auditLogs', 'actions', 'users'));
        } catch (\Exception $e) {
            Log::error('Audit logs error: ' . $e->getMessage());

            return back()->with('error', 'Failed to load audit logs. Please try again.');
        }
    }

    public function reports(Request $request)
    {
        try {
            $dateFrom = $request->get('date_from', now()->subDays(30)->format('Y-m-d'));
            $dateTo = $request->get('date_to', now()->format('Y-m-d'));

            // Transaction summary
            $transactionSummary = Transaction::selectRaw('
                    COUNT(*) as total_transactions,
                    SUM(CASE WHEN status = "success" THEN amount ELSE 0 END) as total_amount,
                    SUM(CASE WHEN status = "success" THEN fee_amount ELSE 0 END) as total_fees,
                    SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count,
                    SUM(CASE WHEN status = "success" THEN 1 ELSE 0 END) as success_count,
                    SUM(CASE WHEN status = "failed" THEN 1 ELSE 0 END) as failed_count
                ')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->first();

            // Ensure transactionSummary is not null
            if (!$transactionSummary) {
                $transactionSummary = (object) [
                    'total_transactions' => 0,
                    'total_amount' => 0,
                    'total_fees' => 0,
                    'pending_count' => 0,
                    'success_count' => 0,
                    'failed_count' => 0
                ];
            }

            // Top users by transaction amount
            $topUsers = Transaction::select('user_id', DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(*) as transaction_count'))
                ->with('user')
                ->where('status', 'success')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->groupBy('user_id')
                ->orderBy('total_amount', 'desc')
                ->limit(10)
                ->get();

            // Add success rate calculation for top users
            $topUsersWithSuccessRate = $topUsers->map(function ($userTransaction) use ($dateFrom, $dateTo) {
                $user = $userTransaction->user;
                if (!$user) {
                    return null; // Skip if user is null
                }

                $totalTransactions = Transaction::where('user_id', $userTransaction->user_id)
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->count();
                $successTransactions = Transaction::where('user_id', $userTransaction->user_id)
                    ->where('status', 'success')
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->count();

                $user->total_amount = $userTransaction->total_amount ?? 0;
                $user->transactions_count = $totalTransactions;
                $user->success_rate = $totalTransactions > 0 ? ($successTransactions / $totalTransactions) * 100 : 0;

                return $user;
            })->filter(); // Remove null values

            // Payment method breakdown
            $paymentMethodBreakdown = Transaction::select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
                ->where('status', 'success')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->groupBy('payment_method')
                ->get();

            // Get daily transaction volume for chart (last 7 days)
            $volumeData = Transaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
                ->where('created_at', '>=', now()->subDays(7))
                ->where('status', 'success')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $volumeLabels = $volumeData->pluck('date')->map(function ($date) {
                return $date ? Carbon::parse($date)->format('M d') : '';
            })->toArray();

            $volumeCounts = $volumeData->pluck('count')->toArray();

            // Count active users (users who made transactions in the period)
            $activeUsers = Transaction::whereBetween('created_at', [$dateFrom, $dateTo])
                ->distinct('user_id')
                ->count('user_id');

            // Calculate success rate
            $totalTransactions = $transactionSummary->total_transactions ?? 0;
            $successRate = $totalTransactions > 0 ? (($transactionSummary->success_count ?? 0) / $totalTransactions) * 100 : 0;

            // Prepare the reportData array as expected by the view
            $reportData = [
                'total_revenue' => $transactionSummary->total_amount ?? 0,
                'total_transactions' => $transactionSummary->total_transactions ?? 0,
                'success_rate' => $successRate,
                'active_users' => $activeUsers,
                'top_users' => $topUsersWithSuccessRate,
                'volume_labels' => $volumeLabels,
                'volume_data' => $volumeCounts,
                'success_count' => $transactionSummary->success_count ?? 0,
                'pending_count' => $transactionSummary->pending_count ?? 0,
                'failed_count' => $transactionSummary->failed_count ?? 0,
            ];

            return view('bank.reports', compact(
                'reportData',
                'transactionSummary',
                'topUsers',
                'paymentMethodBreakdown',
                'dateFrom',
                'dateTo'
            ));
        } catch (\Exception $e) {
            Log::error('Reports error: ' . $e->getMessage());

            return back()->with('error', 'Failed to generate reports. Please try again.');
        }
    }
}
