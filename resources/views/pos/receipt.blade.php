@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-smartpoint-red text-white p-6 text-center">
            <h1 class="text-2xl font-bold">SalesPro POS</h1>
            <p class="text-sm opacity-90">Receipt</p>
        </div>

        <!-- Receipt Content -->
        <div class="p-6">
            <!-- Sale Info -->
            <div class="text-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Sale #{{ $sale->sale_number }}</h2>
                <p class="text-sm text-gray-600">{{ $sale->sale_date->format('M d, Y h:i A') }}</p>
                <p class="text-sm text-gray-600">Cashier: {{ $sale->user->name }}</p>
                @if($sale->customer)
                    <p class="text-sm text-gray-600">Customer: {{ $sale->customer->name }}</p>
                @endif
            </div>

            <!-- Items -->
            <div class="border-t border-gray-200 pt-4 mb-4">
                @foreach($sale->saleItems as $item)
                    <div class="flex justify-between items-center py-2">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->quantity }} × {{ formatCurrency($item->unit_price) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">{{ formatCurrency($item->total_price) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Totals -->
            <div class="border-t border-gray-200 pt-4">
                <div class="flex justify-between text-sm mb-2">
                    <span>Subtotal:</span>
                                            <span>{{ formatCurrency($sale->subtotal) }}</span>
                </div>
                                @if($sale->tax_amount > 0)
                    <div class="flex justify-between text-sm mb-2">
                        <span>{{ Auth::user()->tenant->tax_name }} ({{ Auth::user()->tenant->tax_rate }}%):</span>
                        <span>{{ formatCurrency($sale->tax_amount) }}</span>
                    </div>
                @endif
                @if($sale->discount_amount > 0)
                    <div class="flex justify-between text-sm mb-2">
                        <span>Discount:</span>
                        <span>-{{ formatCurrency($sale->discount_amount) }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-lg text-smartpoint-red border-t border-gray-200 pt-2">
                    <span>Total:</span>
                                            <span>{{ formatCurrency($sale->total_amount) }}</span>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Payment Method: {{ ucfirst($sale->payment_method) }}</p>
                <p class="text-sm text-gray-600">Status: {{ ucfirst($sale->payment_status) }}</p>
            </div>

            <!-- Thank You -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">Thank you for your purchase!</p>
                <p class="text-xs text-gray-500 mt-2">Please come again</p>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-gray-50 px-6 py-4">
            <div class="flex space-x-3">
                <button onclick="window.print()" class="flex-1 bg-smartpoint-red text-white py-2 px-4 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    Print Receipt
                </button>
                <a href="{{ route('pos.index') }}" class="flex-1 bg-gray-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-600 transition-colors text-center">
                    New Sale
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .max-w-md, .max-w-md * {
        visibility: visible;
    }
    .max-w-md {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .bg-gray-50 {
        display: none;
    }
}
</style>
@endsection 