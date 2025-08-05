@extends('layouts.dashboard')

@section('page-title', 'Dashboard')

@section('page-content')
                <!-- Dashboard Header -->
                <div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-gray-600">Here's your business overview for {{ now()->format('l, F j, Y') }}</p>
                </div>
                    <div class="flex items-center space-x-4">
            <div class="bg-smartpoint-red text-white px-4 py-2 rounded-lg text-sm font-medium">
                {{ $tenant->name ?? 'SmartPoint' }}
                    </div>
            <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                Export Report
                    </button>
                            </div>
                        </div>
                    </div>

<!-- Quick Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Today's Revenue -->
    <div class="bg-gradient-to-br from-smartpoint-red to-red-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                <p class="text-sm font-medium text-red-100 mb-1">Today's Revenue</p>
                <p class="text-2xl font-bold mb-2">{{ formatCurrency($todayRevenue) }}</p>
                                <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-300 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                    <span class="text-xs text-green-300 font-medium">{{ $todaySales }} sales today</span>
                                </div>
                            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

    <!-- Total Products -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                <p class="text-sm font-medium text-blue-100 mb-1">Total Products</p>
                <p class="text-2xl font-bold mb-2">{{ number_format($totalProducts) }}</p>
                                <div class="flex items-center">
                    <svg class="w-4 h-4 text-blue-300 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                    <span class="text-xs text-blue-300 font-medium">{{ $lowStockProducts }} low stock</span>
                                </div>
                            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Active Customers -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                <p class="text-sm font-medium text-green-100 mb-1">Active Customers</p>
                <p class="text-2xl font-bold mb-2">{{ number_format($totalCustomers) }}</p>
                                <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-300 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                    <span class="text-xs text-green-300 font-medium">+{{ number_format($customerGrowth, 1) }}% this month</span>
                                </div>
                            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                <p class="text-sm font-medium text-purple-100 mb-1">Total Revenue</p>
                <p class="text-2xl font-bold mb-2">{{ formatCurrency($totalRevenue) }}</p>
                                <div class="flex items-center">
                    <svg class="w-4 h-4 text-purple-300 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                    <span class="text-xs text-purple-300 font-medium">+{{ number_format($revenueGrowth, 1) }}% vs last month</span>
                                </div>
                            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Secondary Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Week Performance -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">This Week</h3>
            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Performance</span>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Sales:</span>
                <span class="text-lg font-bold text-gray-900">{{ $weekSales }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Revenue:</span>
                <span class="text-lg font-bold text-green-600">{{ formatCurrency($weekRevenue) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Avg Order:</span>
                <span class="text-sm font-medium text-gray-900">{{ $weekSales > 0 ? formatCurrency($weekRevenue / $weekSales) : formatCurrency(0) }}</span>
            </div>
        </div>
    </div>

    <!-- Month Performance -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">This Month</h3>
            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Growth</span>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Sales:</span>
                <span class="text-lg font-bold text-gray-900">{{ $monthSales }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Revenue:</span>
                <span class="text-lg font-bold text-green-600">{{ formatCurrency($monthRevenue) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Growth:</span>
                <span class="text-sm font-medium {{ $revenueGrowth >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                </span>
            </div>
        </div>
    </div>

    <!-- Inventory Status -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Inventory</h3>
            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-medium">Alerts</span>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Low Stock:</span>
                <span class="text-lg font-bold text-orange-600">{{ $lowStockProducts }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Out of Stock:</span>
                <span class="text-lg font-bold text-red-600">{{ $outOfStockProducts }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total Products:</span>
                <span class="text-sm font-medium text-gray-900">{{ $totalProducts }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Analytics -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Revenue Trend Chart -->
    <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Revenue Trend (Last 7 Days)</h3>
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 bg-smartpoint-red text-white rounded-lg text-sm font-medium">Revenue</button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200">Orders</button>
                            </div>
                        </div>
        <div class="h-80">
                            <canvas id="revenueChart" width="400" height="200"></canvas>
                        </div>
                    </div>

    <!-- Sales by Category -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sales by Category</h3>
        <div class="h-80">
                            <canvas id="categoryChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

<!-- Top Selling Products & Recent Sales -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Top Selling Products -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">🔥 Top Selling Products</h3>
            <span class="bg-gradient-to-r from-smartpoint-red to-red-600 text-white px-3 py-1 rounded-full text-xs font-semibold">Best Sellers</span>
                    </div>
        <div class="space-y-4">
                        @forelse($topSellingProducts as $index => $product)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                        <div class="w-10 h-10 bg-smartpoint-red rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                        </div>
                                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-smartpoint-red">{{ number_format($product->total_sold) }}</div>
                        <div class="text-sm text-gray-600">{{ formatCurrency($product->total_revenue) }}</div>
                                </div>
                            </div>
                        @empty
                <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <p class="mt-2 text-gray-500">No sales data available</p>
                        </div>
                        @endforelse
                    </div>
                </div>

    <!-- Recent Sales -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">📊 Recent Sales</h3>
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Latest</span>
        </div>
        <div class="space-y-4">
            @forelse($recentSales as $sale)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-smartpoint-red rounded-lg flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-sm">#{{ $sale->id }}</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $sale->customer->name ?? 'Walk-in Customer' }}</h4>
                            <p class="text-sm text-gray-600">{{ $sale->created_at->format('M j, g:i A') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-green-600">{{ formatCurrency($sale->total_amount) }}</div>
                        <div class="text-sm text-gray-600">{{ $sale->payment_method }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="mt-2 text-gray-500">No recent sales</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- AI Insights & Alerts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- AI-Powered Insights -->
    <div class="bg-gradient-to-br from-smartpoint-red to-red-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold">🤖 AI-Powered Insights</h3>
            <span class="bg-white text-smartpoint-red px-3 py-1 rounded-full text-xs font-semibold">PREMIUM</span>
        </div>
        <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium mb-1">Recommendation</p>
                    <p class="text-sm text-red-100">Increase inventory for top-selling products - high demand detected</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium mb-1">Alert</p>
                    <p class="text-sm text-red-100">{{ $lowStockProducts }} products running low on stock</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium mb-1">Opportunity</p>
                    <p class="text-sm text-red-100">Revenue up {{ number_format($revenueGrowth, 1) }}% this month - great performance!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Alerts -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">⚠️ Inventory Alerts</h3>
            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">{{ count($inventoryAlerts) }} Alerts</span>
        </div>
        <div class="space-y-3">
            @forelse($inventoryAlerts as $product)
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $product->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                            </div>
                    <div class="text-right">
                        <div class="text-sm font-bold {{ $product->stock_quantity == 0 ? 'text-red-600' : 'text-orange-600' }}">
                            {{ $product->stock_quantity == 0 ? 'Out of Stock' : $product->stock_quantity . ' left' }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4">
                    <svg class="mx-auto h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">All inventory levels are good!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Payment Methods & Top Customers -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Payment Methods -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 Payment Methods (Last 30 Days)</h3>
        <div class="space-y-3">
            @forelse($paymentMethods as $method)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-smartpoint-red rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-xs">{{ strtoupper(substr($method->payment_method, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ ucfirst($method->payment_method) }}</h4>
                            <p class="text-sm text-gray-600">{{ $method->count }} transactions</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-green-600">{{ formatCurrency($method->total_amount) }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">No payment data available</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Top Customers -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">👥 Top Customers (Last 30 Days)</h3>
        <div class="space-y-3">
            @forelse($topCustomers as $index => $customerData)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-smartpoint-red rounded-lg flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-xs">{{ $index + 1 }}</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $customerData['customer']->name ?? 'Unknown' }}</h4>
                            <p class="text-sm text-gray-600">{{ $customerData['purchase_count'] }} purchases</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-green-600">{{ formatCurrency($customerData['total_spent']) }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500">No customer data available</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueData = @json($revenueTrend);
    
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: revenueData.map(item => item.date),
            datasets: [{
                label: 'Revenue ($)',
                data: revenueData.map(item => item.revenue),
                borderColor: '#DC2626',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#DC2626',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#DC2626',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: $' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + (value / 1000) + 'k';
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 8
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($salesByCategory);
    const categoryLabels = Object.keys(categoryData);
    const categoryValues = Object.values(categoryData);
    
    const colors = [
        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
        '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9'
    ];
    
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryValues,
                backgroundColor: colors.slice(0, categoryLabels.length),
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 4,
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} units (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
});
</script>
@endsection 