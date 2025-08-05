<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Role;
use App\Models\Permission;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if (!$user->tenant) {
                Auth::logout();
                return back()->withErrors(['email' => 'User not associated with any business.']);
            }

            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Account is inactive.']);
            }

            if (!$user->tenant->isActive()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Business account is inactive.']);
            }

            $user->update(['last_login_at' => now()]);
            
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'business_email' => 'required|email|unique:tenants,email',
            'business_phone' => 'nullable|string|max:20',
            'business_address' => 'nullable|string',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create tenant
        $tenant = Tenant::create([
            'name' => $request->business_name,
            'email' => $request->business_email,
            'phone' => $request->business_phone,
            'address' => $request->business_address,
            'subscription_plan' => 'basic',
            'subscription_status' => 'trial',
            'trial_ends_at' => now()->addDays(30),
            'status' => 'active',
        ]);

        // Create tenant-specific roles and permissions
        $this->createTenantRolesAndPermissions($tenant);

        // Get the admin role for this tenant
        $adminRole = Role::where('name', 'admin')->where('tenant_id', $tenant->id)->first();

        // Create admin user
        $user = User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password),
            'tenant_id' => $tenant->id,
            'role_id' => $adminRole->id, // Assign admin role
            'status' => 'active',
        ]);

        Auth::login($user);
        
        return redirect('/dashboard')->with('success', 'Business registered successfully! Welcome to SmartPoint POS.');
    }

    /**
     * Create roles and permissions for a new tenant.
     */
    private function createTenantRolesAndPermissions($tenant)
    {
        $permissions = [
            // Dashboard
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard', 'module' => 'dashboard'],
            
            // POS
            ['name' => 'access_pos', 'display_name' => 'Access POS', 'module' => 'pos'],
            ['name' => 'process_sales', 'display_name' => 'Process Sales', 'module' => 'pos'],
            ['name' => 'void_transactions', 'display_name' => 'Void Transactions', 'module' => 'pos'],
            
            // Products
            ['name' => 'view_products', 'display_name' => 'View Products', 'module' => 'products'],
            ['name' => 'create_products', 'display_name' => 'Create Products', 'module' => 'products'],
            ['name' => 'edit_products', 'display_name' => 'Edit Products', 'module' => 'products'],
            ['name' => 'delete_products', 'display_name' => 'Delete Products', 'module' => 'products'],
            
            // Customers
            ['name' => 'view_customers', 'display_name' => 'View Customers', 'module' => 'customers'],
            ['name' => 'create_customers', 'display_name' => 'Create Customers', 'module' => 'customers'],
            ['name' => 'edit_customers', 'display_name' => 'Edit Customers', 'module' => 'customers'],
            ['name' => 'delete_customers', 'display_name' => 'Delete Customers', 'module' => 'customers'],
            
            // Sales
            ['name' => 'view_sales', 'display_name' => 'View Sales', 'module' => 'sales'],
            ['name' => 'create_sales', 'display_name' => 'Create Sales', 'module' => 'sales'],
            ['name' => 'edit_sales', 'display_name' => 'Edit Sales', 'module' => 'sales'],
            ['name' => 'delete_sales', 'display_name' => 'Delete Sales', 'module' => 'sales'],
            
            // Invoices
            ['name' => 'view_invoices', 'display_name' => 'View Invoices', 'module' => 'invoices'],
            ['name' => 'create_invoices', 'display_name' => 'Create Invoices', 'module' => 'invoices'],
            ['name' => 'edit_invoices', 'display_name' => 'Edit Invoices', 'module' => 'invoices'],
            ['name' => 'delete_invoices', 'display_name' => 'Delete Invoices', 'module' => 'invoices'],
            
            // Installment Plans
            ['name' => 'view_installment_plans', 'display_name' => 'View Installment Plans', 'module' => 'installment_plans'],
            ['name' => 'create_installment_plans', 'display_name' => 'Create Installment Plans', 'module' => 'installment_plans'],
            ['name' => 'edit_installment_plans', 'display_name' => 'Edit Installment Plans', 'module' => 'installment_plans'],
            ['name' => 'delete_installment_plans', 'display_name' => 'Delete Installment Plans', 'module' => 'installment_plans'],
            
            // Inventory
            ['name' => 'view_inventory', 'display_name' => 'View Inventory', 'module' => 'inventory'],
            ['name' => 'adjust_inventory', 'display_name' => 'Adjust Inventory', 'module' => 'inventory'],
            ['name' => 'restock_inventory', 'display_name' => 'Restock Inventory', 'module' => 'inventory'],
            
            // Reports
            ['name' => 'view_reports', 'display_name' => 'View Reports', 'module' => 'reports'],
            ['name' => 'export_reports', 'display_name' => 'Export Reports', 'module' => 'reports'],
            
            // Settings
            ['name' => 'view_settings', 'display_name' => 'View Settings', 'module' => 'settings'],
            ['name' => 'edit_settings', 'display_name' => 'Edit Settings', 'module' => 'settings'],
            
            // User Management
            ['name' => 'view_users', 'display_name' => 'View Users', 'module' => 'users'],
            ['name' => 'create_users', 'display_name' => 'Create Users', 'module' => 'users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'module' => 'users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'module' => 'users'],
            
            // Role Management
            ['name' => 'view_roles', 'display_name' => 'View Roles', 'module' => 'roles'],
            ['name' => 'create_roles', 'display_name' => 'Create Roles', 'module' => 'roles'],
            ['name' => 'edit_roles', 'display_name' => 'Edit Roles', 'module' => 'roles'],
            ['name' => 'delete_roles', 'display_name' => 'Delete Roles', 'module' => 'roles'],
            
            // AI Chat
            ['name' => 'access_ai_chat', 'display_name' => 'Access AI Chat', 'module' => 'ai_chat'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
                'description' => $permission['description'] ?? null,
                'module' => $permission['module'],
                'tenant_id' => $tenant->id
            ]);
        }

        // Create roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full access to all features and settings',
                'is_default' => false,
                'permissions' => Permission::where('tenant_id', $tenant->id)->pluck('name')->toArray()
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Can manage sales, inventory, and basic settings',
                'is_default' => false,
                'permissions' => [
                    'view_dashboard', 'access_pos', 'process_sales', 'void_transactions',
                    'view_products', 'create_products', 'edit_products',
                    'view_customers', 'create_customers', 'edit_customers',
                    'view_sales', 'create_sales', 'edit_sales',
                    'view_invoices', 'create_invoices', 'edit_invoices',
                    'view_installment_plans', 'create_installment_plans', 'edit_installment_plans',
                    'view_inventory', 'adjust_inventory', 'restock_inventory',
                    'view_reports', 'export_reports',
                    'view_settings', 'edit_settings',
                    'access_ai_chat'
                ]
            ],
            [
                'name' => 'cashier',
                'display_name' => 'Cashier',
                'description' => 'Can process sales and view basic information',
                'is_default' => true,
                'permissions' => [
                    'view_dashboard', 'access_pos', 'process_sales',
                    'view_products', 'view_customers', 'view_sales',
                    'view_invoices', 'access_ai_chat'
                ]
            ]
        ];

        foreach ($roles as $roleData) {
            $permissions = $roleData['permissions'];
            unset($roleData['permissions']);
            
            $role = Role::create([
                'name' => $roleData['name'],
                'display_name' => $roleData['display_name'],
                'description' => $roleData['description'],
                'is_default' => $roleData['is_default'],
                'tenant_id' => $tenant->id
            ]);
            
            // Attach permissions for this tenant
            $role->permissions()->attach(
                Permission::where('tenant_id', $tenant->id)
                    ->whereIn('name', $permissions)
                    ->pluck('id')
            );
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been successfully logged out.');
    }

    public function showDashboard()
    {
        $user = Auth::user();
        $tenant = $user->tenant;
        
        // Basic statistics
        $totalProducts = Product::where('tenant_id', $user->tenant_id)->count();
        $totalCustomers = Customer::where('tenant_id', $user->tenant_id)->count();
        $totalSales = Sale::where('tenant_id', $user->tenant_id)->count();
        $totalRevenue = Sale::where('tenant_id', $user->tenant_id)->sum('total_amount');
        
        // Calculate average order value
        $avgOrderValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;
        
        // Today's statistics
        $todaySales = Sale::where('tenant_id', $user->tenant_id)
            ->whereDate('created_at', today())
            ->count();
        $todayRevenue = Sale::where('tenant_id', $user->tenant_id)
            ->whereDate('created_at', today())
            ->sum('total_amount');
        
        // This week's statistics
        $weekSales = Sale::where('tenant_id', $user->tenant_id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        $weekRevenue = Sale::where('tenant_id', $user->tenant_id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_amount');
        
        // This month's statistics
        $monthSales = Sale::where('tenant_id', $user->tenant_id)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        $monthRevenue = Sale::where('tenant_id', $user->tenant_id)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_amount');
        
        // Low stock products
        $lowStockProducts = Product::where('tenant_id', $user->tenant_id)
            ->where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->count();
        
        // Out of stock products
        $outOfStockProducts = Product::where('tenant_id', $user->tenant_id)
            ->where('stock_quantity', 0)
            ->count();
        
        // Top selling products (by quantity sold)
        $topSellingProducts = SaleItem::whereHas('sale', function($query) use ($user) {
                $query->where('tenant_id', $user->tenant_id);
            })
            ->with(['product.category', 'product'])
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(total_price) as total_revenue')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(6)
            ->get()
            ->map(function($item) {
                $product = $item->product;
                $product->total_sold = $item->total_sold;
                $product->total_revenue = $item->total_revenue;
                return $product;
            });
        
        // Sales by category for doughnut chart
        $salesByCategory = Sale::where('tenant_id', $user->tenant_id)
            ->with(['saleItems.product.category'])
            ->get()
            ->flatMap(function($sale) {
                return $sale->saleItems;
            })
            ->groupBy(function($item) {
                return $item->product->category->name ?? 'Uncategorized';
            })
            ->map(function($items) {
                return $items->sum('quantity');
            });
        
        // Revenue trend data (last 7 days)
        $revenueTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyRevenue = Sale::where('tenant_id', $user->tenant_id)
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            $revenueTrend[] = [
                'date' => $date->format('D'),
                'revenue' => $dailyRevenue,
                'sales' => Sale::where('tenant_id', $user->tenant_id)
                    ->whereDate('created_at', $date)
                    ->count()
            ];
        }
        
        // Payment method distribution
        $paymentMethods = Sale::where('tenant_id', $user->tenant_id)
            ->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as total_amount')
            ->groupBy('payment_method')
            ->get();
        
        // Top customers
        $topCustomers = Sale::where('tenant_id', $user->tenant_id)
            ->where('created_at', '>=', now()->subDays(30))
            ->whereNotNull('customer_id')
            ->with('customer')
            ->selectRaw('customer_id, COUNT(*) as purchase_count, SUM(total_amount) as total_spent')
            ->groupBy('customer_id')
            ->orderBy('total_spent', 'desc')
            ->take(5)
            ->get()
            ->map(function($sale) {
                return [
                    'customer' => $sale->customer,
                    'purchase_count' => $sale->purchase_count,
                    'total_spent' => $sale->total_spent
                ];
            });
        
        // Recent sales
        $recentSales = Sale::where('tenant_id', $user->tenant_id)
            ->with(['customer', 'saleItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Inventory alerts
        $inventoryAlerts = Product::where('tenant_id', $user->tenant_id)
            ->where(function($query) {
                $query->where('stock_quantity', 0)
                      ->orWhere('stock_quantity', '<=', 5);
            })
            ->with('category')
            ->take(5)
            ->get();
        
        // Sales growth percentage
        $lastMonthRevenue = Sale::where('tenant_id', $user->tenant_id)
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('total_amount');
        $revenueGrowth = $lastMonthRevenue > 0 ? (($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;
        
        // Customer growth
        $lastMonthCustomers = Customer::where('tenant_id', $user->tenant_id)
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->count();
        $thisMonthCustomers = Customer::where('tenant_id', $user->tenant_id)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        $customerGrowth = $lastMonthCustomers > 0 ? (($thisMonthCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100 : 0;
        
        return view('dashboard', compact(
            'totalProducts', 
            'totalCustomers', 
            'totalSales', 
            'totalRevenue', 
            'avgOrderValue',
            'todaySales',
            'todayRevenue',
            'weekSales',
            'weekRevenue',
            'monthSales',
            'monthRevenue',
            'lowStockProducts',
            'outOfStockProducts',
            'topSellingProducts',
            'salesByCategory',
            'revenueTrend',
            'paymentMethods',
            'topCustomers',
            'recentSales',
            'inventoryAlerts',
            'revenueGrowth',
            'customerGrowth',
            'tenant'
        ));
    }
} 