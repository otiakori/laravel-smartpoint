@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Restock Product</h1>
            <p class="text-gray-600 mt-2">Add inventory to {{ $product->name }}</p>
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
                        <span class="text-sm font-medium text-gray-500">Current Cost Price:</span>
                        <p class="text-sm text-gray-900">${{ number_format($product->cost_price, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Restock Form -->
            <form action="{{ route('inventory.process-restock', $product) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Quantity to Add <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="quantity" 
                               name="quantity" 
                               min="1" 
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter quantity to add">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cost_per_unit" class="block text-sm font-medium text-gray-700 mb-2">
                            Cost per Unit <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                            <input type="number" 
                                   id="cost_per_unit" 
                                   name="cost_per_unit" 
                                   step="0.01" 
                                   min="0" 
                                   required
                                   value="{{ $product->cost_price }}"
                                   class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="0.00">
                        </div>
                        @error('cost_per_unit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier" class="block text-sm font-medium text-gray-700 mb-2">
                            Supplier
                        </label>
                        <input type="text" 
                               id="supplier" 
                               name="supplier" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Enter supplier name">
                        @error('supplier')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="restock_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Restock Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="restock_date" 
                               name="restock_date" 
                               required
                               value="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('restock_date')
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
                                  placeholder="Any additional notes about this restock..."></textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            Process Restock
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