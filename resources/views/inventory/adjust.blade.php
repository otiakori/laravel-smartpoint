@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Adjust Stock</h1>
            <p class="text-gray-600 mt-2">Add or subtract inventory for {{ $product->name }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Product Info -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Product Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Product Name:</span>
                        <p class="text-sm text-gray-900">{{ $product->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Current Stock:</span>
                        <p class="text-sm text-gray-900">{{ $product->stock_quantity }} units</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Category:</span>
                        <p class="text-sm text-gray-900">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Adjustment Form -->
            <form action="{{ route('inventory.process-adjustment', $product) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="adjustment_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Adjustment Type <span class="text-red-500">*</span>
                        </label>
                        <select id="adjustment_type" 
                                name="adjustment_type" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select adjustment type</option>
                            <option value="add">Add Stock (+)</option>
                            <option value="subtract">Subtract Stock (-)</option>
                        </select>
                        @error('adjustment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="quantity" 
                               name="quantity" 
                               min="1" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter quantity">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason <span class="text-red-500">*</span>
                        </label>
                        <select id="reason" 
                                name="reason" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select a reason</option>
                            <option value="damage">Damaged Goods</option>
                            <option value="theft">Theft/Loss</option>
                            <option value="expiry">Expired Goods</option>
                            <option value="return">Customer Return</option>
                            <option value="found">Found Stock</option>
                            <option value="correction">Stock Correction</option>
                            <option value="other">Other</option>
                        </select>
                        @error('reason')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="adjustment_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Adjustment Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="adjustment_date" 
                               name="adjustment_date" 
                               required
                               value="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('adjustment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Additional details about this adjustment..."></textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            Process Adjustment
                        </button>
                        <a href="{{ route('inventory.show', $product) }}" 
                           class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors text-center">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 