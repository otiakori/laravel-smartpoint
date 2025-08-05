<div>
    <!-- Page Header with Action Buttons -->
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Customer Management</h1>
            <p class="text-sm sm:text-base text-gray-600">Manage your customer relationships and loyalty programs</p>
        </div>
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            <button wire:click="openAddCustomerModal" class="bg-smartpoint-red text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center space-x-2 text-sm sm:text-base">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>+ Add Customer</span>
            </button>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Customers</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ $stats['total_customers'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Active Customers</p>
                    <p class="text-lg sm:text-2xl font-bold text-green-600">{{ $stats['active_customers'] }}</p>
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
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Credit Limit</p>
                    <p class="text-lg sm:text-2xl font-bold text-gray-900">{{ formatCurrency($stats['total_credit_limit']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 sm:ml-4">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Outstanding Balance</p>
                    <p class="text-lg sm:text-2xl font-bold text-red-600">{{ formatCurrency($stats['total_outstanding_balance']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 mb-4 sm:mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search customers..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <select wire:model.live="selectedStatus" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <select wire:model.live="selectedCreditStatus" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                    <option value="">Credit Status</option>
                    <option value="good">Good Standing</option>
                    <option value="overdue">Overdue</option>
                    <option value="maxed">Maxed Out</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Mobile Customer Cards -->
    <div class="lg:hidden">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($customers as $customer)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-medium text-blue-600">{{ substr($customer->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $customer->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $customer->email ?? 'No email' }}</p>
                            <p class="text-xs text-gray-500">{{ $customer->phone ?? 'No phone' }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($customer->status === 'active') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($customer->status) }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    Credit: {{ formatCurrency($customer->credit_limit) }}
                                </span>
                            </div>
                            <div class="mt-2 flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    Balance: {{ formatCurrency($customer->outstanding_balance) }}
                                </span>
                                <div class="flex space-x-1">
                                    <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 text-xs">View</a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="text-green-600 hover:text-green-900 text-xs">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No customers found</h3>
                    <p class="text-gray-500">No customers match your current filters.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Desktop Customers Table -->
    <div class="hidden lg:block bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Table Headers -->
        <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
            <div class="grid grid-cols-7 gap-4">
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">CUSTOMER</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">CONTACT</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">CREDIT LIMIT</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">BALANCE</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">CREDIT STATUS</div>
                <div class="text-xs font-medium text-gray-500 uppercase tracking-wider">ACTIONS</div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="divide-y divide-gray-200">
                    @forelse($customers as $customer)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                    <div class="grid grid-cols-7 gap-4 items-center">
                        <!-- Customer -->
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-blue-600">{{ substr($customer->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $customer->name }}</div>
                                <div class="text-sm text-gray-500">#{{ $customer->id }}</div>
                                    </div>
                                </div>

                        <!-- Contact -->
                        <div>
                            <div class="text-sm text-gray-900">{{ $customer->email ?? 'No email' }}</div>
                            <div class="text-sm text-gray-500">{{ $customer->phone ?? 'No phone' }}</div>
                        </div>

                        <!-- Status -->
                        <div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($customer->status === 'active') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($customer->status) }}
                            </span>
                        </div>

                        <!-- Credit Limit -->
                        <div class="text-sm font-semibold text-gray-900">
                            {{ formatCurrency($customer->credit_limit) }}
                        </div>

                        <!-- Balance -->
                        <div class="text-sm text-gray-900">
                            {{ formatCurrency($customer->outstanding_balance) }}
                        </div>

                        <!-- Credit Status -->
                        <div>
                            @php
                                $creditRatio = $customer->credit_limit > 0 ? ($customer->outstanding_balance / $customer->credit_limit) * 100 : 0;
                                $creditStatus = $creditRatio >= 100 ? 'maxed' : ($creditRatio >= 80 ? 'overdue' : 'good');
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($creditStatus === 'good') bg-green-100 text-green-800
                                @elseif($creditStatus === 'overdue') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($creditStatus === 'good')
                                    Good Standing
                                @elseif($creditStatus === 'overdue')
                                    Overdue
                                @else
                                    Maxed Out
                                @endif
                                </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                            <a href="{{ route('customers.edit', $customer) }}" class="text-green-600 hover:text-green-900 text-sm">Edit</a>
                        </div>
                    </div>
                                </div>
                    @empty
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No customers found</h3>
                    <p class="text-gray-500">No customers match your current filters.</p>
                                </div>
                    @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    @endif

    <!-- Add Customer Modal -->
    @if($showAddCustomerModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Customer</h3>
                        <form wire:submit.prevent="addCustomer">
                        <div class="space-y-4">
                                <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" wire:model="customerName" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                           placeholder="Enter customer name">
                                @error('customerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" wire:model="customerEmail" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                           placeholder="Enter email address">
                                @error('customerEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" wire:model="customerPhone" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                           placeholder="Enter phone number">
                                @error('customerPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Credit Limit</label>
                                <input type="number" wire:model="customerCreditLimit" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                                       placeholder="Enter credit limit">
                                @error('customerCreditLimit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select wire:model="customerStatus" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                                @error('customerStatus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="flex space-x-3 mt-6">
                            <button type="submit" class="flex-1 bg-smartpoint-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                Add Customer
                            </button>
                            <button type="button" wire:click="closeAddCustomerModal" class="flex-1 bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
