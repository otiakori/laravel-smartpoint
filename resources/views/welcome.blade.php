<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPoint POS - AI-Powered Point of Sale System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'smartpoint-red': '#DC2626',
                        'smartpoint-dark': '#1F2937',
                    }
                }
            }
        }
    </script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-smartpoint-red rounded-lg flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-lg">S</span>
                    </div>
                    <span class="text-smartpoint-dark font-bold text-xl">SmartPoint</span>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#features" class="text-smartpoint-dark hover:text-smartpoint-red transition-colors">Features</a>
                    <a href="#pricing" class="text-smartpoint-dark hover:text-smartpoint-red transition-colors">Pricing</a>
                    <a href="#solutions" class="text-smartpoint-dark hover:text-smartpoint-red transition-colors">Solutions</a>
                    <a href="#contact" class="text-smartpoint-dark hover:text-smartpoint-red transition-colors">Contact</a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-smartpoint-dark hover:text-smartpoint-red transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-smartpoint-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">Start Free Trial</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Success Message -->
    @if(session('success'))
        <div id="successAlert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <!-- AI Analytics Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border border-red-200 bg-white text-gray-700 mb-8 hover:scale-105 transition-all duration-0 hover:shadow-lg">
                    <div class="w-4 h-4 bg-red-500 rounded-full flex items-center justify-center mr-2">
                        <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                    Now with Advanced AI Analytics
                </div>

                <!-- Main Headline -->
                <h1 class="text-5xl md:text-6xl font-bold text-smartpoint-dark mb-6 leading-tight animate-fade-in-up">
                    The Future of<br>
                    <span class="text-smartpoint-red animate-pulse hover:scale-105 transition-transform duration-300">Point of Sale</span><br>
                    is Here
                </h1>

                <!-- Description -->
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8 leading-relaxed animate-fade-in-up animation-delay-200">
                    Experience the next generation of retail technology. Our AI-powered POS system doesn't just process transactions—it transforms your entire business with intelligent insights, predictive analytics, and seamless automation.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center animate-fade-in-up animation-delay-400">
                    <a href="{{ route('register') }}" class="bg-smartpoint-red text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-700 transition-all duration-300 inline-flex items-center hover:scale-105 hover:shadow-xl transform hover:-translate-y-1">
                        Get Started Free
                        <svg class="w-5 h-5 ml-2 animate-bounce-x" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <button class="border-2 border-gray-300 text-smartpoint-dark px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-50 transition-all duration-300 inline-flex items-center hover:scale-105 hover:shadow-lg transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        Watch Demo
                    </button>
                </div>
            </div>
        </div>

        <!-- Background Accent -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-smartpoint-red opacity-10 rounded-full blur-3xl animate-float"></div>
    </section>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce-x {
            0%, 100% {
                transform: translateX(0);
            }
            50% {
                transform: translateX(3px);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animate-bounce-x {
            animation: bounce-x 2s infinite;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        /* Hover effects for interactive elements */
        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\:-translate-y-1:hover {
            transform: translateY(-4px);
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced shadow effects */
        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* New animations for dashboard */
        @keyframes chart-bar {
            0% { 
                height: 0; 
                opacity: 0;
            }
            100% { 
                height: var(--height); 
                opacity: 1;
            }
        }

        @keyframes line-draw {
            0% { 
                stroke-dasharray: 1000;
                stroke-dashoffset: 1000; 
                opacity: 0; 
            }
            100% { 
                stroke-dasharray: 1000;
                stroke-dashoffset: 0; 
                opacity: 1; 
            }
        }

        @keyframes count-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-chart-bar {
            animation: chart-bar 1.5s ease-out forwards;
        }

        .animate-line-draw {
            animation: line-draw 2s ease-out forwards;
        }

        .animate-count-up {
            animation: count-up 1s ease-out forwards;
        }

        .animation-delay-100 {
            animation-delay: 0.1s;
        }

        .animation-delay-200 {
            animation-delay: 0.2s;
        }

        .animation-delay-300 {
            animation-delay: 0.3s;
        }

        .animation-delay-400 {
            animation-delay: 0.4s;
        }

        .animation-delay-500 {
            animation-delay: 0.5s;
        }

        .animation-delay-600 {
            animation-delay: 0.6s;
        }

        .animation-delay-700 {
            animation-delay: 0.7s;
        }

        .animation-delay-800 {
            animation-delay: 0.8s;
        }

        .animation-delay-900 {
            animation-delay: 0.9s;
        }

        .animation-delay-1000 {
            animation-delay: 1s;
        }

        .animation-delay-1100 {
            animation-delay: 1.1s;
        }

        .animation-delay-1200 {
            animation-delay: 1.2s;
        }

        .animation-delay-1300 {
            animation-delay: 1.3s;
        }

        /* Dashboard specific hover effects */
        .hover\:bg-gray-750:hover {
            background-color: #374151;
        }

        .hover\:shadow-3xl:hover {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }

        /* Chart bar animations with CSS custom properties */
        .chart-bar {
            --height: 0%;
            height: var(--height);
        }

        .chart-bar[style*="height: 60%"] { --height: 60%; }
        .chart-bar[style*="height: 80%"] { --height: 80%; }
        .chart-bar[style*="height: 45%"] { --height: 45%; }
        .chart-bar[style*="height: 90%"] { --height: 90%; }
        .chart-bar[style*="height: 70%"] { --height: 70%; }
        .chart-bar[style*="height: 85%"] { --height: 85%; }
        .chart-bar[style*="height: 95%"] { --height: 95%; }
        .chart-bar[style*="height: 40%"] { --height: 40%; }
        .chart-bar[style*="height: 65%"] { --height: 65%; }
        .chart-bar[style*="height: 55%"] { --height: 55%; }
        .chart-bar[style*="height: 75%"] { --height: 75%; }
    </style>

    <!-- Statistics Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-smartpoint-dark mb-2">50K+</div>
                    <div class="text-gray-600">Active Businesses</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-smartpoint-dark mb-2">99.9%</div>
                    <div class="text-gray-600">Uptime Guarantee</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-smartpoint-dark mb-2">$2.5B+</div>
                    <div class="text-gray-600">Processed Annually</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-smartpoint-dark mb-2">24/7</div>
                    <div class="text-gray-600">Expert Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview -->
    <section id="features" class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-smartpoint-dark mb-4">SmartPoint Dashboard</h2>
                <p class="text-xl text-gray-600">Real-time insights and AI-powered recommendations</p>
            </div>

            <!-- Dashboard Hero Image -->
            <div class="relative max-w-6xl mx-auto animate-fade-in-up animation-delay-200">
                <!-- Dashboard Window -->
                <div class="bg-smartpoint-dark rounded-2xl shadow-2xl overflow-hidden hover:shadow-3xl transition-all duration-500 transform hover:scale-[1.02]">
                    <!-- Window Header -->
                    <div class="bg-gray-800 px-6 py-3 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="bg-smartpoint-red text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">AI Powered</span>
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">Live</span>
                        </div>
                    </div>

                    <!-- Dashboard Content -->
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold text-white">SmartPoint Dashboard</h3>
                            <div class="text-gray-400 text-sm animate-pulse">Real-time Analytics</div>
                        </div>

                        <!-- Sidebar and Main Content -->
                        <div class="flex space-x-6">
                            <!-- Left Sidebar -->
                            <div class="w-48 bg-gray-800 rounded-lg p-4">
                                <div class="space-y-4">
                                    <div class="flex items-center space-x-3 text-white hover:bg-gray-700 p-2 rounded cursor-pointer transition-all duration-200 hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        </svg>
                                        <span class="text-sm">Home</span>
                                    </div>
                                    <div class="flex items-center space-x-3 text-smartpoint-red bg-gray-700 p-2 rounded animate-pulse">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span class="text-sm">Analytics</span>
                                    </div>
                                    <div class="flex items-center space-x-3 text-gray-400 hover:bg-gray-700 p-2 rounded cursor-pointer transition-all duration-200 hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <span class="text-sm">Salesprint</span>
                                    </div>
                                    <div class="flex items-center space-x-3 text-gray-400 hover:bg-gray-700 p-2 rounded cursor-pointer transition-all duration-200 hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                        <span class="text-sm">AI Insights</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Dashboard Area -->
                            <div class="flex-1 space-y-6">
                                <!-- Analytics Charts Row -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Analytics Chart -->
                                    <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-750 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-white font-semibold">Analytics</h4>
                                            <div class="w-3 h-3 bg-smartpoint-red rounded-full animate-pulse"></div>
                                        </div>
                                        <div class="h-32 bg-gray-700 rounded flex items-end justify-between p-2">
                                            <div class="w-4 bg-smartpoint-red rounded-t chart-bar animate-chart-bar" style="height: 60%"></div>
                                            <div class="w-4 bg-smartpoint-red rounded-t chart-bar animate-chart-bar animation-delay-100" style="height: 80%"></div>
                                            <div class="w-4 bg-smartpoint-red rounded-t chart-bar animate-chart-bar animation-delay-200" style="height: 45%"></div>
                                            <div class="w-4 bg-smartpoint-red rounded-t chart-bar animate-chart-bar animation-delay-300" style="height: 90%"></div>
                                            <div class="w-4 bg-smartpoint-red rounded-t chart-bar animate-chart-bar animation-delay-400" style="height: 70%"></div>
                                            <div class="w-4 bg-smartpoint-red rounded-t chart-bar animate-chart-bar animation-delay-500" style="height: 85%"></div>
                                            <div class="w-4 bg-smartpoint-red rounded-t chart-bar animate-chart-bar animation-delay-600" style="height: 95%"></div>
                                        </div>
                                        <div class="text-center mt-2">
                                            <span class="text-sm text-gray-400">AI Instigates</span>
                                        </div>
                                    </div>

                                    <!-- Salesprint Chart -->
                                    <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-750 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-white font-semibold">Salesprint</h4>
                                            <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                                        </div>
                                        <div class="h-32 bg-gray-700 rounded flex items-end justify-between p-2">
                                            <div class="w-4 bg-blue-400 rounded-t chart-bar animate-chart-bar" style="height: 40%"></div>
                                            <div class="w-4 bg-blue-400 rounded-t chart-bar animate-chart-bar animation-delay-100" style="height: 65%"></div>
                                            <div class="w-4 bg-blue-400 rounded-t chart-bar animate-chart-bar animation-delay-200" style="height: 55%"></div>
                                            <div class="w-4 bg-blue-400 rounded-t chart-bar animate-chart-bar animation-delay-300" style="height: 75%"></div>
                                            <div class="w-4 bg-blue-400 rounded-t chart-bar animate-chart-bar animation-delay-400" style="height: 85%"></div>
                                            <div class="w-4 bg-blue-400 rounded-t chart-bar animate-chart-bar animation-delay-500" style="height: 90%"></div>
                                        </div>
                                        <div class="text-center mt-2">
                                            <span class="text-sm text-gray-400">AI Trop</span>
                                        </div>
                                    </div>

                                    <!-- Analytics Line Chart -->
                                    <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-750 transition-all duration-300 hover:scale-105 hover:shadow-xl">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-white font-semibold">Analytics</h4>
                                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                        </div>
                                        <div class="h-32 bg-gray-700 rounded p-2 relative">
                                            <!-- Line Chart -->
                                            <svg class="w-full h-full" viewBox="0 0 100 100">
                                                <polyline 
                                                    class="animate-line-draw"
                                                    points="10,80 20,60 30,70 40,40 50,50 60,30 70,20 80,10 90,15" 
                                                    fill="none" 
                                                    stroke="#DC2626" 
                                                    stroke-width="2"
                                                />
                                            </svg>
                                        </div>
                                        <div class="mt-2 text-xs text-gray-400">
                                            <div class="animate-fade-in-up animation-delay-700">A. More 4.97 33% 50%</div>
                                            <div class="animate-fade-in-up animation-delay-800">B. Comine 3.24 22% 45%</div>
                                            <div class="animate-fade-in-up animation-delay-900">C. More Users 2.18 15% 30%</div>
                                            <div class="animate-fade-in-up animation-delay-1000">D. Foryle 1.85 12% 25%</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- KPI Cards -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 animate-fade-in-up animation-delay-1100">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-2xl font-bold text-smartpoint-red animate-count-up">$47,250</div>
                                                <div class="text-sm text-gray-600">Today's Revenue</div>
                                                <div class="text-sm text-green-600 font-medium animate-pulse">+18% vs yesterday</div>
                                            </div>
                                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors duration-200">
                                                <svg class="w-6 h-6 text-smartpoint-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 animate-fade-in-up animation-delay-1200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-2xl font-bold text-blue-600 animate-count-up">2,847</div>
                                                <div class="text-sm text-gray-600">Active Customers</div>
                                                <div class="text-sm text-blue-600 font-medium animate-pulse">+12% this week</div>
                                            </div>
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 animate-fade-in-up animation-delay-1300">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-2xl font-bold text-green-600 animate-count-up">+24%</div>
                                                <div class="text-sm text-gray-600">Growth Rate</div>
                                                <div class="text-sm text-green-600 font-medium animate-pulse">Best month ever</div>
                                            </div>
                                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors duration-200">
                                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-smartpoint-dark mb-4">Choose Your Plan</h2>
                <p class="text-xl text-gray-600">Start for free, upgrade when you're ready.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-smartpoint-dark mb-4">Free</h3>
                    <p class="text-gray-600 mb-6">For individuals and small teams getting started.</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-smartpoint-dark">$0</span>
                        <span class="text-gray-600">/ month</span>
                    </div>
                    <ul class="space-y-4 text-gray-700 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Basic POS Features
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Inventory Management (up to 50 products)
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Standard Reporting
                        </li>
                         <li class="flex items-center text-gray-400">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            AI-Powered Analytics
                        </li>
                        <li class="flex items-center text-gray-400">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            24/7 Priority Support
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full text-center bg-gray-200 text-smartpoint-dark px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                        Start for Free
                    </a>
                </div>

                <!-- Premium Plan -->
                <div class="bg-smartpoint-red text-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition-transform duration-300 relative">
                    <div class="absolute top-0 -translate-y-1/2 w-full flex justify-center">
                        <span class="bg-white text-smartpoint-red px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Premium</h3>
                    <p class="text-red-100 mb-6">For growing businesses that need advanced features.</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold">$49</span>
                        <span class="text-red-100">/ month</span>
                    </div>
                    <ul class="space-y-4 text-red-50 mb-8">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Everything in Free
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Unlimited Products
                        </li>
                        <li class="flex items-center">
                           <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            AI-Powered Analytics & Insights
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Advanced Reporting
                        </li>
                        <li class="flex items-center">
                           <svg class="w-5 h-5 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            24/7 Priority Support
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full text-center bg-white text-smartpoint-red px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Choose Premium
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Insight Section -->
    <section id="solutions" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-smartpoint-red rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-smartpoint-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">AI Insight</h3>
                            <p class="text-red-100">Optimize Coffee Inventory: Predicted 20% increase in demand next week based on weather patterns and historical data.</p>
                        </div>
                    </div>
                    <button class="bg-white text-smartpoint-red px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-smartpoint-dark mb-4">Get in Touch</h2>
                <p class="text-xl text-gray-600">We'd love to hear from you. Send us a message and we'll get back to you shortly.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Contact Form -->
                <div class="bg-gray-50 rounded-2xl p-8 shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <form action="#" method="POST">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-smartpoint-red focus:ring-smartpoint-red">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-smartpoint-red focus:ring-smartpoint-red">
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea id="message" name="message" rows="4" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-smartpoint-red focus:ring-smartpoint-red"></textarea>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-smartpoint-red text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                     <div class="flex items-start">
                        <div class="flex-shrink-0">
                             <div class="bg-red-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-smartpoint-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-smartpoint-dark">Email Us</h4>
                            <p class="text-gray-600">Our team is here to help.</p>
                            <a href="mailto:support@smartpoint.com" class="text-smartpoint-red hover:underline">support@smartpoint.com</a>
                        </div>
                    </div>
                     <div class="flex items-start">
                        <div class="flex-shrink-0">
                             <div class="bg-red-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-smartpoint-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-smartpoint-dark">Call Us</h4>
                            <p class="text-gray-600">Mon-Fri from 8am to 5pm.</p>
                            <a href="tel:+1-555-123-4567" class="text-smartpoint-red hover:underline">+1 (555) 123-4567</a>
                        </div>
                    </div>
                     <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-red-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-smartpoint-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-smartpoint-dark">Our Office</h4>
                            <p class="text-gray-600">123 SmartPoint Ave, Suite 100<br>Tech City, TX 75001</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Notifications -->
    {{-- <div class="fixed bottom-8 left-8 z-50">
        <div class="bg-blue-100 border border-blue-300 rounded-lg p-4 shadow-lg">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                </svg>
                <div>
                    <div class="font-semibold text-blue-900">New Order</div>
                    <div class="text-sm text-blue-700">Table A12 - $32.50</div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="fixed bottom-8 right-8 z-50">
        <div class="bg-green-100 border border-green-300 rounded-lg p-4 shadow-lg">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <div>
                    <div class="font-semibold text-green-900">Payment Successful</div>
                    <div class="text-sm text-green-700">Transaction #SP-2024-1547</div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Footer -->
    <footer class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-smartpoint-dark mb-8">Trusted by industry leaders worldwide</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-gray-500">
                        <div class="font-semibold">RETAIL CO</div>
                        <div class="text-sm">Since 2016</div>
                    </div>
                    <div class="text-gray-500">
                        <div class="font-semibold">STORE PLUS</div>
                        <div class="text-sm">Since 2018</div>
                    </div>
                    <div class="text-gray-500">
                        <div class="font-semibold">MARKET PRO</div>
                        <div class="text-sm">Since 2019</div>
                    </div>
                    <div class="text-gray-500">
                        <div class="font-semibold">SHOP SMART</div>
                        <div class="text-sm">Since 2021</div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu -->
    <div class="md:hidden fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50">
        <div class="bg-smartpoint-red text-white px-6 py-3 rounded-full shadow-lg">
            <a href="{{ route('register') }}" class="font-semibold">Get Started</a>
        </div>
    </div>

    <!-- Auto-dismiss success alert after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.transition = 'opacity 0.5s ease-out';
                    successAlert.style.opacity = '0';
                    setTimeout(function() {
                        successAlert.remove();
                    }, 500);
                }, 5000); // 5 seconds
            }
        });
    </script>
</body>
</html>
