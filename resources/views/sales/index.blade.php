@extends('layouts.dashboard')

@section('title', 'Sales Management')

@section('page-title', 'Sales Management')

@section('page-content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-500">Total Sales</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($totalSales) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-500">Total Revenue</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ formatCurrency($totalRevenue) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-500">Today's Sales</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ number_format($todaySales) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-500">Today's Revenue</p>
                    <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ formatCurrency($todayRevenue) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Filters</h3>
        </div>
        <div class="px-4 sm:px-6 py-4">
            <form method="GET" action="{{ route('sales.index') }}" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Sale ID or Customer name"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Customer Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                    <select name="customer_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select name="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Methods</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Sort By -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select name="sort_by" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="created_at" {{ request('sort_by', 'created_at') == 'created_at' ? 'selected' : '' }}>Date</option>
                        <option value="total_amount" {{ request('sort_by') == 'total_amount' ? 'selected' : '' }}>Amount</option>
                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Sale ID</option>
                    </select>
                </div>

                <!-- Sort Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <select name="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="sm:col-span-2 lg:col-span-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Apply Filters
                    </button>
                    <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Filtered Statistics -->
    @if(request()->hasAny(['search', 'customer_id', 'date_from', 'date_to', 'payment_method', 'status']))
    <div class="bg-blue-50 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm font-medium text-blue-800">
                Filtered Results: {{ $filteredStats['count'] }} sales, 
                                Total: {{ formatCurrency($filteredStats['total_amount']) }},
                Average: {{ formatCurrency($filteredStats['avg_amount']) }}
            </span>
        </div>
    </div>
    @endif

    <!-- Sales Cards (Mobile) and Table (Desktop) -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Sales Records</h3>
        </div>
        
        <!-- Mobile Card Layout -->
        <div class="lg:hidden">
            <div class="space-y-4 p-4">
                @forelse($sales as $sale)
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">{{ substr($sale->customer->name ?? 'N/A', 0, 1) }}</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">#{{ $sale->id }}</h4>
                                <p class="text-sm text-gray-600">{{ $sale->customer->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ formatCurrency($sale->total_amount) }}</p>
                            <p class="text-xs text-gray-500">{{ $sale->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <!-- Details -->
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Items</p>
                            <p class="font-medium">{{ $sale->saleItems->count() }} items</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Payment</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($sale->payment_method == 'cash') bg-green-100 text-green-800
                                @elseif($sale->payment_method == 'card') bg-blue-100 text-blue-800
                                @elseif($sale->payment_method == 'bank_transfer') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500">Status</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($sale->status == 'completed') bg-green-100 text-green-800
                                @elseif($sale->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-500">Time</p>
                            <p class="font-medium">{{ $sale->created_at->format('h:i A') }}</p>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="flex space-x-2 pt-2 border-t border-gray-200">
                        <a href="{{ route('sales.show', $sale) }}" class="flex-1 bg-blue-50 text-blue-700 px-3 py-2 rounded-lg text-center text-sm font-medium hover:bg-blue-100">
                            View Details
                        </a>
                        <a href="{{ route('pos.receipt', $sale) }}" class="flex-1 bg-green-50 text-green-700 px-3 py-2 rounded-lg text-center text-sm font-medium hover:bg-green-100">
                            Receipt
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No sales found</h3>
                    <p class="text-gray-500">No sales match your current filters. Try adjusting your search criteria.</p>
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Desktop Table Layout -->
        <div class="hidden lg:block">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sales as $sale)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">#{{ $sale->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-600">{{ substr($sale->customer->name ?? 'N/A', 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $sale->customer->name ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $sale->customer->phone ?? 'No phone' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $sale->saleItems->count() }} items</div>
                                <div class="text-sm text-gray-500">
                                    @foreach($sale->saleItems->take(2) as $item)
                                        {{ $item->product->name ?? 'Unknown' }}{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                    @if($sale->saleItems->count() > 2)
                                        +{{ $sale->saleItems->count() - 2 }} more
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ formatCurrency($sale->total_amount) }}</div>
                                @if($sale->discount_amount > 0)
                                    <div class="text-sm text-green-600">-{{ formatCurrency($sale->discount_amount) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($sale->payment_method == 'cash') bg-green-100 text-green-800
                                    @elseif($sale->payment_method == 'card') bg-blue-100 text-blue-800
                                    @elseif($sale->payment_method == 'bank_transfer') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($sale->status == 'completed') bg-green-100 text-green-800
                                    @elseif($sale->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $sale->created_at->format('M d, Y') }}
                                <div class="text-xs text-gray-400">{{ $sale->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <a href="{{ route('pos.receipt', $sale) }}" class="text-green-600 hover:text-green-900">Receipt</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No sales found</h3>
                                    <p class="text-gray-500">No sales match your current filters. Try adjusting your search criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($sales->hasPages())
        <div class="px-4 sm:px-6 py-3 border-t border-gray-200">
            {{ $sales->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 