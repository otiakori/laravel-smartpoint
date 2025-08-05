@extends('layouts.dashboard')

@section('title', 'Sale Details')

@section('page-title', 'Sale Details')

@section('page-content')
<div class="space-y-6">
    <!-- Sale Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Sale #{{ $sale->id }}</h3>
                    <p class="text-sm text-gray-500">{{ $sale->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('pos.receipt', $sale) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Print Receipt
                    </a>
                    <a href="{{ route('sales.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Back to Sales
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sale Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-xl font-medium text-blue-600">{{ $sale->customer ? substr($sale->customer->name ?? 'N/A', 0, 1) : 'N' }}</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $sale->customer->name ?? 'Walk-in Customer' }}</h4>
                            <p class="text-sm text-gray-500">{{ $sale->customer->email ?? 'No email' }}</p>
                            <p class="text-sm text-gray-500">{{ $sale->customer->phone ?? 'No phone' }}</p>
                            @if($sale->customer && $sale->customer->address)
                                <p class="text-sm text-gray-500 mt-1">{{ $sale->customer->address }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sale Items -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Items Sold</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sale->saleItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-600">{{ substr($item->product->name ?? 'Unknown', 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Unknown Product' }}</div>
                                            <div class="text-sm text-gray-500">{{ $item->product->sku ?? 'No SKU' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatCurrency($item->unit_price) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ formatCurrency($item->total_price) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment Information -->
            @if($sale->payments->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Payment History</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        @foreach($sale->payments as $payment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                         <div>
                                 <div class="text-sm font-medium text-gray-900">{{ formatCurrency($payment->amount) }}</div>
                                <div class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">{{ $payment->created_at->format('M d, Y h:i A') }}</div>
                                @if($payment->reference_number)
                                    <div class="text-xs text-gray-400">Ref: {{ $payment->reference_number }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sale Summary -->
        <div class="space-y-6">
            <!-- Sale Summary Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Sale Summary</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                                         <div class="flex justify-between">
                         <span class="text-sm text-gray-500">Subtotal:</span>
                         <span class="text-sm font-medium text-gray-900">{{ formatCurrency($sale->subtotal_amount) }}</span>
                     </div>
                     
                     @if($sale->tax_amount > 0)
                     <div class="flex justify-between">
                         <span class="text-sm text-gray-500">{{ Auth::user()->tenant->tax_name }} ({{ Auth::user()->tenant->tax_rate }}%):</span>
                         <span class="text-sm font-medium text-gray-900">{{ formatCurrency($sale->tax_amount) }}</span>
                     </div>
                     @endif
                     
                     @if($sale->discount_amount > 0)
                     <div class="flex justify-between">
                         <span class="text-sm text-gray-500">Discount:</span>
                         <span class="text-sm font-medium text-green-600">-{{ formatCurrency($sale->discount_amount) }}</span>
                     </div>
                     @endif
                     
                     <div class="border-t border-gray-200 pt-4">
                         <div class="flex justify-between">
                             <span class="text-lg font-medium text-gray-900">Total:</span>
                             <span class="text-lg font-bold text-gray-900">{{ formatCurrency($sale->total_amount) }}</span>
                         </div>
                     </div>
                </div>
            </div>

            <!-- Sale Details Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Sale Details</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <span class="text-sm text-gray-500">Payment Method:</span>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($sale->payment_method == 'cash') bg-green-100 text-green-800
                                @elseif($sale->payment_method == 'card') bg-blue-100 text-blue-800
                                @elseif($sale->payment_method == 'bank_transfer') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-500">Status:</span>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($sale->status == 'completed') bg-green-100 text-green-800
                                @elseif($sale->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-500">Items Count:</span>
                        <div class="mt-1 text-sm font-medium text-gray-900">{{ $sale->saleItems->count() }} items</div>
                    </div>
                    
                    <div>
                        <span class="text-sm text-gray-500">Processed By:</span>
                        <div class="mt-1 text-sm font-medium text-gray-900">{{ $sale->user->name ?? 'Unknown' }}</div>
                    </div>
                    
                    @if($sale->notes)
                    <div>
                        <span class="text-sm text-gray-500">Notes:</span>
                        <div class="mt-1 text-sm text-gray-900">{{ $sale->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="{{ route('pos.receipt', $sale) }}" class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Print Receipt
                    </a>
                    
                    @if($sale->customer)
                    <a href="{{ route('customers.show', $sale->customer) }}" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View Customer
                    </a>
                    @endif
                    
                    <a href="{{ route('sales.index') }}" class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Sales
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 