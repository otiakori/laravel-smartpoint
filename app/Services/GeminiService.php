<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;
use App\Models\SaleItem;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function chat($message, $context = [])
    {
        try {
            // Get real-time data from database
            $realTimeData = $this->getRealTimeData();
            
            // Log the data for debugging
            Log::info('Chat request', [
                'message' => $message,
                'data_count' => count($realTimeData),
                'products_count' => $realTimeData['total_products'] ?? 0,
                'has_products' => !empty($realTimeData['products'])
            ]);
            
            $prompt = $this->buildPrompt($message, $context, $realTimeData);
            
            // Log a sample of the prompt for debugging
            Log::info('Prompt sample', [
                'prompt_length' => strlen($prompt),
                'prompt_sample' => substr($prompt, 0, 1000)
            ]);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.8,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Sorry, I couldn\'t process your request.';
            }

            Log::error('Gemini API Error', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return 'Sorry, I\'m having trouble connecting right now. Please try again.';

        } catch (\Exception $e) {
            Log::error('Gemini Service Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return 'Sorry, I encountered an error. Please try again.';
        }
    }

    protected function getRealTimeData()
    {
        $user = Auth::user();
        $tenant = $user ? $user->tenant : null;
        
        if (!$tenant) {
            Log::error('No tenant found for user');
            return [];
        }

        try {
            Log::info('Getting real-time data for tenant', ['tenant_id' => $tenant->id]);
            
            // Get products with categories
            $products = Product::where('tenant_id', $tenant->id)
                ->with('category')
                ->get();
                
            Log::info('Products query result', [
                'tenant_id' => $tenant->id,
                'products_count' => $products->count(),
                'first_product' => $products->first() ? $products->first()->name : 'none'
            ]);
            
            $products = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock_quantity,
                    'category' => $product->category ? $product->category->name : 'Uncategorized',
                    'description' => $product->description,
                    'sku' => $product->sku,
                    'min_stock_level' => $product->min_stock_level,
                    'status' => $product->status
                ];
            });

            // Get categories
            $categories = Category::where('tenant_id', $tenant->id)
                ->withCount('products')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'products_count' => $category->products_count
                    ];
                });

            // Get comprehensive sales data
            $salesData = $this->getComprehensiveSalesData($tenant->id);

            // Get low stock products
            $lowStockProducts = Product::where('tenant_id', $tenant->id)
                ->where('stock_quantity', '<=', 10)
                ->where('stock_quantity', '>', 0)
                ->get()
                ->map(function ($product) {
                    return [
                        'name' => $product->name,
                        'stock' => $product->stock_quantity,
                        'category' => $product->category ? $product->category->name : 'Uncategorized'
                    ];
                });

            // Get out of stock products
            $outOfStockProducts = Product::where('tenant_id', $tenant->id)
                ->where('stock_quantity', 0)
                ->get()
                ->map(function ($product) {
                    return [
                        'name' => $product->name,
                        'category' => $product->category ? $product->category->name : 'Uncategorized'
                    ];
                });

            $result = [
                'products' => $products,
                'categories' => $categories,
                'sales_data' => $salesData,
                'low_stock_products' => $lowStockProducts,
                'out_of_stock_products' => $outOfStockProducts,
                'total_products' => $products->count(),
                'total_categories' => $categories->count(),
                'total_customers' => Customer::where('tenant_id', $tenant->id)->count()
            ];

            Log::info('Real-time data result', [
                'total_products' => $result['total_products'],
                'total_categories' => $result['total_categories'],
                'total_customers' => $result['total_customers'],
                'sales_count' => $salesData['total_sales'] ?? 0
            ]);

            return $result;

        } catch (\Exception $e) {
            Log::error('Error fetching real-time data', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [];
        }
    }

    protected function getComprehensiveSalesData($tenantId)
    {
        try {
            // Get recent sales with items and customer info
            $recentSales = Sale::where('tenant_id', $tenantId)
                ->with(['saleItems.product', 'customer', 'user'])
                ->latest()
                ->take(20)
                ->get()
                ->map(function ($sale) {
                    $items = $sale->saleItems->map(function ($item) {
                        return [
                            'product_name' => $item->product ? $item->product->name : 'Unknown Product',
                            'quantity' => $item->quantity,
                            'unit_price' => $item->unit_price,
                            'total_price' => $item->total_price
                        ];
                    });

                    return [
                        'id' => $sale->id,
                        'sale_number' => $sale->sale_number,
                        'total_amount' => $sale->total_amount,
                        'payment_method' => $sale->payment_method,
                        'payment_status' => $sale->payment_status,
                        'sale_status' => $sale->sale_status,
                        'customer_name' => $sale->customer ? $sale->customer->name : 'Walk-in Customer',
                        'cashier_name' => $sale->user ? $sale->user->name : 'Unknown',
                        'created_at' => $sale->created_at->format('Y-m-d H:i'),
                        'items_count' => $sale->saleItems->count(),
                        'items' => $items
                    ];
                });

            // Get today's sales summary
            $todaySales = Sale::where('tenant_id', $tenantId)
                ->whereDate('created_at', today())
                ->select(
                    DB::raw('COUNT(*) as total_sales'),
                    DB::raw('SUM(total_amount) as total_revenue'),
                    DB::raw('AVG(total_amount) as average_sale'),
                    DB::raw('SUM(CASE WHEN payment_status = "paid" THEN total_amount ELSE 0 END) as paid_revenue'),
                    DB::raw('SUM(CASE WHEN payment_status = "pending" THEN total_amount ELSE 0 END) as pending_revenue')
                )
                ->first();

            // Get this week's sales
            $weekSales = Sale::where('tenant_id', $tenantId)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->select(
                    DB::raw('COUNT(*) as total_sales'),
                    DB::raw('SUM(total_amount) as total_revenue'),
                    DB::raw('AVG(total_amount) as average_sale')
                )
                ->first();

            // Get this month's sales
            $monthSales = Sale::where('tenant_id', $tenantId)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->select(
                    DB::raw('COUNT(*) as total_sales'),
                    DB::raw('SUM(total_amount) as total_revenue'),
                    DB::raw('AVG(total_amount) as average_sale')
                )
                ->first();

            // Get top selling products (last 30 days)
            $topSellingProducts = SaleItem::join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->join('products', 'sale_items.product_id', '=', 'products.id')
                ->where('sales.tenant_id', $tenantId)
                ->where('sales.created_at', '>=', now()->subDays(30))
                ->select(
                    'products.name',
                    'products.id',
                    DB::raw('SUM(sale_items.quantity) as total_quantity_sold'),
                    DB::raw('SUM(sale_items.total_price) as total_revenue'),
                    DB::raw('COUNT(DISTINCT sales.id) as times_sold')
                )
                ->groupBy('products.id', 'products.name')
                ->orderBy('total_quantity_sold', 'desc')
                ->take(10)
                ->get();

            // Get sales by payment method
            $salesByPaymentMethod = Sale::where('tenant_id', $tenantId)
                ->where('created_at', '>=', now()->subDays(30))
                ->select(
                    'payment_method',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(total_amount) as total_amount')
                )
                ->groupBy('payment_method')
                ->get();

            // Get sales by status
            $salesByStatus = Sale::where('tenant_id', $tenantId)
                ->where('created_at', '>=', now()->subDays(30))
                ->select(
                    'payment_status',
                    'sale_status',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(total_amount) as total_amount')
                )
                ->groupBy('payment_status', 'sale_status')
                ->get();

            // Get customer insights
            $topCustomers = Sale::where('tenant_id', $tenantId)
                ->where('created_at', '>=', now()->subDays(30))
                ->whereNotNull('customer_id')
                ->with('customer')
                ->select(
                    'customer_id',
                    DB::raw('COUNT(*) as purchase_count'),
                    DB::raw('SUM(total_amount) as total_spent'),
                    DB::raw('AVG(total_amount) as average_purchase')
                )
                ->groupBy('customer_id')
                ->orderBy('total_spent', 'desc')
                ->take(5)
                ->get()
                ->map(function ($sale) {
                    return [
                        'customer_name' => $sale->customer ? $sale->customer->name : 'Unknown',
                        'purchase_count' => $sale->purchase_count,
                        'total_spent' => $sale->total_spent,
                        'average_purchase' => $sale->average_purchase
                    ];
                });

            // Get daily sales trend (last 7 days)
            $dailySalesTrend = Sale::where('tenant_id', $tenantId)
                ->where('created_at', '>=', now()->subDays(7))
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as sales_count'),
                    DB::raw('SUM(total_amount) as daily_revenue')
                )
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get();

            return [
                'recent_sales' => $recentSales,
                'today_sales' => $todaySales,
                'week_sales' => $weekSales,
                'month_sales' => $monthSales,
                'top_selling_products' => $topSellingProducts,
                'sales_by_payment_method' => $salesByPaymentMethod,
                'sales_by_status' => $salesByStatus,
                'top_customers' => $topCustomers,
                'daily_sales_trend' => $dailySalesTrend,
                'total_sales' => Sale::where('tenant_id', $tenantId)->count(),
                'total_revenue' => Sale::where('tenant_id', $tenantId)->sum('total_amount')
            ];

        } catch (\Exception $e) {
            Log::error('Error fetching sales data', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'recent_sales' => collect(),
                'today_sales' => null,
                'week_sales' => null,
                'month_sales' => null,
                'top_selling_products' => collect(),
                'sales_by_payment_method' => collect(),
                'sales_by_status' => collect(),
                'top_customers' => collect(),
                'daily_sales_trend' => collect(),
                'total_sales' => 0,
                'total_revenue' => 0
            ];
        }
    }

    protected function buildPrompt($message, $context = [], $realTimeData = [])
    {
        $user = Auth::user();
        $tenant = $user ? $user->tenant : null;
        
        $businessInfo = '';
        if ($tenant) {
            $businessInfo = "
Business Information:
- Business Name: {$tenant->name}
- Business Type: POS/Retail Store
- Currency: {$tenant->currency} ({$tenant->currency_symbol})
- Location: {$tenant->address}
- Contact: {$tenant->email}, {$tenant->phone}
- Timezone: {$tenant->timezone}
";
        }

        $userInfo = '';
        if ($user) {
            $userInfo = "
User Information:
- Name: {$user->name}
- Role: {$user->role}
- Email: {$user->email}
";
        }

        $databaseInfo = '';
        if (!empty($realTimeData)) {
            // Simple, direct product list
            $productsList = '';
            if (!empty($realTimeData['products'])) {
                $productsList = "PRODUCTS IN STOCK:\n";
                foreach ($realTimeData['products'] as $product) {
                    $productsList .= "• {$product['name']} - Price: {$product['price']} - Stock: {$product['stock']} - Category: {$product['category']}\n";
                }
            }

            // Comprehensive sales data
            $salesData = $realTimeData['sales_data'] ?? [];
            $salesInfo = '';
            
            if (!empty($salesData)) {
                // Today's sales
                if ($salesData['today_sales']) {
                    $today = $salesData['today_sales'];
                    $salesInfo .= "TODAY'S SALES: {$today->total_sales} transactions, Total Revenue: {$today->total_revenue}, Average Sale: {$today->average_sale}\n";
                }
                
                // This week's sales
                if ($salesData['week_sales']) {
                    $week = $salesData['week_sales'];
                    $salesInfo .= "THIS WEEK: {$week->total_sales} sales, Revenue: {$week->total_revenue}, Average: {$week->average_sale}\n";
                }
                
                // This month's sales
                if ($salesData['month_sales']) {
                    $month = $salesData['month_sales'];
                    $salesInfo .= "THIS MONTH: {$month->total_sales} sales, Revenue: {$month->total_revenue}, Average: {$month->average_sale}\n";
                }
                
                // Top selling products
                if (!empty($salesData['top_selling_products'])) {
                    $salesInfo .= "TOP SELLING PRODUCTS (Last 30 days):\n";
                    foreach ($salesData['top_selling_products'] as $product) {
                        $salesInfo .= "• {$product->name} - Sold: {$product->total_quantity_sold} units, Revenue: {$product->total_revenue}\n";
                    }
                }
                
                // Recent sales
                if (!empty($salesData['recent_sales'])) {
                    $salesInfo .= "RECENT SALES:\n";
                    foreach ($salesData['recent_sales']->take(5) as $sale) {
                        $salesInfo .= "• Sale #{$sale['sale_number']} - {$sale['customer_name']} - {$sale['total_amount']} - {$sale['payment_method']} - {$sale['created_at']}\n";
                    }
                }
                
                // Sales by payment method
                if (!empty($salesData['sales_by_payment_method'])) {
                    $salesInfo .= "SALES BY PAYMENT METHOD (Last 30 days):\n";
                    foreach ($salesData['sales_by_payment_method'] as $method) {
                        $salesInfo .= "• {$method->payment_method}: {$method->count} sales, {$method->total_amount} revenue\n";
                    }
                }
                
                // Top customers
                if (!empty($salesData['top_customers'])) {
                    $salesInfo .= "TOP CUSTOMERS (Last 30 days):\n";
                    foreach ($salesData['top_customers'] as $customer) {
                        $salesInfo .= "• {$customer['customer_name']}: {$customer['purchase_count']} purchases, {$customer['total_spent']} total spent\n";
                    }
                }
                
                // Daily sales trend
                if (!empty($salesData['daily_sales_trend'])) {
                    $salesInfo .= "DAILY SALES TREND (Last 7 days):\n";
                    foreach ($salesData['daily_sales_trend'] as $day) {
                        $salesInfo .= "• {$day->date}: {$day->sales_count} sales, {$day->daily_revenue} revenue\n";
                    }
                }
                
                // Overall statistics
                $salesInfo .= "OVERALL STATISTICS:\n";
                $salesInfo .= "• Total Sales: {$salesData['total_sales']}\n";
                $salesInfo .= "• Total Revenue: {$salesData['total_revenue']}\n";
            }

            // Simple inventory alerts
            $inventoryAlerts = '';
            if (!empty($realTimeData['low_stock_products'])) {
                $inventoryAlerts = "LOW STOCK: " . count($realTimeData['low_stock_products']) . " products need restocking\n";
            }
            if (!empty($realTimeData['out_of_stock_products'])) {
                $inventoryAlerts .= "OUT OF STOCK: " . count($realTimeData['out_of_stock_products']) . " products have 0 stock\n";
            }

            $databaseInfo = "
=== BUSINESS DATA ===
TOTAL PRODUCTS: {$realTimeData['total_products']}
TOTAL CUSTOMERS: {$realTimeData['total_customers']}

{$productsList}

{$salesInfo}

{$inventoryAlerts}
=== END DATA ===
";
        }

        $systemPrompt = "You are an AI assistant for a POS (Point of Sale) system called SmartPoint.

{$businessInfo}
{$userInfo}

{$databaseInfo}

IMPORTANT: You have REAL DATA above including comprehensive sales history, top-selling products, customer insights, and sales trends. Use this data to answer questions.

When asked about sales:
- Use the specific sales data provided (today, week, month, trends)
- Reference actual top-selling products and their performance
- Mention real customer insights and payment method preferences
- Provide insights based on the daily sales trend data

When asked about products:
- Use the actual product list with real names, prices, and stock levels
- Reference top-selling products from the sales data
- Suggest products based on actual sales performance

When asked about customers:
- Use the real customer data and top customers list
- Reference actual purchase patterns and spending habits

Always use specific numbers, names, and data from the information provided above. Be conversational but data-driven in your responses.

User message: " . $message;

        return $systemPrompt;
    }

    public function getProductRecommendations($customerQuery, $availableProducts = [])
    {
        $context = [
            'user' => 'Cashier',
            'page' => 'POS',
            'products_count' => count($availableProducts),
            'cart_items' => 0
        ];

        $prompt = "A customer is asking: '$customerQuery'. 
        
        Based on the real products in our database, what specific products would you recommend? Use the actual product data to give specific recommendations with names, prices, and why they would be suitable.";

        return $this->chat($prompt, $context);
    }

    public function getInventoryHelp($query)
    {
        $context = [
            'user' => 'Cashier',
            'page' => 'Inventory',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Inventory/Stock query: '$query'
        
        Use the real inventory data to provide specific information about stock levels, low stock items, out of stock items, and inventory management advice.";

        return $this->chat($prompt, $context);
    }

    public function getSalesAssistance($query, $cartItems = [])
    {
        $context = [
            'user' => 'Cashier',
            'page' => 'POS',
            'products_count' => 'Multiple',
            'cart_items' => count($cartItems)
        ];

        $prompt = "Sales assistance needed: '$query'
        
        Current cart has " . count($cartItems) . " items. Use the real sales data to help with payment processing, customer service, discounts, installment plans, returns, and refunds. Reference actual sales patterns and top-selling products.";

        return $this->chat($prompt, $context);
    }

    public function getTroubleshootingHelp($issue)
    {
        $context = [
            'user' => 'Cashier',
            'page' => 'POS',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Troubleshooting issue: '$issue'
        
        Provide step-by-step guidance for resolving POS system issues, errors, or problems. Give clear, conversational instructions.";

        return $this->chat($prompt, $context);
    }

    public function getInventoryInsights()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Inventory',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Provide insights about our current inventory situation. Analyze the low stock products, out of stock items, and suggest what needs attention. Give specific recommendations based on the actual data.";

        return $this->chat($prompt, $context);
    }

    public function getSalesInsights()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Sales',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Analyze our sales performance based on the real data. What are our top-selling products? How are we performing today? What insights can you provide about our sales patterns? Include specific numbers and trends from the data.";

        return $this->chat($prompt, $context);
    }

    public function getSalesTrends()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Sales',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Analyze our sales trends over the past week and month. What patterns do you see? Are sales increasing or decreasing? What days are our busiest? Use the daily sales trend data to provide specific insights.";

        return $this->chat($prompt, $context);
    }

    public function getTopSellingProducts()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Sales',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Based on our sales data, what are our top-selling products? How many units have they sold and what revenue have they generated? Which products should we focus on promoting?";

        return $this->chat($prompt, $context);
    }

    public function getCustomerInsights()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Customers',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Analyze our customer data and recent sales. Who are our top customers? What are their spending patterns? What insights can you provide about our customer base and their preferences? Use the actual customer data to give specific insights.";

        return $this->chat($prompt, $context);
    }

    public function getPaymentMethodAnalysis()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Sales',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Analyze our payment method preferences. Which payment methods are most popular? What percentage of sales use each method? What insights can you provide about customer payment preferences?";

        return $this->chat($prompt, $context);
    }

    public function getSalesComparison($period = 'week')
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Sales',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Compare our sales performance for the current {$period} with previous periods. What are the key differences? Are we improving or declining? Provide specific numbers and insights.";

        return $this->chat($prompt, $context);
    }

    public function getRevenueAnalysis()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Sales',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Analyze our revenue performance. What is our total revenue? What is our average sale value? How does revenue vary by day, week, and month? Provide specific revenue insights and recommendations.";

        return $this->chat($prompt, $context);
    }

    public function getInventorySalesCorrelation()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Inventory',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Analyze the correlation between our inventory levels and sales performance. Which products are selling well but running low on stock? Which products have high stock but low sales? Provide recommendations for inventory management based on sales data.";

        return $this->chat($prompt, $context);
    }

    public function getProductSearch($searchTerm)
    {
        $context = [
            'user' => 'Cashier',
            'page' => 'POS',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "A customer is looking for products related to: '$searchTerm'. 
        
        Based on our actual product database, what specific products match this search? Provide product names, prices, and availability. If no exact matches, suggest similar products.";

        return $this->chat($prompt, $context);
    }

    public function getStockAlerts()
    {
        $context = [
            'user' => 'Manager',
            'page' => 'Inventory',
            'products_count' => 'Multiple',
            'cart_items' => 0
        ];

        $prompt = "Based on our current inventory data, what stock alerts should I be aware of? Which products need restocking? Which are completely out of stock? Provide specific recommendations.";

        return $this->chat($prompt, $context);
    }

    public function debugDatabaseData()
    {
        $user = Auth::user();
        $tenant = $user ? $user->tenant : null;
        
        if (!$tenant) {
            return "No tenant found for user.";
        }

        try {
            $debugInfo = [];
            
            // Check products
            $productsCount = Product::where('tenant_id', $tenant->id)->count();
            $debugInfo[] = "Products: {$productsCount}";
            
            // Check categories
            $categoriesCount = Category::where('tenant_id', $tenant->id)->count();
            $debugInfo[] = "Categories: {$categoriesCount}";
            
            // Check sales
            $salesCount = Sale::where('tenant_id', $tenant->id)->count();
            $debugInfo[] = "Total Sales: {$salesCount}";
            
            // Check today's sales
            $todaySalesCount = Sale::where('tenant_id', $tenant->id)
                ->whereDate('created_at', today())
                ->count();
            $debugInfo[] = "Today's Sales: {$todaySalesCount}";
            
            // Check customers
            $customersCount = Customer::where('tenant_id', $tenant->id)->count();
            $debugInfo[] = "Customers: {$customersCount}";
            
            // Sample products
            $sampleProducts = Product::where('tenant_id', $tenant->id)->take(3)->get(['name', 'price', 'stock_quantity']);
            if ($sampleProducts->count() > 0) {
                $debugInfo[] = "Sample Products:";
                foreach ($sampleProducts as $product) {
                    $debugInfo[] = "- {$product->name} (Price: {$product->price}, Stock: {$product->stock_quantity})";
                }
            }
            
            // Sample sales
            $sampleSales = Sale::where('tenant_id', $tenant->id)->latest()->take(3)->get(['id', 'total_amount', 'created_at']);
            if ($sampleSales->count() > 0) {
                $debugInfo[] = "Sample Sales:";
                foreach ($sampleSales as $sale) {
                    $debugInfo[] = "- Sale #{$sale->id} (Total: {$sale->total_amount}, Date: {$sale->created_at})";
                }
            }
            
            return implode("\n", $debugInfo);
            
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function testDataFormatting()
    {
        $realTimeData = $this->getRealTimeData();
        $context = ['page' => 'test'];
        $prompt = $this->buildPrompt("What products do we have?", $context, $realTimeData);
        
        return [
            'data_count' => count($realTimeData),
            'products_count' => $realTimeData['total_products'] ?? 0,
            'prompt_length' => strlen($prompt),
            'sample_prompt' => substr($prompt, 0, 500) . '...',
            'full_prompt' => $prompt
        ];
    }

    public function showRawData()
    {
        $user = Auth::user();
        $tenant = $user ? $user->tenant : null;
        
        $output = "RAW DATABASE DATA:\n\n";
        $output .= "User: " . ($user ? $user->name : 'No user') . "\n";
        $output .= "Tenant: " . ($tenant ? $tenant->name : 'No tenant') . "\n";
        $output .= "Tenant ID: " . ($tenant ? $tenant->id : 'No tenant ID') . "\n\n";
        
        // Check all products without tenant filter
        $allProducts = Product::count();
        $output .= "All Products in Database: {$allProducts}\n";
        
        // Check products with tenant filter
        if ($tenant) {
            $tenantProducts = Product::where('tenant_id', $tenant->id)->count();
            $output .= "Products for Tenant {$tenant->id}: {$tenantProducts}\n";
            
            // Show some sample products
            $sampleProducts = Product::take(5)->get(['id', 'name', 'tenant_id', 'price', 'stock_quantity']);
            if ($sampleProducts->count() > 0) {
                $output .= "\nSample Products (all):\n";
                foreach ($sampleProducts as $product) {
                    $output .= "- ID: {$product->id}, Name: {$product->name}, Tenant: {$product->tenant_id}, Price: {$product->price}, Stock: {$product->stock_quantity}\n";
                }
            }
            
            // Show products for this tenant
            $tenantSampleProducts = Product::where('tenant_id', $tenant->id)->take(5)->get(['id', 'name', 'tenant_id', 'price', 'stock_quantity']);
            if ($tenantSampleProducts->count() > 0) {
                $output .= "\nProducts for this tenant:\n";
                foreach ($tenantSampleProducts as $product) {
                    $output .= "- ID: {$product->id}, Name: {$product->name}, Tenant: {$product->tenant_id}, Price: {$product->price}, Stock: {$product->stock_quantity}\n";
                }
            }
        }
        
        // Check all customers
        $allCustomers = Customer::count();
        $output .= "\nAll Customers in Database: {$allCustomers}\n";
        
        if ($tenant) {
            $tenantCustomers = Customer::where('tenant_id', $tenant->id)->count();
            $output .= "Customers for Tenant {$tenant->id}: {$tenantCustomers}\n";
        }
        
        // Check all sales
        $allSales = Sale::count();
        $output .= "\nAll Sales in Database: {$allSales}\n";
        
        if ($tenant) {
            $tenantSales = Sale::where('tenant_id', $tenant->id)->count();
            $output .= "Sales for Tenant {$tenant->id}: {$tenantSales}\n";
        }
        
        return $output;
    }

    public function testGetRealTimeData()
    {
        $realTimeData = $this->getRealTimeData();
        
        $output = "TESTING getRealTimeData():\n\n";
        $output .= "Data array count: " . count($realTimeData) . "\n";
        $output .= "Total products: " . ($realTimeData['total_products'] ?? 'NOT SET') . "\n";
        $output .= "Total customers: " . ($realTimeData['total_customers'] ?? 'NOT SET') . "\n";
        
        if (!empty($realTimeData['products'])) {
            $output .= "\nProducts found:\n";
            foreach ($realTimeData['products'] as $product) {
                $output .= "- {$product['name']} (Price: {$product['price']}, Stock: {$product['stock']})\n";
            }
        } else {
            $output .= "\nNo products found in realTimeData\n";
        }
        
        return $output;
    }
} 