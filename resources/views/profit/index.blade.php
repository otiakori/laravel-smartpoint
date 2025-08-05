@extends('layouts.dashboard')

@section('title', 'Profit Analysis')

@section('page-title', 'Profit Analysis')

@section('page-content')
<div class="space-y-6">
    <!-- Period Filter -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Filter Period</h3>
        </div>
        <div class="px-6 py-4">
            <form method="GET" action="{{ route('profit.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quick Period</label>
                    <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="week" {{ $period == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ $period == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="quarter" {{ $period == 'quarter' ? 'selected' : '' }}>This Quarter</option>
                        <option value="year" {{ $period == 'year' ? 'selected' : '' }}>This Year</option>
                        <option value="all" {{ $period == 'all' ? 'selected' : '' }}>All Time</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ formatCurrency($profitMetrics['total_revenue']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Cost</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ formatCurrency($profitMetrics['total_cost']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Profit</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ formatCurrency($profitMetrics['total_profit']) }}</p>
                    <p class="text-sm text-gray-500">{{ number_format($profitMetrics['profit_margin'], 1) }}% margin</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Avg Profit/Sale</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ formatCurrency($profitMetrics['avg_profit_per_sale']) }}</p>
                    <p class="text-sm text-gray-500">{{ $profitMetrics['total_sales'] }} sales</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profit Comparison -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Profit Comparison</h3>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Current Period</p>
                    <p class="text-2xl font-bold text-gray-900">{{ formatCurrency($profitComparison['current']) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Previous Period</p>
                    <p class="text-2xl font-bold text-gray-900">{{ formatCurrency($profitComparison['previous']) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Change</p>
                    <div class="flex items-center justify-center">
                        <span class="text-2xl font-bold {{ $profitComparison['trend'] == 'up' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $profitComparison['trend'] == 'up' ? '+' : '' }}{{ number_format($profitComparison['change'], 1) }}%
                        </span>
                        <svg class="w-5 h-5 ml-1 {{ $profitComparison['trend'] == 'up' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($profitComparison['trend'] == 'up')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            @endif
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Profit by Category -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Profit by Category</h3>
            </div>
            <div class="px-6 py-4">
                @if(count($profitByCategory) > 0)
                <div class="space-y-4">
                    @foreach($profitByCategory as $category)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $category['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $category['quantity'] }} items sold</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ formatCurrency($category['profit']) }}</p>
                            <p class="text-xs text-gray-500">{{ $category['revenue'] > 0 ? number_format(($category['profit'] / $category['revenue']) * 100, 1) : 0 }}% margin</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-gray-500">No category data available</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Top Performing Products -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Top Performing Products</h3>
            </div>
            <div class="px-6 py-4">
                @if(count($topProducts) > 0)
                <div class="space-y-4">
                    @foreach($topProducts as $product)
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $product['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $product['quantity'] }} units sold</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ formatCurrency($product['profit']) }}</p>
                            <p class="text-xs text-gray-500">{{ $product['revenue'] > 0 ? number_format(($product['profit'] / $product['revenue']) * 100, 1) : 0 }}% margin</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <p class="text-gray-500">No product data available</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Profit Margins Breakdown -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Profit Margins Breakdown</h3>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Gross Revenue</p>
                    <p class="text-xl font-bold text-gray-900">{{ formatCurrency($profitMargins['revenue']) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Cost of Goods</p>
                    <p class="text-xl font-bold text-red-600">{{ formatCurrency($profitMargins['cost']) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Gross Profit</p>
                    <p class="text-xl font-bold text-green-600">{{ formatCurrency($profitMargins['gross_profit']) }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Gross Margin</p>
                    <p class="text-xl font-bold text-blue-600">{{ number_format($profitMargins['gross_margin'], 1) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Profit Trend Chart -->
    @if(count($dailyProfitTrend) > 0)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daily Profit Trend</h3>
        </div>
        <div class="px-6 py-4">
            <div class="h-64">
                <canvas id="profitTrendChart"></canvas>
            </div>
        </div>
    </div>
    @endif
</div>

@if(count($dailyProfitTrend) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('profitTrendChart').getContext('2d');
    
    const data = @json($dailyProfitTrend);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(item => item.date),
            datasets: [{
                label: 'Revenue',
                data: data.map(item => item.revenue),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.1
            }, {
                label: 'Profit',
                data: data.map(item => item.profit),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endif
@endsection 