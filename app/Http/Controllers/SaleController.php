<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of sales with filtering
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'saleItems.product'])
            ->where('tenant_id', Auth::user()->tenant_id);

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by sale ID or customer name
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('customer', function ($customerQuery) use ($request) {
                      $customerQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $sales = $query->paginate(15);

        // Get customers for filter dropdown
        $customers = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('name')
            ->get();

        // Get statistics
        $totalSales = Sale::where('tenant_id', Auth::user()->tenant_id)->count();
        $totalRevenue = Sale::where('tenant_id', Auth::user()->tenant_id)->sum('total_amount');
        $todaySales = Sale::where('tenant_id', Auth::user()->tenant_id)
            ->whereDate('created_at', today())
            ->count();
        $todayRevenue = Sale::where('tenant_id', Auth::user()->tenant_id)
            ->whereDate('created_at', today())
            ->sum('total_amount');

        // Filtered statistics
        $filteredStats = [
            'count' => $sales->total(),
            'total_amount' => $sales->getCollection()->sum('total_amount'),
            'avg_amount' => $sales->getCollection()->avg('total_amount'),
        ];

        return view('sales.index', compact(
            'sales',
            'customers',
            'totalSales',
            'totalRevenue',
            'todaySales',
            'todayRevenue',
            'filteredStats'
        ));
    }

    /**
     * Display the specified sale
     */
    public function show(Sale $sale)
    {
        // Ensure user can only access their tenant's data
        if ($sale->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $sale->load(['customer', 'saleItems.product', 'payments']);

        return view('sales.show', compact('sale'));
    }

    /**
     * Get sales statistics for dashboard
     */
    public function statistics(Request $request)
    {
        $tenantId = Auth::user()->tenant_id;
        $period = $request->get('period', 'month');

        $query = Sale::where('tenant_id', $tenantId);

        switch ($period) {
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'year':
                $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
                break;
        }

        $statistics = [
            'total_sales' => $query->count(),
            'total_revenue' => $query->sum('total_amount'),
            'avg_sale_amount' => $query->avg('total_amount'),
            'top_customers' => $query->with('customer')
                ->selectRaw('customer_id, COUNT(*) as sale_count, SUM(total_amount) as total_spent')
                ->groupBy('customer_id')
                ->orderBy('total_spent', 'desc')
                ->limit(5)
                ->get(),
        ];

        return response()->json($statistics);
    }
} 