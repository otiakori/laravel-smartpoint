@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white flex">
    <!-- Fixed Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
            <!-- Sidebar Header -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-white sticky top-0 z-10">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-smartpoint-red rounded-lg flex items-center justify-center">
                        <span class="text-white text-lg font-bold">S</span>
                    </div>
                    <span class="ml-3 text-lg font-semibold text-gray-900 sidebar-text">SmartPoint</span>
                </div>
                <button id="closeSidebar" class="lg:hidden p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Content -->
        <nav class="px-4 py-4">
                <div class="space-y-2">
                                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                @can('access_pos')
                <a href="{{ route('pos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('pos.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span class="sidebar-text">POS</span>
                </a>
                @endcan
                                    @can('view_products')
                <a href="{{ route('products.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('products.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="sidebar-text">Products</span>
                </a>
                @endcan
                @can('view_customers')
                <a href="{{ route('customers.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('customers.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="sidebar-text">Customers</span>
                </a>
                @endcan
                @can('view_suppliers')
                <a href="{{ route('suppliers.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('suppliers.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="sidebar-text">Suppliers</span>
                </a>
                @endcan
                @can('view_purchase_orders')
                <a href="{{ route('purchase-orders.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('purchase-orders.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="sidebar-text">Purchase Orders</span>
                </a>
                @endcan
                @can('view_supplier_payments')
                <a href="{{ route('supplier-payments.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('supplier-payments.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <span class="sidebar-text">Supplier Payments</span>
                </a>
                @endcan
                                    @can('view_installment_plans')
                <a href="{{ route('installment-plans.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('installment-plans.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="sidebar-text">Installment Plans</span>
                </a>
                @endcan
                @can('view_sales')
                <a href="{{ route('sales.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('sales.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="sidebar-text">Sales</span>
                </a>
                @endcan
                @can('view_invoices')
                <a href="{{ route('invoices.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('invoices.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="sidebar-text">Invoices</span>
                </a>
                @endcan
                @can('view_reports')
                <a href="{{ route('profit.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('profit.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span class="sidebar-text">Profit Analysis</span>
                </a>
                @endcan
                @can('view_settings')
                <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('settings.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="sidebar-text">Settings</span>
                </a>
                @endcan
                @can('view_reports')
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="sidebar-text">Reports</span>
                </a>
                @endcan
                
                @can('access_ai_chat')
                <a href="{{ route('chat.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span class="sidebar-text">AI Chat</span>
                </a>
                @endcan
                
                @can('view_users')
                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('users.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <span class="sidebar-text">Users</span>
                </a>
                @endcan
                
                @can('view_roles')
                <a href="{{ route('roles.index') }}" class="flex items-center px-3 py-2 text-sm font-medium {{ request()->routeIs('roles.*') ? 'text-smartpoint-red bg-red-50' : 'text-gray-600 hover:text-smartpoint-red hover:bg-red-50' }} rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="sidebar-text">Roles</span>
                </a>
                @endcan
                </div>

                <!-- Settings Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider sidebar-text">Settings</h3>
                    <div class="mt-2 space-y-2">
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="sidebar-text">Settings</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="sidebar-text">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden hidden"></div>

<!-- Mobile Navigation Bar -->
<div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 z-50">
    <div class="flex justify-around">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('dashboard') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
            </svg>
            <span class="text-xs">Dashboard</span>
        </a>
        <a href="{{ route('pos.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('pos.*') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <span class="text-xs">POS</span>
        </a>
        <a href="{{ route('products.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('products.*') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span class="text-xs">Products</span>
        </a>
        <a href="{{ route('customers.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('customers.*') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="text-xs">Customers</span>
        </a>
        <a href="{{ route('suppliers.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('suppliers.*') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <span class="text-xs">Suppliers</span>
        </a>
        <a href="{{ route('purchase-orders.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('purchase-orders.*') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="text-xs">POs</span>
        </a>
        <a href="{{ route('supplier-payments.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('supplier-payments.*') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
            </svg>
            <span class="text-xs">Payments</span>
        </a>
        <a href="{{ route('sales.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('sales.*') ? 'text-smartpoint-red' : 'text-gray-600' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span class="text-xs">Sales</span>
        </a>
    </div>
</div>

<!-- Main Content Area with Bottom Padding for Mobile Nav -->
<div class="flex-1 lg:ml-64 min-h-screen flex flex-col pb-20 lg:pb-0 min-w-0">
    <!-- Top Header -->
    <header class="bg-white border-b border-gray-200 px-4 py-3 lg:px-6 sticky top-0 z-30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="openSidebar" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <button id="toggleSidebar" class="hidden lg:block p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h1 class="ml-2 text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    </div>

            <!-- User Menu -->
            <div class="relative">
                <button id="userMenuDropdown" class="flex items-center space-x-3">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-smartpoint-red rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50 hidden">
                    <div class="px-4 py-2 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">Welcome, {{ Auth::user()->name }}!</p>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                <span class="text-sm text-gray-700">Dark Mode</span>
                            </div>
                            <button id="themeToggle" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="sr-only">Toggle dark mode</span>
                                <span id="themeToggleThumb" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform translate-x-1"></span>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Other Menu Items -->
                    <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Profile Settings
                        </div>
                    </a>
                    
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </div>
                        </button>
                    </form>
                </div>
            </div>
                </div>
            </header>

        <!-- Scrollable Page Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <div class="p-6">
                @yield('page-content')
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const openSidebarBtn = document.getElementById('openSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    // User menu dropdown functionality
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    const userMenu = document.getElementById('userMenu');

    // Settings dropdown functionality
    const settingsDropdown = document.getElementById('settingsDropdown');
    const settingsMenu = document.getElementById('settingsMenu');
    const themeToggle = document.getElementById('themeToggle');
    const themeToggleThumb = document.getElementById('themeToggleThumb');

    // Theme management
    let isDarkMode = localStorage.getItem('darkMode') === 'true' || '{{ Auth::user()->tenant->theme ?? "light" }}' === 'dark';
    let isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

    function toggleUserMenu() {
        userMenu.classList.toggle('hidden');
    }

    function closeUserMenu() {
        userMenu.classList.add('hidden');
    }
    
    function toggleDropdown() {
        settingsMenu.classList.toggle('hidden');
    }

    function closeDropdown() {
        settingsMenu.classList.add('hidden');
    }

    function toggleSidebar() {
        isSidebarCollapsed = !isSidebarCollapsed;
        localStorage.setItem('sidebarCollapsed', isSidebarCollapsed);
        applySidebarState();
    }

    function applySidebarState() {
        const mainContent = document.querySelector('.flex-1');
        
        if (isSidebarCollapsed) {
            sidebar.classList.add('lg:w-16');
            sidebar.classList.remove('lg:w-64');
            mainContent.classList.add('lg:ml-16');
            mainContent.classList.remove('lg:ml-64');
            document.querySelectorAll('.sidebar-text').forEach(text => {
                text.classList.add('lg:hidden');
            });
        } else {
            sidebar.classList.remove('lg:w-16');
            sidebar.classList.add('lg:w-64');
            mainContent.classList.remove('lg:ml-16');
            mainContent.classList.add('lg:ml-64');
            document.querySelectorAll('.sidebar-text').forEach(text => {
                text.classList.remove('lg:hidden');
            });
        }
    }

    function toggleTheme() {
        isDarkMode = !isDarkMode;
        localStorage.setItem('darkMode', isDarkMode);
        applyTheme();
    }

    function applyTheme() {
        const body = document.body;
        const mainContent = document.querySelector('.flex-1');
        const header = document.querySelector('header');
        const cards = document.querySelectorAll('.bg-white');
        const sidebar = document.getElementById('sidebar');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const headerTitle = document.querySelector('header h1');
        const userInfo = document.querySelector('.text-sm.font-medium');
        const allTexts = document.querySelectorAll('p, span, div, h1, h2, h3, h4, h5, h6');
        const allInputs = document.querySelectorAll('input, select, textarea');
        const allTables = document.querySelectorAll('table');
        const allTableHeaders = document.querySelectorAll('th');
        const allTableCells = document.querySelectorAll('td');
        
        if (isDarkMode) {
            // Dark mode classes
            body.classList.add('dark');
            mainContent.classList.add('bg-gray-900');
            header.classList.add('bg-gray-800', 'border-gray-700');
            header.classList.remove('bg-white', 'border-gray-200');
            sidebar.classList.add('bg-gray-800', 'border-gray-700');
            sidebar.classList.remove('bg-white', 'border-gray-200');
            
            // Update header title
            if (headerTitle) {
                headerTitle.classList.add('text-white');
                headerTitle.classList.remove('text-gray-900');
            }
            
            // Update user info
            if (userInfo) {
                userInfo.classList.add('text-gray-300');
                userInfo.classList.remove('text-gray-700');
            }
            
            // Update sidebar texts
            sidebarTexts.forEach(text => {
                text.classList.add('text-gray-300');
                text.classList.remove('text-gray-900');
            });
            
            // Update cards
            cards.forEach(card => {
                card.classList.add('bg-gray-800', 'border-gray-700');
                card.classList.remove('bg-white', 'border-gray-200');
            });
            
            // Update all text elements
            allTexts.forEach(text => {
                if (text.classList.contains('text-gray-900') && !text.classList.contains('text-smartpoint-red')) {
                    text.classList.add('text-gray-100');
                    text.classList.remove('text-gray-900');
                }
                if (text.classList.contains('text-gray-700')) {
                    text.classList.add('text-gray-300');
                    text.classList.remove('text-gray-700');
                }
                if (text.classList.contains('text-gray-600')) {
                    text.classList.add('text-gray-400');
                    text.classList.remove('text-gray-600');
                }
                if (text.classList.contains('text-gray-500')) {
                    text.classList.add('text-gray-400');
                    text.classList.remove('text-gray-500');
                }
            });
            
            // Update inputs
            allInputs.forEach(input => {
                input.classList.add('bg-gray-700', 'border-gray-600', 'text-white');
                input.classList.remove('bg-white', 'border-gray-300');
            });
            
            // Update tables
            allTables.forEach(table => {
                table.classList.add('bg-gray-800');
                table.classList.remove('bg-white');
            });
            
            allTableHeaders.forEach(th => {
                th.classList.add('bg-gray-700', 'text-gray-200');
                th.classList.remove('bg-gray-50', 'text-gray-500');
            });
            
            allTableCells.forEach(td => {
                td.classList.add('bg-gray-800', 'text-gray-100');
                td.classList.remove('bg-white', 'text-gray-900');
            });
            
            // Update theme toggle
            themeToggle.classList.add('bg-smartpoint-red');
            themeToggle.classList.remove('bg-gray-200');
            themeToggleThumb.classList.add('translate-x-6');
            themeToggleThumb.classList.remove('translate-x-1');
        } else {
            // Light mode classes
            body.classList.remove('dark');
            mainContent.classList.remove('bg-gray-900');
            header.classList.remove('bg-gray-800', 'border-gray-700');
            header.classList.add('bg-white', 'border-gray-200');
            sidebar.classList.remove('bg-gray-800', 'border-gray-700');
            sidebar.classList.add('bg-white', 'border-gray-200');
            
            // Update header title
            if (headerTitle) {
                headerTitle.classList.remove('text-white');
                headerTitle.classList.add('text-gray-900');
            }
            
            // Update user info
            if (userInfo) {
                userInfo.classList.remove('text-gray-300');
                userInfo.classList.add('text-gray-700');
            }
            
            // Update sidebar texts
            sidebarTexts.forEach(text => {
                text.classList.remove('text-gray-300');
                text.classList.add('text-gray-900');
            });
            
            // Update cards
            cards.forEach(card => {
                card.classList.remove('bg-gray-800', 'border-gray-700');
                card.classList.add('bg-white', 'border-gray-200');
            });
            
            // Update all text elements
            allTexts.forEach(text => {
                if (text.classList.contains('text-gray-100') && !text.classList.contains('text-smartpoint-red')) {
                    text.classList.add('text-gray-900');
                    text.classList.remove('text-gray-100');
                }
                if (text.classList.contains('text-gray-300')) {
                    text.classList.add('text-gray-700');
                    text.classList.remove('text-gray-300');
                }
                if (text.classList.contains('text-gray-400')) {
                    text.classList.add('text-gray-600');
                    text.classList.remove('text-gray-400');
                }
            });
            
            // Update inputs
            allInputs.forEach(input => {
                input.classList.remove('bg-gray-700', 'border-gray-600', 'text-white');
                input.classList.add('bg-white', 'border-gray-300');
            });
            
            // Update tables
            allTables.forEach(table => {
                table.classList.remove('bg-gray-800');
                table.classList.add('bg-white');
            });
            
            allTableHeaders.forEach(th => {
                th.classList.remove('bg-gray-700', 'text-gray-200');
                th.classList.add('bg-gray-50', 'text-gray-500');
            });
            
            allTableCells.forEach(td => {
                td.classList.remove('bg-gray-800', 'text-gray-100');
                td.classList.add('bg-white', 'text-gray-900');
            });
            
            // Update theme toggle
            themeToggle.classList.remove('bg-smartpoint-red');
            themeToggle.classList.add('bg-gray-200');
            themeToggleThumb.classList.remove('translate-x-6');
            themeToggleThumb.classList.add('translate-x-1');
        }
    }

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    }

    // Event listeners
    if (userMenuDropdown) {
        userMenuDropdown.addEventListener('click', function(event) {
            event.stopPropagation();
            toggleUserMenu();
        });
    }

    if (settingsDropdown) {
        settingsDropdown.addEventListener('click', toggleDropdown);
    }
    
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
    
    document.addEventListener('click', function(event) {
        if (!userMenuDropdown?.contains(event.target) && !userMenu?.contains(event.target)) {
            closeUserMenu();
        }
        if (!settingsDropdown?.contains(event.target)) {
            closeDropdown();
        }
    });

    if (openSidebarBtn) {
        openSidebarBtn.addEventListener('click', openSidebar);
    }
    
    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', closeSidebar);
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }
    
    if (toggleSidebarBtn) {
        toggleSidebarBtn.addEventListener('click', toggleSidebar);
    }

    // Initialize state
    applyTheme();
    applySidebarState();
    
    // Close sidebar on mobile when clicking outside
    if (window.innerWidth < 1024) {
        closeSidebar();
    }
});
</script>

<!-- Chat Bot Component -->
@livewire('chat-bot')

@endsection 