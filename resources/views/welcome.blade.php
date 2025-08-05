<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SalesPro - The Future of Point of Sale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'brand-red': '#D92D20',
                        'brand-dark': '#111827',
                        'brand-gray': '#6B7280',
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; margin: 0; padding: 0; }
        .radial-gradient {
            background-image: 
                radial-gradient(circle at 15% 30%, rgba(217, 45, 32, 0.06), transparent 40%),
                radial-gradient(circle at 5% 50%, rgba(217, 45, 32, 0.12), transparent 60%);
            position: relative;
        }

        /* Premium Text Animations */
        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slide-in-right {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slide-in-up {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes soft-highlight {
            0%, 100% {
                color: #D92D20;
                text-shadow: 0 2px 4px rgba(217, 45, 32, 0.1);
            }
            50% {
                color: #EF4444;
                text-shadow: 0 4px 8px rgba(239, 68, 68, 0.15);
            }
        }

        .animate-slide-in-left {
            animation: slide-in-left 1s ease-out forwards;
        }

        .animate-slide-in-right {
            animation: slide-in-right 1s ease-out forwards;
        }

        .animate-slide-in-up {
            animation: slide-in-up 1s ease-out forwards;
        }

        .animate-soft-highlight {
            animation: soft-highlight 4s ease-in-out infinite;
        }

        /* Premium Hover Effects */
        .animate-slide-in-up:hover {
            transform: translateY(-2px);
            transition: transform 0.3s ease;
        }

        .animate-gradient-text:hover {
            animation-play-state: paused;
            filter: brightness(1.1);
        }
    </style>
</head>
<body class="bg-white text-brand-dark">

    <!-- Header -->
    <header id="header" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="#" class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-brand-red rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <span class="font-bold text-xl">SalesPro</span>
                </a>

                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-brand-gray hover:text-brand-dark transition-colors">Features</a>
                    <a href="#pricing" class="text-brand-gray hover:text-brand-dark transition-colors">Pricing</a>
                    <a href="#solutions" class="text-brand-gray hover:text-brand-dark transition-colors">Solutions</a>
                    <a href="#contact" class="text-brand-gray hover:text-brand-dark transition-colors">Contact</a>
                </nav>

                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-brand-gray font-medium hover:text-brand-dark transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-brand-red text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-red-700 transition-colors">Start Free Trial</a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-brand-dark focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-md border-t border-gray-200 transform -translate-y-full transition-all duration-300 ease-in-out">
            <div class="px-6 py-8">
                <!-- Navigation Links -->
                <nav class="space-y-1 mb-8">
                    <a href="#features" class="mobile-menu-item group flex items-center px-4 py-3 text-lg font-medium text-brand-gray hover:text-brand-dark hover:bg-gray-50 rounded-xl transition-all duration-200 transform hover:translate-x-2">
                        <svg class="w-5 h-5 mr-3 text-brand-gray group-hover:text-brand-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Features
                    </a>
                    <a href="#pricing" class="mobile-menu-item group flex items-center px-4 py-3 text-lg font-medium text-brand-gray hover:text-brand-dark hover:bg-gray-50 rounded-xl transition-all duration-200 transform hover:translate-x-2">
                        <svg class="w-5 h-5 mr-3 text-brand-gray group-hover:text-brand-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Pricing
                    </a>
                    <a href="#solutions" class="mobile-menu-item group flex items-center px-4 py-3 text-lg font-medium text-brand-gray hover:text-brand-dark hover:bg-gray-50 rounded-xl transition-all duration-200 transform hover:translate-x-2">
                        <svg class="w-5 h-5 mr-3 text-brand-gray group-hover:text-brand-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Solutions
                    </a>
                    <a href="#contact" class="mobile-menu-item group flex items-center px-4 py-3 text-lg font-medium text-brand-gray hover:text-brand-dark hover:bg-gray-50 rounded-xl transition-all duration-200 transform hover:translate-x-2">
                        <svg class="w-5 h-5 mr-3 text-brand-gray group-hover:text-brand-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Contact
                    </a>
                </nav>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-6"></div>

                <!-- Auth Buttons -->
                <div class="space-y-4">
                    <a href="{{ route('login') }}" class="mobile-menu-item group flex items-center justify-center px-6 py-3 text-lg font-medium text-brand-gray hover:text-brand-dark hover:bg-gray-50 rounded-xl transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-3 text-brand-gray group-hover:text-brand-red transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="mobile-menu-item group flex items-center justify-center px-6 py-4 text-lg font-semibold bg-brand-red text-white hover:bg-red-700 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Start Free Trial
                    </a>
                </div>

                <!-- Close Button -->
                <button id="mobile-menu-close" class="absolute top-4 right-4 p-2 text-brand-gray hover:text-brand-dark transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
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
    <main class="radial-gradient relative min-h-screen flex items-center py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="text-center relative z-10">
                <div class="inline-flex items-center px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-medium border border-red-200 bg-white text-brand-dark mb-6 sm:mb-8 shadow-sm">
                    <div class="w-4 sm:w-5 h-4 sm:h-5 bg-brand-red rounded-full flex items-center justify-center mr-2">
                        <svg class="w-2 sm:w-3 h-2 sm:h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    Now with Advanced AI Analytics
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-brand-dark mb-6 sm:mb-8 leading-tight drop-shadow-sm">
                    <span class="inline-block animate-slide-in-left animation-delay-300">The Future of</span><br>
                    <span class="inline-block animate-slide-in-up animation-delay-500 animate-soft-highlight text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold">Point of Sale</span><br>
                    <span class="inline-block animate-slide-in-right animation-delay-700">is Here</span>
                </h1>
                <p class="text-base sm:text-lg text-brand-gray max-w-3xl mx-auto mb-8 sm:mb-12 leading-relaxed animate-fade-in-up animation-delay-900 px-4">
                    Experience the next generation of retail technology. Our AI-powered POS system doesn't just process transactions—it transforms your entire business with intelligent insights, predictive analytics, and seamless automation.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center px-4">
                    <a href="{{ route('register') }}" class="bg-brand-red text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-semibold hover:bg-red-700 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span>Get Started Free</span>
                        <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <button class="bg-white border border-gray-300 text-brand-dark px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-base sm:text-lg font-semibold hover:bg-gray-50 transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path></svg>
                        <span>Watch Demo</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Statistics Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-brand-dark mb-2">50K+</div>
                    <div class="text-brand-gray">Active Businesses</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-dark mb-2">99.9%</div>
                    <div class="text-brand-gray">Uptime Guarantee</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-dark mb-2">$2.5B+</div>
                    <div class="text-brand-gray">Processed Annually</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-brand-dark mb-2">24/7</div>
                    <div class="text-brand-gray">Expert Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Showcase -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-brand-dark mb-4">Why Choose SalesPro?</h2>
                <p class="text-lg text-brand-gray max-w-3xl mx-auto">Everything you need to run your business efficiently, all in one powerful platform.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- AI-Powered Analytics -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-200 transition-colors">
                        <svg class="w-8 h-8 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-4">AI-Powered Analytics</h3>
                    <p class="text-brand-gray leading-relaxed">Get intelligent insights that help you make better business decisions. Our AI analyzes your data to predict trends and optimize operations.</p>
                </div>

                <!-- Real-time Inventory -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-200 transition-colors">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-4">Real-time Inventory</h3>
                    <p class="text-brand-gray leading-relaxed">Track stock levels in real-time, set automatic reorder points, and never run out of popular items again.</p>
                </div>

                <!-- Multi-location Support -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-200 transition-colors">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-4">Multi-location Support</h3>
                    <p class="text-brand-gray leading-relaxed">Manage multiple stores from one dashboard. Sync inventory, sales, and customer data across all locations seamlessly.</p>
                </div>

                <!-- Customer Management -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-200 transition-colors">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-4">Customer Management</h3>
                    <p class="text-brand-gray leading-relaxed">Build lasting relationships with detailed customer profiles, purchase history, and personalized marketing campaigns.</p>
                </div>

                <!-- Payment Processing -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-yellow-200 transition-colors">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-4">Payment Processing</h3>
                    <p class="text-brand-gray leading-relaxed">Accept all major payment methods including cards, mobile payments, and digital wallets with secure processing.</p>
                </div>

                <!-- 24/7 Support -->
                <div class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-gray-100">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-200 transition-colors">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-brand-dark mb-4">24/7 Expert Support</h3>
                    <p class="text-brand-gray leading-relaxed">Get help whenever you need it with our dedicated support team. Phone, email, and live chat available.</p>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center mt-16">
                <h3 class="text-2xl font-bold text-brand-dark mb-4">Ready to Transform Your Business?</h3>
                <p class="text-brand-gray mb-8 max-w-2xl mx-auto">Join thousands of businesses that trust SalesPro to power their operations and drive growth.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-brand-red text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-700 transition-all duration-300 flex items-center justify-center space-x-2">
                        <span>Start Free Trial</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <button class="bg-white border border-gray-300 text-brand-dark px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-50 transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"></path>
                        </svg>
                        <span>Watch Demo</span>
                    </button>
                </div>
            </div>
        </div>


    <!-- Feature Showcase -->
     

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-brand-dark mb-4">What Our Customers Say</h2>
                <p class="text-lg text-brand-gray max-w-3xl mx-auto">Join thousands of satisfied businesses that have transformed their operations with SalesPro.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400 mb-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-brand-gray leading-relaxed mb-6">"SalesPro transformed our retail business completely. The AI analytics helped us increase sales by 40% in just 3 months. The inventory management is flawless!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            SM
                        </div>
                        <div>
                            <h4 class="font-semibold text-brand-dark">Sarah Mitchell</h4>
                            <p class="text-sm text-brand-gray">Owner, Fashion Boutique</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400 mb-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-brand-gray leading-relaxed mb-6">"Managing multiple stores was a nightmare before SalesPro. Now everything is synchronized perfectly. The customer insights are game-changing!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            MJ
                        </div>
                        <div>
                            <h4 class="font-semibold text-brand-dark">Michael Johnson</h4>
                            <p class="text-sm text-brand-gray">CEO, Tech Gadgets Chain</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400 mb-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-brand-gray leading-relaxed mb-6">"The payment processing is incredibly smooth. Our customers love the multiple payment options. Support team is always helpful and responsive."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                            LD
                        </div>
                        <div>
                            <h4 class="font-semibold text-brand-dark">Lisa Davis</h4>
                            <p class="text-sm text-brand-gray">Manager, Coffee Shop</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Indicators -->
            <div class="mt-16 text-center">
                <p class="text-sm text-brand-gray mb-6">Trusted by businesses worldwide</p>
                <div class="flex flex-wrap justify-center items-center gap-8 opacity-60">
                    <div class="text-2xl font-bold text-brand-dark">500+</div>
                    <div class="text-brand-gray">•</div>
                    <div class="text-2xl font-bold text-brand-dark">98%</div>
                    <div class="text-brand-gray">•</div>
                    <div class="text-2xl font-bold text-brand-dark">24/7</div>
                    <div class="text-brand-gray">•</div>
                    <div class="text-2xl font-bold text-brand-dark">4.9★</div>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-8 mt-2 text-sm text-brand-gray">
                    <span>Active Users</span>
                    <span>•</span>
                    <span>Satisfaction Rate</span>
                    <span>•</span>
                    <span>Support</span>
                    <span>•</span>
                    <span>Average Rating</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-brand-dark mb-4">Frequently Asked Questions</h2>
                <p class="text-lg text-brand-gray max-w-2xl mx-auto">Everything you need to know about SalesPro. Can't find the answer you're looking for? Contact our support team.</p>
            </div>

            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                    <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(this)">
                        <h3 class="text-xl font-semibold text-brand-dark">How does SalesPro's AI analytics work?</h3>
                        <svg class="w-6 h-6 text-brand-red transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-6 text-brand-gray leading-relaxed hidden">
                        <p>SalesPro's AI analyzes your sales data, customer behavior, and inventory patterns to provide actionable insights. It predicts trends, identifies your best-selling products, and suggests optimal pricing strategies. The AI learns from your business patterns to provide increasingly accurate recommendations over time.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                    <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(this)">
                        <h3 class="text-xl font-semibold text-brand-dark">Can I use SalesPro for multiple locations?</h3>
                        <svg class="w-6 h-6 text-brand-red transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-6 text-brand-gray leading-relaxed hidden">
                        <p>Absolutely! SalesPro is designed for multi-location businesses. You can manage inventory, sales, and customer data across all your stores from a single dashboard. Each location can have its own settings while sharing centralized reporting and analytics.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                    <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(this)">
                        <h3 class="text-xl font-semibold text-brand-dark">What payment methods does SalesPro support?</h3>
                        <svg class="w-6 h-6 text-brand-red transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-6 text-brand-gray leading-relaxed hidden">
                        <p>SalesPro supports all major payment methods including credit/debit cards, mobile payments (Apple Pay, Google Pay), digital wallets, cash, and checks. We also integrate with popular payment processors like Stripe, Square, and PayPal for secure transactions.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                    <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(this)">
                        <h3 class="text-xl font-semibold text-brand-dark">Is my data secure with SalesPro?</h3>
                        <svg class="w-6 h-6 text-brand-red transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-6 text-brand-gray leading-relaxed hidden">
                        <p>Yes, security is our top priority. SalesPro uses bank-level encryption (256-bit SSL) to protect all your data. We're fully compliant with PCI DSS standards for payment processing and GDPR for data protection. Your data is backed up daily and stored in secure, redundant servers.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                    <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(this)">
                        <h3 class="text-xl font-semibold text-brand-dark">How long does it take to set up SalesPro?</h3>
                        <svg class="w-6 h-6 text-brand-red transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-6 text-brand-gray leading-relaxed hidden">
                        <p>You can start using SalesPro in minutes! Simply sign up, add your products, and you're ready to go. For advanced features like inventory management and customer analytics, our setup wizard guides you through the process in about 30 minutes. Our support team is available 24/7 to help with any questions.</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                    <button class="flex justify-between items-center w-full text-left" onclick="toggleFAQ(this)">
                        <h3 class="text-xl font-semibold text-brand-dark">Can I integrate SalesPro with my existing systems?</h3>
                        <svg class="w-6 h-6 text-brand-red transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-6 text-brand-gray leading-relaxed hidden">
                        <p>Yes! SalesPro offers extensive integration capabilities. We integrate with popular accounting software (QuickBooks, Xero), e-commerce platforms (Shopify, WooCommerce), payment processors, and more. Our API also allows custom integrations with your existing business systems.</p>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="text-center mt-16">
                <h3 class="text-2xl font-bold text-brand-dark mb-4">Still have questions?</h3>
                <p class="text-brand-gray mb-8">Our support team is here to help you succeed.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="bg-brand-red text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-red-700 transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <span>Contact Support</span>
                    </a>
                    <a href="#" class="bg-white border border-gray-300 text-brand-dark px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-50 transition-all duration-300 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>View Documentation</span>
                    </a>
                </div>
            </div>
        </div>
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

        /* Mobile Menu Animations */
        @keyframes slideInFromTop {
            from {
                opacity: 0;
                transform: translateY(-100%);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mobile-menu-item {
            animation: fadeInUp 0.3s ease-out forwards;
            opacity: 0;
        }

        .mobile-menu-item:nth-child(1) { animation-delay: 0.1s; }
        .mobile-menu-item:nth-child(2) { animation-delay: 0.2s; }
        .mobile-menu-item:nth-child(3) { animation-delay: 0.3s; }
        .mobile-menu-item:nth-child(4) { animation-delay: 0.4s; }
        .mobile-menu-item:nth-child(5) { animation-delay: 0.5s; }
        .mobile-menu-item:nth-child(6) { animation-delay: 0.6s; }

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



    <!-- Dashboard Preview -->
    <section id="features" class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 animate-fade-in-up">
                <h2 class="text-4xl font-bold text-brand-dark mb-4">SalesPro Dashboard</h2>
                <p class="text-xl text-brand-gray">Real-time insights and AI-powered recommendations</p>
            </div>

            <!-- Dashboard Hero Image -->
            <div class="relative max-w-6xl mx-auto animate-fade-in-up animation-delay-200">
                <!-- Dashboard Window -->
                <div class="bg-brand-dark rounded-2xl shadow-2xl overflow-hidden hover:shadow-3xl transition-all duration-500 transform hover:scale-[1.02]">
                    <!-- Window Header -->
                    <div class="bg-gray-800 px-6 py-3 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="bg-brand-red text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">AI Powered</span>
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">Live</span>
                        </div>
                    </div>

                    <!-- Dashboard Content -->
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-2xl font-bold text-white">SalesPro Dashboard</h3>
                            <div class="text-gray-400 text-sm animate-pulse">Real-time Analytics</div>
                        </div>

                        <!-- Main Dashboard Area -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Analytics Chart -->
                            <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-white font-semibold">Analytics</h4>
                                    <div class="w-3 h-3 bg-brand-red rounded-full animate-pulse"></div>
                                </div>
                                <div class="h-32 bg-gray-700 rounded flex items-end justify-between p-2">
                                    <div class="w-4 bg-brand-red rounded-t chart-bar animate-chart-bar" style="height: 60%"></div>
                                    <div class="w-4 bg-brand-red rounded-t chart-bar animate-chart-bar animation-delay-100" style="height: 80%"></div>
                                    <div class="w-4 bg-brand-red rounded-t chart-bar animate-chart-bar animation-delay-200" style="height: 45%"></div>
                                    <div class="w-4 bg-brand-red rounded-t chart-bar animate-chart-bar animation-delay-300" style="height: 90%"></div>
                                    <div class="w-4 bg-brand-red rounded-t chart-bar animate-chart-bar animation-delay-400" style="height: 70%"></div>
                                    <div class="w-4 bg-brand-red rounded-t chart-bar animate-chart-bar animation-delay-500" style="height: 85%"></div>
                                    <div class="w-4 bg-brand-red rounded-t chart-bar animate-chart-bar animation-delay-600" style="height: 95%"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-sm text-gray-400">AI Insights</span>
                                </div>
                            </div>

                            <!-- Sales Chart -->
                            <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-white font-semibold">Sales</h4>
                                    <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse"></div>
                                </div>
                                <div class="h-32 bg-gray-700 rounded p-2 relative">
                                    <!-- Line Chart -->
                                    <svg class="w-full h-full" viewBox="0 0 100 100">
                                        <polyline 
                                            class="animate-line-draw"
                                            points="10,80 20,60 30,70 40,40 50,50 60,30 70,20 80,10 90,15" 
                                            fill="none" 
                                            stroke="#D92D20" 
                                            stroke-width="2"
                                        />
                                    </svg>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-sm text-gray-400">Revenue Trend</span>
                                </div>
                            </div>

                            <!-- Performance Chart -->
                            <div class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-all duration-300 hover:scale-105">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-white font-semibold">Performance</h4>
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                </div>
                                <div class="h-32 bg-gray-700 rounded flex items-end justify-between p-2">
                                    <div class="w-4 bg-green-400 rounded-t chart-bar animate-chart-bar" style="height: 75%"></div>
                                    <div class="w-4 bg-green-400 rounded-t chart-bar animate-chart-bar animation-delay-100" style="height: 85%"></div>
                                    <div class="w-4 bg-green-400 rounded-t chart-bar animate-chart-bar animation-delay-200" style="height: 90%"></div>
                                    <div class="w-4 bg-green-400 rounded-t chart-bar animate-chart-bar animation-delay-300" style="height: 95%"></div>
                                    <div class="w-4 bg-green-400 rounded-t chart-bar animate-chart-bar animation-delay-400" style="height: 88%"></div>
                                    <div class="w-4 bg-green-400 rounded-t chart-bar animate-chart-bar animation-delay-500" style="height: 92%"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-sm text-gray-400">Growth Rate</span>
                                </div>
                            </div>
                        </div>

                        <!-- KPI Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                            <div class="bg-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 animate-fade-in-up animation-delay-700">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-2xl font-bold text-brand-red animate-count-up">$47,250</div>
                                        <div class="text-sm text-gray-600">Today's Revenue</div>
                                        <div class="text-sm text-green-600 font-medium animate-pulse">+18% vs yesterday</div>
                                    </div>
                                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 animate-fade-in-up animation-delay-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-2xl font-bold text-blue-600 animate-count-up">2,847</div>
                                        <div class="text-sm text-gray-600">Active Customers</div>
                                        <div class="text-sm text-blue-600 font-medium animate-pulse">+12% this week</div>
                                    </div>
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 animate-fade-in-up animation-delay-900">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="text-2xl font-bold text-green-600 animate-count-up">+24%</div>
                                        <div class="text-sm text-gray-600">Growth Rate</div>
                                        <div class="text-sm text-green-600 font-medium animate-pulse">Best month ever</div>
                                    </div>
                                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
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
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-brand-dark mb-4">Choose Your Plan</h2>
                <p class="text-xl text-brand-gray">Start for free, upgrade when you're ready.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Free Plan -->
                <div class="bg-white rounded-2xl shadow-lg p-8 transform hover:scale-105 transition-transform duration-300">
                    <h3 class="text-2xl font-bold text-brand-dark mb-4">Free</h3>
                    <p class="text-brand-gray mb-6">For individuals and small teams getting started.</p>
                    <div class="mb-6">
                        <span class="text-5xl font-bold text-brand-dark">$0</span>
                        <span class="text-brand-gray">/ month</span>
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
                    <a href="{{ route('register') }}" class="w-full text-center bg-gray-200 text-brand-dark px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                        Start for Free
                    </a>
                </div>

                <!-- Premium Plan -->
                <div class="bg-brand-red text-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition-transform duration-300 relative">
                    <div class="absolute top-0 -translate-y-1/2 w-full flex justify-center">
                        <span class="bg-white text-brand-red px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
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
                    <a href="{{ route('register') }}" class="w-full text-center bg-white text-brand-red px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Choose Premium
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Insight Section -->
    <section id="solutions" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-brand-red rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold">AI Insight</h3>
                            <p class="text-red-100">Optimize Coffee Inventory: Predicted 20% increase in demand next week based on weather patterns and historical data.</p>
                        </div>
                    </div>
                    <button class="bg-white text-brand-red px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white mb-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-brand-dark mb-4">Get in Touch</h2>
                <p class="text-xl text-brand-gray">We'd love to hear from you. Send us a message and we'll get back to you shortly.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Contact Form -->
                <div class="bg-gray-50 rounded-2xl p-8 shadow-lg transform hover:scale-105 transition-transform duration-300">
                    <form action="#" method="POST">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-brand-red focus:ring-brand-red">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-brand-red focus:ring-brand-red">
                            </div>
                        </div>
                        <div class="mt-6">
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea id="message" name="message" rows="4" class="mt-1 block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:border-brand-red focus:ring-brand-red"></textarea>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="w-full bg-brand-red text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
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
                            <h4 class="text-lg font-semibold text-brand-dark">Email Us</h4>
                            <p class="text-brand-gray">Our team is here to help.</p>
                            <a href="mailto:support@salespro.com" class="text-brand-red hover:underline">support@salespro.com</a>
                        </div>
                    </div>
                     <div class="flex items-start">
                        <div class="flex-shrink-0">
                             <div class="bg-red-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-smartpoint-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-brand-dark">Call Us</h4>
                            <p class="text-brand-gray">Mon-Fri from 8am to 5pm.</p>
                            <a href="tel:+1-555-123-4567" class="text-brand-red hover:underline">+1 (555) 123-4567</a>
                        </div>
                    </div>
                     <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="bg-red-100 rounded-lg p-3">
                                <svg class="w-6 h-6 text-smartpoint-red" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-brand-dark">Our Office</h4>
                            <p class="text-brand-gray">123 SalesPro Ave, Suite 100<br>Tech City, TX 75001</p>
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



    <!-- Auto-dismiss success alert and mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Success alert auto-dismiss
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
    
            // Mobile menu functionality
            const menuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const closeButton = document.getElementById('mobile-menu-close');
            const mobileMenuItems = document.querySelectorAll('.mobile-menu-item');
            
            function openMobileMenu() {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.remove('-translate-y-full');
                mobileMenu.classList.add('translate-y-0');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
            
            function closeMobileMenu() {
                mobileMenu.classList.add('-translate-y-full');
                mobileMenu.classList.remove('translate-y-0');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
                document.body.style.overflow = ''; // Restore scrolling
            }
            
            if (menuButton && mobileMenu) {
                menuButton.addEventListener('click', openMobileMenu);
            }
            
            if (closeButton) {
                closeButton.addEventListener('click', closeMobileMenu);
            }
            
            // Close menu when clicking on menu items
            mobileMenuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Don't close for external links (like register/login)
                    if (this.getAttribute('href').startsWith('#')) {
                        closeMobileMenu();
                    }
                });
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (mobileMenu && !mobileMenu.contains(e.target) && !menuButton.contains(e.target)) {
                    if (!mobileMenu.classList.contains('hidden')) {
                        closeMobileMenu();
                    }
                }
            });

            // FAQ toggle functionality
            window.toggleFAQ = function(button) {
                const content = button.nextElementSibling;
                const icon = button.querySelector('svg');
                
                // Toggle content visibility
                content.classList.toggle('hidden');
                
                // Rotate icon
                if (content.classList.contains('hidden')) {
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                }
            };
        });
    </script>

    <!-- Enhanced Footer -->
    <footer class="bg-brand-dark text-white mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="lg:col-span-1">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-brand-red rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold">SalesPro</h3>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed">The future of point of sale. Transform your business with AI-powered analytics, real-time inventory, and seamless customer management.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-brand-red transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-brand-red transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center hover:bg-brand-red transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Product -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Product</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Integrations</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Security</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Updates</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Support</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Live Chat</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Training</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Status</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-lg font-semibold mb-6">Company</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Press</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Partners</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Legal</a></li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter Signup -->
            <div class="mt-12 pt-8 border-t border-gray-700">
                <div class="max-w-md">
                    <h4 class="text-lg font-semibold mb-4">Stay Updated</h4>
                    <p class="text-gray-300 mb-4">Get the latest updates, tips, and exclusive offers delivered to your inbox.</p>
                    <div class="flex">
                        <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 bg-gray-700 border border-gray-600 rounded-l-lg text-white placeholder-gray-400 focus:outline-none focus:border-brand-red">
                        <button class="px-6 py-3 bg-brand-red text-white font-semibold rounded-r-lg hover:bg-red-700 transition-colors">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="mt-12 pt-8 border-t border-gray-700 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-300 text-sm mb-4 md:mb-0">
                    © {{ date('Y') }} SalesPro. All rights reserved.
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">Cookie Policy</a>
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">GDPR</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
