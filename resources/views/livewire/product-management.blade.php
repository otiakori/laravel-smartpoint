<div>
    <!-- Page Header with Action Buttons -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Product Management</h1>
            <p class="text-gray-600">Manage your inventory and categories</p>
        </div>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <button wire:click="openAddCategoryModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors flex items-center justify-center space-x-2">
                <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                </svg>
                <span>Add Category</span>
            </button>
            <a href="{{ route('products.create') }}" class="bg-smartpoint-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span> Add Product</span>
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Low Stock</p>
                    <p class="text-lg sm:text-2xl font-bold text-red-600">{{ $stats['low_stock'] }}</p>
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
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Value</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ formatCurrency($stats['total_value']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search products..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <select wire:model.live="selectedCategory" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <select wire:model.live="selectedStockStatus" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
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
        <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
            <button wire:click="filterByCategory('all')" 
                    class="px-3 sm:px-4 py-2 rounded-lg font-medium whitespace-nowrap transition-colors text-xs sm:text-sm {{ $selectedCategory === 'all' ? 'bg-smartpoint-red text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All Products
            </button>
                                    @foreach($categories as $category)
                            <button wire:click="filterByCategory('{{ $category->id }}')" 
                        class="px-3 sm:px-4 py-2 rounded-lg font-medium whitespace-nowrap transition-colors text-xs sm:text-sm {{ $selectedCategory == $category->id ? 'bg-smartpoint-red text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                {{ $category->name }} ({{ $category->product_count }})
                            </button>
                        @endforeach
        </div>
    </div>

    <!-- Mobile Product Cards -->
    <div class="lg:hidden">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0
                            @if($product->category && str_contains(strtolower($product->category->name), 'beverage')) bg-yellow-100
                            @elseif($product->category && str_contains(strtolower($product->category->name), 'food')) bg-blue-100
                            @elseif($product->category && str_contains(strtolower($product->category->name), 'snack')) bg-green-100
                            @else bg-gray-100 @endif">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-8 h-8 object-cover rounded">
                            @else
                                <svg class="w-8 h-8 
                                    @if($product->category && str_contains(strtolower($product->category->name), 'beverage')) text-yellow-600
                                    @elseif($product->category && str_contains(strtolower($product->category->name), 'food')) text-blue-600
                                    @elseif($product->category && str_contains(strtolower($product->category->name), 'snack')) text-green-600
                                    @else text-gray-600 @endif" 
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                            <p class="text-xs text-gray-500">#{{ $product->sku ?? 'PRD' . str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-sm font-semibold text-gray-900">{{ formatCurrency($product->price) }}</span>
                                <span class="text-xs {{ $product->stock_quantity <= 5 ? 'text-red-600' : 'text-gray-500' }}">
                                    Stock: {{ $product->stock_quantity }}
                                </span>
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($product->category && str_contains(strtolower($product->category->name), 'beverage')) bg-yellow-100 text-yellow-800
                                    @elseif($product->category && str_contains(strtolower($product->category->name), 'food')) bg-blue-100 text-blue-800
                                    @elseif($product->category && str_contains(strtolower($product->category->name), 'snack')) bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                                <div class="flex space-x-1">
                                    <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 text-xs">Edit</a>
                                    <button wire:click="deleteProduct({{ $product->id }})" class="text-red-600 hover:text-red-900 text-xs">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">No products match your current filters.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Desktop Products Table -->
    <div class="hidden lg:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
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
                            {{ formatCurrency($product->price) }}
                        </div>

                        <!-- Stock -->
                        <div class="text-sm text-gray-900">
                            {{ $product->stock_quantity }}
                        </div>

                        <!-- Status -->
                        <div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($product->stock_quantity > 10) bg-green-100 text-green-800
                                @elseif($product->stock_quantity > 0) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
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
                            <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 text-sm">Edit</a>
                            <button wire:click="deleteProduct({{ $product->id }})" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500">No products match your current filters.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif

    <!-- Add Category Modal -->
    @if($showAddCategoryModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Category</h3>
                        <form wire:submit.prevent="addCategory">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                            <input type="text" wire:model="categoryName" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                           placeholder="Enter category name">
                            @error('categoryName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea wire:model="categoryDescription" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                      placeholder="Enter category description" rows="3"></textarea>
                            @error('categoryDescription') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit" class="flex-1 bg-smartpoint-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                Add Category
                            </button>
                            <button type="button" wire:click="closeAddCategoryModal" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
