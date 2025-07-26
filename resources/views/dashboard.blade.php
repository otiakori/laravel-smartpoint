@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="flex items-center justify-between px-6 py-4">
            <!-- Logo and Brand -->
            <div class="flex items-center space-x-3">
                <div class="text-2xl font-bold text-smartpoint-red">SalesPro</div>
                <span class="bg-smartpoint-red text-white px-2 py-1 rounded-full text-xs font-semibold">
                    {{ Auth::user()->tenant->plan ?? 'FREE' }}
                </span>
            </div>

            <!-- User Menu -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-smartpoint-red rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
                
                <button class="p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                    </svg>
                </button>
                <button class="p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
                <div class="relative">
                    <button id="settingsDropdown" class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div id="settingsMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50 hidden">
                        <div class="px-4 py-2 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-900">Settings</p>
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
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile Settings
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Preferences
                            </div>
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Help & Support
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
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-0 transition-transform duration-300 ease-in-out">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200">
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
            <nav class="mt-4 px-4">
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-smartpoint-red bg-red-50 rounded-lg">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                    <a href="{{ route('pos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="sidebar-text">POS</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="sidebar-text">Products</span>
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="sidebar-text">Customers</span>
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-smartpoint-red hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="sidebar-text">Reports</span>
                    </a>
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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-4 py-3 lg:px-6">
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
                        <h1 class="ml-2 text-xl font-semibold text-gray-900">Dashboard</h1>
                    </div>
                    <div class="w-6"></div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-6">
                <!-- Dashboard Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Premium Dashboard</h1>
                    <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}! Here's your business overview</p>
                </div>

                <!-- Filters and Export -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-4">
                        <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>Last 90 days</option>
                        </select>
                    </div>
                    <button class="bg-smartpoint-red text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export
                    </button>
                </div>

                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                    <!-- Total Products -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Products</p>
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
                                <div class="flex items-center mt-2">
                                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span class="text-sm text-blue-600 font-medium">Active</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
                                <div class="flex items-center mt-2">
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    <span class="text-sm text-green-600 font-medium">+15.2%</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Today -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Orders Today</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalSales }}</p>
                                <div class="flex items-center mt-2">
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    <span class="text-sm text-green-600 font-medium">+8.1%</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Active Customers -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Customers</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalCustomers }}</p>
                                <div class="flex items-center mt-2">
                                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                    </svg>
                                    <span class="text-sm text-green-600 font-medium">+12.5%</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Avg Order Value -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Avg Order Value</p>
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($avgOrderValue, 2) }}</p>
                                <div class="flex items-center mt-2">
                                    <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                    </svg>
                                    <span class="text-sm text-red-600 font-medium">-2.4%</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Revenue Analytics Chart -->
                    <div class="lg:col-span-2 bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Revenue Analytics</h3>
                            <div class="flex space-x-2">
                                <button class="px-4 py-2 bg-smartpoint-red text-white rounded-lg text-sm font-medium">Revenue</button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200">Orders</button>
                            </div>
                        </div>
                        <div class="h-64">
                            <canvas id="revenueChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Sales by Category Doughnut Chart -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sales by Category</h3>
                        <div class="h-64">
                            <canvas id="categoryChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top Expensive Products -->
                <div class="mt-8 bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">💎 Premium Products</h3>
                        <span class="bg-gradient-to-r from-purple-500 to-pink-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Most Expensive</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($topExpensiveProducts as $index => $product)
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        @if($index === 0)
                                            <span class="text-2xl mr-2">🥇</span>
                                        @elseif($index === 1)
                                            <span class="text-2xl mr-2">🥈</span>
                                        @else
                                            <span class="text-2xl mr-2">🥉</span>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $product->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Price:</span>
                                        <span class="text-xl font-bold text-red-600">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Stock:</span>
                                        <span class="text-sm font-medium {{ $product->stock_quantity <= 5 ? 'text-orange-600' : 'text-green-600' }}">
                                            {{ $product->stock_quantity }} units
                                        </span>
                                    </div>
                                    @if($product->cost_price)
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600">Profit:</span>
                                            <span class="text-sm font-medium text-green-600">
                                                ${{ number_format($product->price - $product->cost_price, 2) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <p class="mt-2 text-gray-500">No premium products found</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- AI-Powered Insights -->
                <div class="mt-8 bg-smartpoint-red rounded-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold">AI-Powered Insights</h3>
                        <span class="bg-white text-smartpoint-red px-3 py-1 rounded-full text-xs font-semibold">PREMIUM FEATURE</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium mb-1">Recommendation</p>
                                <p class="text-sm text-red-100">Increase coffee inventory by 25% - high demand detected for weekend rush</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium mb-1">Alert</p>
                                <p class="text-sm text-red-100">Low stock alert: Organic Tea running low, reorder in 2 days</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium mb-1">Opportunity</p>
                                <p class="text-sm text-red-100">Bundle pastries with coffee - 23% higher conversion rate predicted</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const openSidebarBtn = document.getElementById('openSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');

    // Settings dropdown functionality
    const settingsDropdown = document.getElementById('settingsDropdown');
    const settingsMenu = document.getElementById('settingsMenu');
    const themeToggle = document.getElementById('themeToggle');
    const themeToggleThumb = document.getElementById('themeToggleThumb');

    // Theme management
    let isDarkMode = localStorage.getItem('darkMode') === 'true';
    let isSidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    
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
        if (isSidebarCollapsed) {
            sidebar.classList.add('lg:w-16');
            sidebar.classList.remove('lg:w-64');
            document.querySelectorAll('.sidebar-text').forEach(text => {
                text.classList.add('lg:hidden');
            });
        } else {
            sidebar.classList.remove('lg:w-16');
            sidebar.classList.add('lg:w-64');
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
        const mainContent = document.querySelector('.min-h-screen');
        const header = document.querySelector('header');
        const cards = document.querySelectorAll('.bg-white');
        const chartContainer = document.querySelector('#revenueChart').parentElement;
        const sidebar = document.getElementById('sidebar');
        const sidebarTexts = document.querySelectorAll('.sidebar-text');
        const headerTitle = document.querySelector('header h1');
        const userInfo = document.querySelector('.text-sm.font-medium');
        
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
                card.classList.add('bg-gray-800', 'border-gray-700', 'text-white');
                card.classList.remove('bg-white', 'border-gray-200');
            });
            
            // Update chart container
            chartContainer.classList.add('bg-gray-800');
            chartContainer.classList.remove('bg-white');
            
            // Update toggle button
            themeToggle.classList.add('bg-smartpoint-red');
            themeToggle.classList.remove('bg-gray-200');
            themeToggleThumb.classList.add('translate-x-6');
            themeToggleThumb.classList.remove('translate-x-1');
            themeToggle.setAttribute('aria-checked', 'true');
            
            // Update dropdown menu
            settingsMenu.classList.add('bg-gray-800', 'border-gray-700');
            settingsMenu.classList.remove('bg-white', 'border-gray-200');
            
            // Update dropdown items
            const dropdownItems = settingsMenu.querySelectorAll('.text-gray-700');
            dropdownItems.forEach(item => {
                item.classList.add('text-gray-300');
                item.classList.remove('text-gray-700');
            });
            
            const dropdownHeaders = settingsMenu.querySelectorAll('.text-gray-900');
            dropdownHeaders.forEach(header => {
                header.classList.add('text-white');
                header.classList.remove('text-gray-900');
            });
            
            const hoverItems = settingsMenu.querySelectorAll('.hover\\:bg-gray-100');
            hoverItems.forEach(item => {
                item.classList.add('hover:bg-gray-700');
                item.classList.remove('hover:bg-gray-100');
            });
            
            // Update sidebar navigation items
            const navItems = sidebar.querySelectorAll('.text-gray-600');
            navItems.forEach(item => {
                item.classList.add('text-gray-300');
                item.classList.remove('text-gray-600');
            });
            
            const navHoverItems = sidebar.querySelectorAll('.hover\\:bg-red-50');
            navHoverItems.forEach(item => {
                item.classList.add('hover:bg-gray-700');
                item.classList.remove('hover:bg-red-50');
            });
            
            // Update sidebar section headers
            const sectionHeaders = sidebar.querySelectorAll('.text-gray-500');
            sectionHeaders.forEach(header => {
                header.classList.add('text-gray-400');
                header.classList.remove('text-gray-500');
            });
            
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
                card.classList.remove('bg-gray-800', 'border-gray-700', 'text-white');
                card.classList.add('bg-white', 'border-gray-200');
            });
            
            // Update chart container
            chartContainer.classList.remove('bg-gray-800');
            chartContainer.classList.add('bg-white');
            
            // Update toggle button
            themeToggle.classList.remove('bg-smartpoint-red');
            themeToggle.classList.add('bg-gray-200');
            themeToggleThumb.classList.remove('translate-x-6');
            themeToggleThumb.classList.add('translate-x-1');
            themeToggle.setAttribute('aria-checked', 'false');
            
            // Update dropdown menu
            settingsMenu.classList.remove('bg-gray-800', 'border-gray-700');
            settingsMenu.classList.add('bg-white', 'border-gray-200');
            
            // Update dropdown items
            const dropdownItems = settingsMenu.querySelectorAll('.text-gray-300');
            dropdownItems.forEach(item => {
                item.classList.remove('text-gray-300');
                item.classList.add('text-gray-700');
            });
            
            const dropdownHeaders = settingsMenu.querySelectorAll('.text-white');
            dropdownHeaders.forEach(header => {
                header.classList.remove('text-white');
                header.classList.add('text-gray-900');
            });
            
            const hoverItems = settingsMenu.querySelectorAll('.hover\\:bg-gray-700');
            hoverItems.forEach(item => {
                item.classList.remove('hover:bg-gray-700');
                item.classList.add('hover:bg-gray-100');
            });
            
            // Update sidebar navigation items
            const navItems = sidebar.querySelectorAll('.text-gray-300');
            navItems.forEach(item => {
                item.classList.remove('text-gray-300');
                item.classList.add('text-gray-600');
            });
            
            const navHoverItems = sidebar.querySelectorAll('.hover\\:bg-gray-700');
            navHoverItems.forEach(item => {
                item.classList.remove('hover:bg-gray-700');
                item.classList.add('hover:bg-red-50');
            });
            
            // Update sidebar section headers
            const sectionHeaders = sidebar.querySelectorAll('.text-gray-400');
            sectionHeaders.forEach(header => {
                header.classList.remove('text-gray-400');
                header.classList.add('text-gray-500');
            });
        }
    }

    // Event listeners
    settingsDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleDropdown();
    });

    themeToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleTheme();
    });

    toggleSidebarBtn.addEventListener('click', toggleSidebar);

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!settingsMenu.contains(e.target) && !settingsDropdown.contains(e.target)) {
            closeDropdown();
        }
    });

    // Apply initial theme and sidebar state
    applyTheme();
    applySidebarState();

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.style.overflow = '';
    }

    openSidebarBtn.addEventListener('click', openSidebar);
    closeSidebarBtn.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Close sidebar on window resize if screen becomes large
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            closeSidebar();
        }
    });

    // Revenue Chart
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Revenue ($)',
                data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                borderColor: '#DC2626',
                backgroundColor: 'rgba(220, 38, 38, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#DC2626',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + (value / 1000) + 'k';
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 6
                }
            }
        }
    });

    // Category Doughnut Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryData = @json($salesByCategory);
    const categoryLabels = Object.keys(categoryData);
    const categoryValues = Object.values(categoryData);
    
    // Generate beautiful colors for the chart
    const colors = [
        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
        '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9'
    ];
    
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryValues,
                backgroundColor: colors.slice(0, categoryLabels.length),
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverBorderWidth: 4,
                hoverBorderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} units (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
});
</script>
@endsection 