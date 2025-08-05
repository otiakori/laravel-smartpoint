@extends('layouts.dashboard')

@section('page-title', 'Create Invoice')

@section('page-content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Create Invoice</h1>
                <p class="mt-2 text-gray-600">Create a new invoice for your customer</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('invoices.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-smartpoint-red transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Invoices
                </a>
            </div>
        </div>
    </div>

    <!-- Invoice Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
            @csrf
            
            <!-- Invoice Details -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Customer -->
                    <div>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                        <select name="customer_id" id="customer_id" class="block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Invoice Date -->
                    <div>
                        <label for="invoice_date" class="block text-sm font-medium text-gray-700 mb-2">Invoice Date</label>
                        <input type="date" name="invoice_date" id="invoice_date" value="{{ old('invoice_date', date('Y-m-d')) }}" class="block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red">
                        @error('invoice_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reference Number -->
                    <div>
                        <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">Reference Number</label>
                        <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" placeholder="PO-12345" class="block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red">
                        @error('reference_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Invoice Items</h3>
                    <button type="button" id="addItemBtn" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-smartpoint-red bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-smartpoint-red transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Item
                    </button>
                </div>

                <div id="invoiceItems" class="space-y-4">
                    <!-- Item template will be added here -->
                </div>
            </div>

            <!-- Invoice Summary -->
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Summary</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <textarea name="notes" id="notes" rows="3" placeholder="Additional notes for the customer..." class="block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms & Conditions -->
                    <div>
                        <label for="terms_conditions" class="block text-sm font-medium text-gray-700 mb-2">Terms & Conditions</label>
                        <textarea name="terms_conditions" id="terms_conditions" rows="3" placeholder="Payment terms and conditions..." class="block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red">{{ old('terms_conditions') }}</textarea>
                        @error('terms_conditions')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Totals -->
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div class="text-lg font-medium text-gray-900">Total Amount: <span id="totalAmount" class="text-smartpoint-red">$0.00</span></div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="window.history.back()" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-smartpoint-red transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-smartpoint-red text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-smartpoint-red transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create Invoice
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Item Template (hidden) -->
<template id="itemTemplate">
    <div class="item-row bg-gray-50 rounded-lg p-4 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <!-- Product Selection -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                <select name="items[{index}][product_id]" class="product-select block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}">
                            {{ $product->name }} - {{ formatCurrency($product->price) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Item Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                <input type="text" name="items[{index}][item_name]" class="item-name block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red" required>
            </div>

            <!-- Quantity -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Qty</label>
                <input type="number" name="items[{index}][quantity]" class="item-quantity block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red" min="1" value="1" required>
            </div>

            <!-- Unit Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                <input type="number" name="items[{index}][unit_price]" class="item-price block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red" step="0.01" min="0" required>
            </div>

            <!-- Tax Rate -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tax %</label>
                <input type="number" name="items[{index}][tax_rate]" class="item-tax block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red" step="0.01" min="0" max="100" value="0">
            </div>

            <!-- Discount -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Discount</label>
                <input type="number" name="items[{index}][discount_amount]" class="item-discount block w-full border-gray-300 rounded-lg focus:ring-smartpoint-red focus:border-smartpoint-red" step="0.01" min="0" value="0">
            </div>

            <!-- Total -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                <input type="text" class="item-total block w-full border-gray-300 rounded-lg bg-gray-100" readonly>
            </div>

            <!-- Remove Button -->
            <div class="flex items-end">
                <button type="button" class="remove-item inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
let itemIndex = 0;

document.addEventListener('DOMContentLoaded', function() {
    const addItemBtn = document.getElementById('addItemBtn');
    const invoiceItems = document.getElementById('invoiceItems');
    const itemTemplate = document.getElementById('itemTemplate');

    addItemBtn.addEventListener('click', function() {
        addItem();
    });

    // Add first item by default
    addItem();

    function addItem() {
        const itemRow = itemTemplate.content.cloneNode(true);
        const itemDiv = itemRow.querySelector('.item-row');
        
        // Update all input names with current index
        itemDiv.querySelectorAll('[name*="{index}"]').forEach(input => {
            input.name = input.name.replace('{index}', itemIndex);
        });

        // Add event listeners for calculations
        const quantityInput = itemDiv.querySelector('.item-quantity');
        const priceInput = itemDiv.querySelector('.item-price');
        const taxInput = itemDiv.querySelector('.item-tax');
        const discountInput = itemDiv.querySelector('.item-discount');
        const totalInput = itemDiv.querySelector('.item-total');
        const productSelect = itemDiv.querySelector('.product-select');
        const nameInput = itemDiv.querySelector('.item-name');

        // Product selection handler
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                priceInput.value = selectedOption.dataset.price;
                nameInput.value = selectedOption.dataset.name;
                calculateItemTotal();
            }
        });

        // Calculation handlers
        [quantityInput, priceInput, taxInput, discountInput].forEach(input => {
            input.addEventListener('input', calculateItemTotal);
        });

        // Remove button handler
        itemDiv.querySelector('.remove-item').addEventListener('click', function() {
            if (invoiceItems.children.length > 1) {
                itemDiv.remove();
                calculateInvoiceTotal();
            }
        });

        function calculateItemTotal() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const taxRate = parseFloat(taxInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            const subtotal = quantity * price;
            const taxAmount = (subtotal * taxRate) / 100;
            const total = subtotal + taxAmount - discount;

            totalInput.value = total.toFixed(2);
            calculateInvoiceTotal();
        }

        invoiceItems.appendChild(itemDiv);
        itemIndex++;
    }

    function calculateInvoiceTotal() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('totalAmount').textContent = '$' + total.toFixed(2);
    }
});
</script>
@endsection 