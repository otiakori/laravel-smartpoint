<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfitController extends Controller
{
    /**
     * Display profit analysis dashboard
     */
    public function index(Request $request)
    {
        $tenantId = Auth::user()->tenant_id;
        $period = $request->get('period', 'month');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        // Build date range query
        $query = Sale::where('tenant_id', $tenantId);
        
        if ($dateFrom && $dateTo) {
            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        } else {
            switch ($period) {
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
                case 'quarter':
                    $query->whereBetween('created_at', [now()->startOfQuarter(), now()->endOfQuarter()]);
                    break;
                case 'year':
                    $query->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
                    break;
                case 'all':
                    // No date filter for all time
                    break;
            }
        }

        // Get sales with items and products
        $sales = $query->with(['saleItems.product'])->get();

        // Calculate profit metrics
        $profitMetrics = $this->calculateProfitMetrics($sales);
        
        // Get profit by category
        $profitByCategory = $this->getProfitByCategory($sales);
        
        // Get profit by product
        $profitByProduct = $this->getProfitByProduct($sales);
        
        // Get daily profit trend
        $dailyProfitTrend = $this->getDailyProfitTrend($query);
        
        // Get profit comparison (current vs previous period)
        $profitComparison = $this->getProfitComparison($tenantId, $period);
        
        // Get top performing products
        $topProducts = $this->getTopPerformingProducts($sales);
        
        // Get profit margins
        $profitMargins = $this->getProfitMargins($sales);

        return view('profit.index', compact(
            'profitMetrics',
            'profitByCategory',
            'profitByProduct',
            'dailyProfitTrend',
            'profitComparison',
            'topProducts',
            'profitMargins',
            'period',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Calculate profit metrics from sales
     */
    private function calculateProfitMetrics($sales)
    {
        $totalRevenue = 0;
        $totalCost = 0;
        $totalProfit = 0;
        $totalSales = $sales->count();

        foreach ($sales as $sale) {
            $saleRevenue = $sale->total_amount;
            $saleCost = 0;
            
            foreach ($sale->saleItems as $item) {
                $product = $item->product;
                if ($product) {
                    $saleCost += ($product->cost_price ?? 0) * $item->quantity;
                }
            }
            
            $saleProfit = $saleRevenue - $saleCost;
            
            $totalRevenue += $saleRevenue;
            $totalCost += $saleCost;
            $totalProfit += $saleProfit;
        }

        $profitMargin = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;
        $avgProfitPerSale = $totalSales > 0 ? $totalProfit / $totalSales : 0;

        return [
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'total_profit' => $totalProfit,
            'profit_margin' => $profitMargin,
            'total_sales' => $totalSales,
            'avg_profit_per_sale' => $avgProfitPerSale,
        ];
    }

    /**
     * Get profit by category
     */
    private function getProfitByCategory($sales)
    {
        $categoryProfits = [];
        
        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                $product = $item->product;
                if ($product && $product->category) {
                    $categoryId = $product->category->id;
                    $categoryName = $product->category->name;
                    
                    $revenue = $item->total_price;
                    $cost = ($product->cost_price ?? 0) * $item->quantity;
                    $profit = $revenue - $cost;
                    
                    if (!isset($categoryProfits[$categoryId])) {
                        $categoryProfits[$categoryId] = [
                            'name' => $categoryName,
                            'revenue' => 0,
                            'cost' => 0,
                            'profit' => 0,
                            'quantity' => 0,
                        ];
                    }
                    
                    $categoryProfits[$categoryId]['revenue'] += $revenue;
                    $categoryProfits[$categoryId]['cost'] += $cost;
                    $categoryProfits[$categoryId]['profit'] += $profit;
                    $categoryProfits[$categoryId]['quantity'] += $item->quantity;
                }
            }
        }

        // Sort by profit descending
        usort($categoryProfits, function($a, $b) {
            return $b['profit'] <=> $a['profit'];
        });

        return array_slice($categoryProfits, 0, 10); // Top 10 categories
    }

    /**
     * Get profit by product
     */
    private function getProfitByProduct($sales)
    {
        $productProfits = [];
        
        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                $product = $item->product;
                if ($product) {
                    $productId = $product->id;
                    $productName = $product->name;
                    
                    $revenue = $item->total_price;
                    $cost = ($product->cost_price ?? 0) * $item->quantity;
                    $profit = $revenue - $cost;
                    
                    if (!isset($productProfits[$productId])) {
                        $productProfits[$productId] = [
                            'name' => $productName,
                            'revenue' => 0,
                            'cost' => 0,
                            'profit' => 0,
                            'quantity' => 0,
                        ];
                    }
                    
                    $productProfits[$productId]['revenue'] += $revenue;
                    $productProfits[$productId]['cost'] += $cost;
                    $productProfits[$productId]['profit'] += $profit;
                    $productProfits[$productId]['quantity'] += $item->quantity;
                }
            }
        }

        // Sort by profit descending
        usort($productProfits, function($a, $b) {
            return $b['profit'] <=> $a['profit'];
        });

        return array_slice($productProfits, 0, 10); // Top 10 products
    }

    /**
     * Get daily profit trend
     */
    private function getDailyProfitTrend($query)
    {
        $dailyData = $query->selectRaw('
            DATE(created_at) as date,
            SUM(total_amount) as revenue,
            COUNT(*) as sales_count
        ')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $trend = [];
        foreach ($dailyData as $day) {
            // Calculate cost for this day (simplified - you might want to join with sale_items)
            $daySales = Sale::where('tenant_id', Auth::user()->tenant_id)
                ->whereDate('created_at', $day->date)
                ->with(['saleItems.product'])
                ->get();
            
            $dayCost = 0;
            foreach ($daySales as $sale) {
                foreach ($sale->saleItems as $item) {
                    $product = $item->product;
                    if ($product) {
                        $dayCost += ($product->cost_price ?? 0) * $item->quantity;
                    }
                }
            }
            
            $trend[] = [
                'date' => $day->date,
                'revenue' => $day->revenue,
                'cost' => $dayCost,
                'profit' => $day->revenue - $dayCost,
                'sales_count' => $day->sales_count,
            ];
        }

        return $trend;
    }

    /**
     * Get profit comparison with previous period
     */
    private function getProfitComparison($tenantId, $period)
    {
        $currentPeriod = $this->getPeriodDates($period);
        $previousPeriod = $this->getPreviousPeriodDates($period);

        $currentProfit = $this->calculatePeriodProfit($tenantId, $currentPeriod['start'], $currentPeriod['end']);
        $previousProfit = $this->calculatePeriodProfit($tenantId, $previousPeriod['start'], $previousPeriod['end']);

        $change = $previousProfit > 0 ? (($currentProfit - $previousProfit) / $previousProfit) * 100 : 0;

        return [
            'current' => $currentProfit,
            'previous' => $previousProfit,
            'change' => $change,
            'trend' => $change >= 0 ? 'up' : 'down',
        ];
    }

    /**
     * Get period dates
     */
    private function getPeriodDates($period)
    {
        switch ($period) {
            case 'week':
                return [
                    'start' => now()->startOfWeek(),
                    'end' => now()->endOfWeek(),
                ];
            case 'month':
                return [
                    'start' => now()->startOfMonth(),
                    'end' => now()->endOfMonth(),
                ];
            case 'quarter':
                return [
                    'start' => now()->startOfQuarter(),
                    'end' => now()->endOfQuarter(),
                ];
            case 'year':
                return [
                    'start' => now()->startOfYear(),
                    'end' => now()->endOfYear(),
                ];
            default:
                return [
                    'start' => now()->startOfMonth(),
                    'end' => now()->endOfMonth(),
                ];
        }
    }

    /**
     * Get previous period dates
     */
    private function getPreviousPeriodDates($period)
    {
        switch ($period) {
            case 'week':
                return [
                    'start' => now()->subWeek()->startOfWeek(),
                    'end' => now()->subWeek()->endOfWeek(),
                ];
            case 'month':
                return [
                    'start' => now()->subMonth()->startOfMonth(),
                    'end' => now()->subMonth()->endOfMonth(),
                ];
            case 'quarter':
                return [
                    'start' => now()->subQuarter()->startOfQuarter(),
                    'end' => now()->subQuarter()->endOfQuarter(),
                ];
            case 'year':
                return [
                    'start' => now()->subYear()->startOfYear(),
                    'end' => now()->subYear()->endOfYear(),
                ];
            default:
                return [
                    'start' => now()->subMonth()->startOfMonth(),
                    'end' => now()->subMonth()->endOfMonth(),
                ];
        }
    }

    /**
     * Calculate profit for a specific period
     */
    private function calculatePeriodProfit($tenantId, $startDate, $endDate)
    {
        $sales = Sale::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['saleItems.product'])
            ->get();

        $totalProfit = 0;
        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                $product = $item->product;
                if ($product) {
                    $revenue = $item->total_price;
                    $cost = ($product->cost_price ?? 0) * $item->quantity;
                    $totalProfit += $revenue - $cost;
                }
            }
        }

        return $totalProfit;
    }

    /**
     * Get top performing products
     */
    private function getTopPerformingProducts($sales)
    {
        $productPerformance = [];
        
        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                $product = $item->product;
                if ($product) {
                    $productId = $product->id;
                    
                    if (!isset($productPerformance[$productId])) {
                        $productPerformance[$productId] = [
                            'name' => $product->name,
                            'quantity' => 0,
                            'revenue' => 0,
                            'profit' => 0,
                        ];
                    }
                    
                    $revenue = $item->total_price;
                    $cost = ($product->cost_price ?? 0) * $item->quantity;
                    $profit = $revenue - $cost;
                    
                    $productPerformance[$productId]['quantity'] += $item->quantity;
                    $productPerformance[$productId]['revenue'] += $revenue;
                    $productPerformance[$productId]['profit'] += $profit;
                }
            }
        }

        // Sort by profit descending
        usort($productPerformance, function($a, $b) {
            return $b['profit'] <=> $a['profit'];
        });

        return array_slice($productPerformance, 0, 5); // Top 5 products
    }

    /**
     * Get profit margins
     */
    private function getProfitMargins($sales)
    {
        $totalRevenue = 0;
        $totalCost = 0;
        
        foreach ($sales as $sale) {
            $totalRevenue += $sale->total_amount;
            
            foreach ($sale->saleItems as $item) {
                $product = $item->product;
                if ($product) {
                    $totalCost += ($product->cost_price ?? 0) * $item->quantity;
                }
            }
        }

        $grossProfit = $totalRevenue - $totalCost;
        $grossMargin = $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0;

        return [
            'revenue' => $totalRevenue,
            'cost' => $totalCost,
            'gross_profit' => $grossProfit,
            'gross_margin' => $grossMargin,
        ];
    }

    /**
     * Export profit report
     */
    public function export(Request $request)
    {
        // This would generate a CSV or PDF report
        // Implementation depends on your needs
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
} 