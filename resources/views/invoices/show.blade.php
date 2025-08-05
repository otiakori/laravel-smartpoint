@extends('layouts.dashboard')

@section('page-title', 'Invoice Details')

@section('page-content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Invoice #{{ $invoice->invoice_number }}</h1>
                <p class="mt-2 text-gray-600">Invoice details and management</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-smartpoint-red transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Invoices
                </a>
                <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Invoice
                </a>
            </div>
        </div>
    </div>

    <!-- Status Actions -->
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $invoice->status_color }}-100 text-{{ $invoice->status_color }}-800">
                            {{ ucfirst($invoice->invoice_status) }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Payment:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $invoice->payment_status_color }}-100 text-{{ $invoice->payment_status_color }}-800">
                            {{ ucfirst($invoice->payment_status) }}
                        </span>
                    </div>
                    @if($invoice->is_overdue)
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-red-700">Overdue:</span>
                            <span class="text-sm text-red-600">{{ $invoice->days_overdue }} days</span>
                        </div>
                    @endif
                </div>
                <div class="flex items-center space-x-2">
                    @if($invoice->invoice_status === 'draft')
                        <form action="{{ route('invoices.mark-as-sent', $invoice) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Mark as Sent
                            </button>
                        </form>
                    @endif
                    @if(in_array($invoice->payment_status, ['pending', 'partial']))
                        <form action="{{ route('invoices.mark-as-paid', $invoice) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mark as Paid
                            </button>
                        </form>
                    @endif
                    @if($invoice->invoice_status !== 'cancelled')
                        <form action="{{ route('invoices.mark-as-cancelled', $invoice) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel Invoice
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Invoice Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Information</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Invoice Number:</span>
                    <p class="text-sm text-gray-900">{{ $invoice->invoice_number }}</p>
                </div>
                @if($invoice->reference_number)
                    <div>
                        <span class="text-sm font-medium text-gray-500">Reference:</span>
                        <p class="text-sm text-gray-900">{{ $invoice->reference_number }}</p>
                    </div>
                @endif
                <div>
                    <span class="text-sm font-medium text-gray-500">Invoice Date:</span>
                    <p class="text-sm text-gray-900">{{ $invoice->invoice_date->format('M d, Y') }}</p>
                </div>
                @if($invoice->due_date)
                    <div>
                        <span class="text-sm font-medium text-gray-500">Due Date:</span>
                        <p class="text-sm text-gray-900">{{ $invoice->due_date->format('M d, Y') }}</p>
                    </div>
                @endif
                <div>
                    <span class="text-sm font-medium text-gray-500">Created By:</span>
                    <p class="text-sm text-gray-900">{{ $invoice->user->name }}</p>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
            @if($invoice->customer)
                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Name:</span>
                        <p class="text-sm text-gray-900">{{ $invoice->customer->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Email:</span>
                        <p class="text-sm text-gray-900">{{ $invoice->customer->email }}</p>
                    </div>
                    @if($invoice->customer->phone)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Phone:</span>
                            <p class="text-sm text-gray-900">{{ $invoice->customer->phone }}</p>
                        </div>
                    @endif
                    @if($invoice->customer->address)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Address:</span>
                            <p class="text-sm text-gray-900">{{ $invoice->customer->address }}</p>
                        </div>
                    @endif
                </div>
            @else
                <p class="text-sm text-gray-500">No customer assigned</p>
            @endif
        </div>

        <!-- Payment Summary -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Summary</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Subtotal:</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency($invoice->subtotal) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Tax:</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency($invoice->tax_amount) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Discount:</span>
                    <span class="text-sm text-gray-900">{{ formatCurrency($invoice->discount_amount) }}</span>
                </div>
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between">
                        <span class="text-lg font-medium text-gray-900">Total:</span>
                        <span class="text-lg font-bold text-smartpoint-red">{{ formatCurrency($invoice->total_amount) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Invoice Items</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item->item_name }}</div>
                                @if($item->product)
                                    <div class="text-sm text-gray-500">{{ $item->product->category->name ?? 'Uncategorized' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $item->description ?: 'No description' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ formatCurrency($item->unit_price) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ formatCurrency($item->tax_amount) }}</div>
                                <div class="text-xs text-gray-500">{{ $item->tax_rate }}%</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ formatCurrency($item->discount_amount) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ formatCurrency($item->total_amount) }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notes and Terms -->
    @if($invoice->notes || $invoice->terms_conditions)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @if($invoice->notes)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Notes</h3>
                    <p class="text-sm text-gray-700">{{ $invoice->notes }}</p>
                </div>
            @endif

            @if($invoice->terms_conditions)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Terms & Conditions</h3>
                    <p class="text-sm text-gray-700">{{ $invoice->terms_conditions }}</p>
                </div>
            @endif
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <form action="{{ route('invoices.duplicate', $invoice) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-smartpoint-red transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Duplicate Invoice
                </button>
            </form>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Invoice
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white !important;
    }
    .bg-white {
        background: white !important;
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
}
</style>
@endsection 