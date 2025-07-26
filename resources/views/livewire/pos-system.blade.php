<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between px-4 sm:px-6 py-4">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-smartpoint-red rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="text-xl sm:text-2xl font-bold text-smartpoint-red">SalesPro POS</div>
            </div>

            <!-- User and Shift Info -->
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm text-gray-600">Cashier: {{ Auth::user()->name }}</p>
                    <p class="text-sm text-gray-600">Register: #001</p>
                </div>
                
                <!-- Debug Button -->
                <button wire:click="toggleDebug" 
                        class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 transition-colors text-sm">
                    {{ $debugMode ? 'Hide Debug' : 'Show Debug' }}
                </button>
                
                <button class="bg-smartpoint-red text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center space-x-2 text-sm">
                    <span>End Shift</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <div class="flex flex-col lg:flex-row">
        <!-- Sidebar - Hidden on mobile, shown on desktop -->
        <aside class="hidden lg:block w-20 bg-gray-50 border-r border-gray-200">
            <nav class="mt-8 space-y-4">
                <a href="{{ route('pos.index') }}" class="flex flex-col items-center py-3 px-2 bg-smartpoint-red text-white rounded-lg mx-2">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-xs">POS</span>
                </a>
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-3 px-2 text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg mx-2 transition-colors">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span class="text-xs">Dashboard</span>
                </a>
                <a href="#" class="flex flex-col items-center py-3 px-2 text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg mx-2 transition-colors">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="text-xs">Inventory</span>
                </a>
                <a href="#" class="flex flex-col items-center py-3 px-2 text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg mx-2 transition-colors">
                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="text-xs">Customers</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:flex-row">
            <!-- Product Display Area -->
            <div class="flex-1 p-4 lg:p-6">
                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               wire:model.live.debounce.300ms="searchQuery"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                               placeholder="Search products...">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Category Tabs -->
                <div class="mb-6">
                    <div class="flex space-x-2 overflow-x-auto pb-2">
                        <button wire:click="selectCategory('all')" 
                                class="px-4 py-2 rounded-lg font-medium transition-colors whitespace-nowrap {{ $selectedCategory === 'all' ? 'bg-smartpoint-red text-white' : 'bg-gray-200 text-gray-700' }}">
                            All
                        </button>
                        @foreach($this->categories as $category)
                            <button wire:click="selectCategory('{{ $category->name }}')" 
                                    class="px-4 py-2 rounded-lg font-medium transition-colors whitespace-nowrap {{ $selectedCategory === $category->name ? 'bg-smartpoint-red text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Debug Info (only show in debug mode) -->
                @if($debugMode)
                    <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 rounded-lg">
                        <h3 class="font-bold text-yellow-800">Debug Info:</h3>
                        <p><strong>Selected Category:</strong> {{ $selectedCategory }}</p>
                        <p><strong>Products Count:</strong> {{ $this->products->count() }}</p>
                        <p><strong>Products IDs:</strong> {{ $this->products->pluck('id')->implode(', ') }}</p>
                        <p><strong>Search Query:</strong> {{ $searchQuery ?: 'None' }}</p>
                        
                        <!-- Test Category Buttons -->
                        <div class="mt-4">
                            <h4 class="font-semibold text-yellow-800 mb-2">Test Category Filters:</h4>
                            @foreach($this->categories as $category)
                                <button wire:click="testCategoryFilter('{{ $category->name }}')" 
                                        class="mr-2 mb-2 px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                    Test {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Product Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($this->products as $product)
                        @php
                            $colors = [
                                'yellow' => ['bg' => 'bg-yellow-100', 'icon' => 'bg-yellow-200', 'text' => 'text-yellow-700'],
                                'blue' => ['bg' => 'bg-blue-100', 'icon' => 'bg-blue-200', 'text' => 'text-blue-700'],
                                'green' => ['bg' => 'bg-green-100', 'icon' => 'bg-green-200', 'text' => 'text-green-700'],
                                'purple' => ['bg' => 'bg-purple-100', 'icon' => 'bg-purple-200', 'text' => 'text-purple-700'],
                                'pink' => ['bg' => 'bg-pink-100', 'icon' => 'bg-pink-200', 'text' => 'text-pink-700'],
                                'red' => ['bg' => 'bg-red-100', 'icon' => 'bg-red-200', 'text' => 'text-red-700'],
                                'indigo' => ['bg' => 'bg-indigo-100', 'icon' => 'bg-indigo-200', 'text' => 'text-indigo-700'],
                                'cyan' => ['bg' => 'bg-cyan-100', 'icon' => 'bg-cyan-200', 'text' => 'text-cyan-700'],
                                'orange' => ['bg' => 'bg-orange-100', 'icon' => 'bg-orange-200', 'text' => 'text-orange-700'],
                                'teal' => ['bg' => 'bg-teal-100', 'icon' => 'bg-teal-200', 'text' => 'text-teal-700'],
                                'emerald' => ['bg' => 'bg-emerald-100', 'icon' => 'bg-emerald-200', 'text' => 'text-emerald-700'],
                                'violet' => ['bg' => 'bg-violet-100', 'icon' => 'bg-violet-200', 'text' => 'text-violet-700']
                            ];
                            $colorIndex = crc32($product->name) % count($colors);
                            $colorKeys = array_keys($colors);
                            $colorKey = $colorKeys[$colorIndex];
                            $color = $colors[$colorKey];
                        @endphp
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer border border-gray-100" 
                             wire:click="addToCart({{ $product->id }})">
                            <div class="p-4">
                                <!-- Icon Container -->
                                <div class="flex justify-center mb-4">
                                    <div class="w-16 h-12 {{ $color['icon'] }} rounded-lg flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-8 h-8 object-cover rounded">
                                        @else
                                            @if($product->category && str_contains(strtolower($product->category->name), 'beverage'))
                                                <svg class="w-8 h-8 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @elseif($product->category && str_contains(strtolower($product->category->name), 'food'))
                                                <svg class="w-8 h-8 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            @elseif($product->category && str_contains(strtolower($product->category->name), 'dessert'))
                                                <svg class="w-8 h-8 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 {{ $color['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Product Name -->
                                <h3 class="font-semibold text-gray-900 text-center mb-2 text-sm leading-tight">{{ $product->name }}</h3>
                                
                                <!-- Price and Stock -->
                                <div class="text-center">
                                    <p class="text-red-600 font-bold text-lg mb-1">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-xs {{ $product->stock_quantity <= 5 ? 'text-orange-600 font-medium' : 'text-gray-500' }}">
                                        Stock: {{ $product->stock_quantity }}
                                        @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                                            <span class="ml-1">⚠️</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($this->products->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">No products found</p>
                    </div>
                @endif
            </div>

            <!-- Order Summary Sidebar -->
            <div class="w-full lg:w-96 bg-white border-t lg:border-l lg:border-t-0 border-gray-200 p-4 lg:p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Current Order</h2>
                    <p class="text-sm text-gray-600">Order #{{ time() }}</p>
                </div>

                <!-- Customer Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer (Optional)</label>
                    <select wire:model="selectedCustomer" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select wire:model="paymentMethod" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red">
                        <option value="card">Card</option>
                        <option value="cash">Cash</option>
                        <option value="mobile_money">Mobile Money</option>
                    </select>
                </div>

                <!-- Order Items -->
                <div class="space-y-3 mb-6 max-h-64 overflow-y-auto">
                    @forelse($cart as $index => $item)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3 flex-1">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 text-sm truncate">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-600">${{ number_format($item['price'], 2) }} each</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button wire:click="updateQuantity({{ $index }}, -1)" 
                                        class="w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center hover:bg-gray-300"
                                        @if($item['quantity'] <= 1) disabled @endif>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span class="w-6 text-center font-medium text-sm">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity({{ $index }}, 1)" 
                                        class="w-6 h-6 bg-smartpoint-red text-white rounded-full flex items-center justify-center hover:bg-red-700">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                                <button wire:click="removeFromCart({{ $index }})" 
                                        class="w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center hover:bg-red-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            <p class="text-sm">No items in cart</p>
                        </div>
                    @endforelse
                </div>

                <!-- Order Summary -->
                <div class="border-t border-gray-200 pt-4 mb-6">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($this->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Tax (8.5%):</span>
                        <span>${{ number_format($this->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg text-smartpoint-red">
                        <span>Total:</span>
                        <span>${{ number_format($this->total, 2) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button wire:click="processSale" 
                            wire:loading.attr="disabled"
                            @if(empty($cart)) disabled @endif
                            class="w-full bg-smartpoint-red text-white py-3 px-4 rounded-lg font-semibold hover:bg-red-700 disabled:bg-gray-400 transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span wire:loading.remove>Process Payment</span>
                        <span wire:loading>Processing...</span>
                    </button>

                    @if(!empty($cart))
                        <button wire:click="clearCart" 
                                class="w-full bg-gray-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-gray-600 transition-colors">
                            Clear Cart
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Bar -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2">
        <div class="flex justify-around">
            <a href="{{ route('pos.index') }}" class="flex flex-col items-center py-2 text-smartpoint-red">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <span class="text-xs">POS</span>
            </a>
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 text-gray-600">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                <span class="text-xs">Dashboard</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 text-gray-600">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="text-xs">Inventory</span>
            </a>
            <a href="#" class="flex flex-col items-center py-2 text-gray-600">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-xs">Customers</span>
            </a>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 shadow-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Livewire Error Messages -->
    @if($errors->any())
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Debug JavaScript -->
    <script>
        document.addEventListener('livewire:init', () => {
            // Listen for category changes
            Livewire.on('category-changed', (event) => {
                console.log('Category changed to:', event.category);
            });
            
            // Debug click events on product cards
            document.addEventListener('click', function(e) {
                if (e.target.closest('[wire\\:click*="addToCart"]')) {
                    console.log('Product card clicked:', e.target.closest('[wire\\:click*="addToCart"]'));
                }
            });
        });
    </script>
</div> 