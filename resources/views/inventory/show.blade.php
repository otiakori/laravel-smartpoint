@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
        <p class="text-gray-600 mt-2">Inventory Details</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Product Information -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Product Information</h2>
                
                <div class="space-y-4">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Product Name:</span>
                        <p class="text-sm text-gray-900">{{ $product->name }}</p>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">SKU:</span>
                        <p class="text-sm text-gray-900">{{ $product->sku ?? 'No SKU' }}</p>
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

            <!-- Stock Information -->
            <div class="bg-white shadow-md rounded-lg p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Stock Information</h2>
                
                <div class="space-y-4">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Current Stock:</span>
                        <p class="text-2xl font-bold text-gray-900">{{ $product->stock_quantity }} units</p>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Cost Price:</span>
                        <p class="text-sm text-gray-900">${{ number_format($product->cost_price, 2) }}</p>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Selling Price:</span>
                        <p class="text-sm text-gray-900">${{ number_format($product->price, 2) }}</p>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-500">Profit Margin:</span>
                        <p class="text-sm text-gray-900">{{ number_format((($product->price - $product->cost_price) / $product->price) * 100, 1) }}%</p>
                    </div>
                </div>

                <!-- Stock Status -->
                <div class="mt-4">
                    @if($product->stock_quantity <= 10)
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="font-medium">Low Stock Alert</span>
                            </div>
                            <p class="text-sm mt-1">Stock is running low. Consider restocking soon.</p>
                        </div>
                    @elseif($product->stock_quantity <= 50)
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <span class="font-medium">Medium Stock</span>
                            </div>
                            <p class="text-sm mt-1">Stock is at moderate levels.</p>
                        </div>
                    @else
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="font-medium">Good Stock Level</span>
                            </div>
                            <p class="text-sm mt-1">Stock is at healthy levels.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow-md rounded-lg p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
                
                <div class="space-y-3">
                    <a href="{{ route('inventory.restock', $product) }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-center block">
                        Restock Product
                    </a>
                    
                    <a href="{{ route('inventory.adjust', $product) }}" 
                       class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-center block">
                        Adjust Stock
                    </a>
                    
                    <a href="{{ route('products.edit', $product) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-center block">
                        Edit Product
                    </a>
                    
                    <a href="{{ route('inventory.index') }}" 
                       class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition-colors text-center block">
                        Back to Inventory
                    </a>
                </div>
            </div>
        </div>

        <!-- Movement History -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Movement History</h2>
                
                @if($movements->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Previous</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Processed By</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($movements as $movement)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $movement->movement_date->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $movement->movement_type === 'sale' ? 'bg-red-100 text-red-800' : 
                                               ($movement->movement_type === 'restock' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($movement->movement_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $movement->previous_quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $movement->new_quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $movement->processedBy->name ?? 'System' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $movements->links() }}
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p class="mt-2">No movement history found for this product.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 