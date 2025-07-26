@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-4">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-smartpoint-red rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="text-2xl font-bold text-gray-900">SalesPro POS</div>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700">Admin: {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-smartpoint-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-20 bg-gray-800">
            <nav class="mt-8 space-y-4">
                <a href="{{ route('pos.index') }}" class="flex flex-col items-center py-3 px-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg mx-2 transition-colors">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-xs">POS</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-3 px-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg mx-2 transition-colors">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span class="text-xs">Dashboard</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex flex-col items-center py-3 px-2 bg-smartpoint-red text-white rounded-lg mx-2">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-xs">Products</span>
                </a>
                <a href="#" class="flex flex-col items-center py-3 px-2 text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg mx-2 transition-colors">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-xs">Customers</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Page Header -->
            <div class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Product Management</h1>
                        <p class="text-gray-600">Manage your inventory and categories</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="openAddCategoryModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            <span>Add Category</span>
                        </button>
                        <a href="{{ route('products.create') }}" class="bg-smartpoint-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>+ Add Product</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Products</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $products->total() }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Categories</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $categories->count() }}</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Low Stock</p>
                                <p class="text-2xl font-bold text-red-600">{{ $products->where('stock_quantity', '<=', 10)->count() }}</p>
                            </div>
                            <div class="p-3 bg-red-100 rounded-lg">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Value</p>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($products->sum('price'), 0) }}</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex-1 max-w-md">
                            <div class="relative">
                                <input type="text" 
                                       id="search" 
                                       placeholder="Search products..." 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <select id="category-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <select id="status-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                                <option value="">Stock Status</option>
                                <option value="in_stock">In Stock</option>
                                <option value="low_stock">Low Stock</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Category Tabs -->
                <div class="mb-6">
                    <div class="flex space-x-2 overflow-x-auto pb-2">
                        <button class="px-4 py-2 bg-smartpoint-red text-white rounded-lg font-medium whitespace-nowrap">
                            All Products
                        </button>
                        @foreach($categories as $category)
                            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium whitespace-nowrap hover:bg-gray-300 transition-colors">
                                {{ $category->name }} ({{ $products->where('category_id', $category->id)->count() }})
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Products Table -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Table Headers -->
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                        <div class="grid grid-cols-6 gap-4">
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">PRODUCT</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">CATEGORY</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">PRICE</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">STOCK</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</div>
                            <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</div>
                        </div>
                    </div>

                    <!-- Table Body -->
                    <div class="divide-y divide-gray-200">
                        @forelse($products as $product)
                            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                                <div class="grid grid-cols-6 gap-4 items-center">
                                    <!-- Product -->
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center
                                            @if($product->category && str_contains(strtolower($product->category->name), 'beverage')) bg-yellow-100
                                            @elseif($product->category && str_contains(strtolower($product->category->name), 'food')) bg-blue-100
                                            @elseif($product->category && str_contains(strtolower($product->category->name), 'snack')) bg-green-100
                                            @else bg-gray-100 @endif">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-6 h-6 object-cover rounded">
                                            @else
                                                <svg class="w-6 h-6 
                                                    @if($product->category && str_contains(strtolower($product->category->name), 'beverage')) text-yellow-600
                                                    @elseif($product->category && str_contains(strtolower($product->category->name), 'food')) text-blue-600
                                                    @elseif($product->category && str_contains(strtolower($product->category->name), 'snack')) text-green-600
                                                    @else text-gray-600 @endif" 
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">#{{ $product->sku ?? 'PRD' . str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($product->category && str_contains(strtolower($product->category->name), 'beverage')) bg-yellow-100 text-yellow-800
                                            @elseif($product->category && str_contains(strtolower($product->category->name), 'food')) bg-blue-100 text-blue-800
                                            @elseif($product->category && str_contains(strtolower($product->category->name), 'snack')) bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>
                                    </div>

                                    <!-- Price -->
                                    <div class="text-sm font-semibold text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </div>

                                    <!-- Stock -->
                                    <div class="text-sm text-gray-900">
                                        {{ $product->stock_quantity }} units
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($product->stock_quantity > 10) bg-green-100 text-green-800
                                            @elseif($product->stock_quantity > 0) bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            @if($product->stock_quantity > 10)
                                                In Stock
                                            @elseif($product->stock_quantity > 0)
                                                Low Stock
                                            @else
                                                Out of Stock
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <button onclick="deleteProduct({{ $product->id }})" class="text-red-600 hover:text-red-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center text-gray-500">
                                No products found. <a href="{{ route('products.create') }}" class="text-smartpoint-red hover:text-red-700">Add your first product</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                        </div>
                        <div class="flex space-x-2">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div id="addCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Add New Category</h3>
                    <button onclick="closeAddCategoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="addCategoryForm" method="POST" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                            <input type="text" 
                                   id="category_name" 
                                   name="name" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                   placeholder="Enter category name">
                        </div>
                        
                        <div>
                            <label for="category_description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                            <textarea id="category_description" 
                                      name="description" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                      placeholder="Enter category description"></textarea>
                        </div>
                    </div>
                    
                    <div class="flex space-x-3 mt-6">
                        <button type="submit" class="flex-1 bg-smartpoint-red text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors">
                            Add Category
                        </button>
                        <button type="button" onclick="closeAddCategoryModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-red-100 rounded-lg mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Delete Product</h3>
                        <p class="text-sm text-gray-600">Are you sure you want to delete this product?</p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button onclick="confirmDelete()" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                    <button onclick="closeDeleteModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let deleteProductId = null;

function openAddCategoryModal() {
    document.getElementById('addCategoryModal').classList.remove('hidden');
}

function closeAddCategoryModal() {
    document.getElementById('addCategoryModal').classList.add('hidden');
    document.getElementById('addCategoryForm').reset();
}

function deleteProduct(productId) {
    deleteProductId = productId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    deleteProductId = null;
}

function confirmDelete() {
    if (deleteProductId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/products/${deleteProductId}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Search functionality
document.getElementById('search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const productRows = document.querySelectorAll('.divide-y > div');
    
    productRows.forEach(row => {
        const productName = row.querySelector('.text-sm.font-semibold')?.textContent.toLowerCase() || '';
        const productSku = row.querySelector('.text-sm.text-gray-500')?.textContent.toLowerCase() || '';
        
        if (productName.includes(searchTerm) || productSku.includes(searchTerm)) {
            row.style.display = 'block';
        } else {
            row.style.display = 'none';
        }
    });
});

// Category filter
document.getElementById('category-filter').addEventListener('change', function() {
    const selectedCategory = this.value;
    const productRows = document.querySelectorAll('.divide-y > div');
    
    productRows.forEach(row => {
        const categoryElement = row.querySelector('.inline-flex');
        if (categoryElement) {
            const categoryId = categoryElement.getAttribute('data-category-id');
            if (!selectedCategory || categoryId === selectedCategory) {
                row.style.display = 'block';
            } else {
                row.style.display = 'none';
            }
        }
    });
});

// Status filter
document.getElementById('status-filter').addEventListener('change', function() {
    const selectedStatus = this.value;
    const productRows = document.querySelectorAll('.divide-y > div');
    
    productRows.forEach(row => {
        const statusElement = row.querySelector('.inline-flex:last-of-type');
        if (statusElement) {
            const status = statusElement.textContent.toLowerCase().replace(' ', '_');
            if (!selectedStatus || status === selectedStatus) {
                row.style.display = 'block';
            } else {
                row.style.display = 'none';
            }
        }
    });
});

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const addCategoryModal = document.getElementById('addCategoryModal');
    const deleteModal = document.getElementById('deleteModal');
    
    if (event.target === addCategoryModal) {
        closeAddCategoryModal();
    }
    
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
});

// Handle category form submission
document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.textContent;
    
    // Disable submit button and show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Adding...';
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            const successDiv = document.createElement('div');
            successDiv.className = 'mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg';
            successDiv.textContent = data.message;
            
            // Insert at the top of the content area
            const contentArea = document.querySelector('.p-6');
            contentArea.insertBefore(successDiv, contentArea.firstChild);
            
            // Close modal and reset form
            closeAddCategoryModal();
            
            // Remove success message after 5 seconds
            setTimeout(() => {
                successDiv.remove();
            }, 5000);
            
            // Reload page to update category lists
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Show error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg';
        errorDiv.textContent = 'An error occurred while creating the category. Please try again.';
        
        // Insert at the top of the content area
        const contentArea = document.querySelector('.p-6');
        contentArea.insertBefore(errorDiv, contentArea.firstChild);
        
        // Remove error message after 5 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    })
    .finally(() => {
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.textContent = originalText;
    });
});
</script>
@endsection 