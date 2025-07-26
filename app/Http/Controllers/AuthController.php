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

        // Create admin user
        $user = User::create([
            'name' => $request->admin_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password),
            'tenant_id' => $tenant->id,
            'role' => 'admin',
            'status' => 'active',
        ]);

        Auth::login($user);
        
        return redirect('/dashboard')->with('success', 'Business registered successfully! Welcome to SmartPoint POS.');
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
        
        // Get statistics for the current tenant
        $totalProducts = Product::where('tenant_id', $user->tenant_id)->count();
        $totalCustomers = Customer::where('tenant_id', $user->tenant_id)->count();
        $totalSales = Sale::where('tenant_id', $user->tenant_id)->count();
        $totalRevenue = Sale::where('tenant_id', $user->tenant_id)->sum('total_amount');
        
        // Calculate average order value
        $avgOrderValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;
        
        // Get top 3 most expensive products
        $topExpensiveProducts = Product::where('tenant_id', $user->tenant_id)
            ->where('status', 'active')
            ->orderBy('price', 'desc')
            ->take(3)
            ->with('category')
            ->get();
        
        // Get chart data for doughnut chart (Sales by Category)
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
        
        // Get recent sales for the current tenant
        $recentSales = Sale::where('tenant_id', $user->tenant_id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'totalProducts', 
            'totalCustomers', 
            'totalSales', 
            'totalRevenue', 
            'avgOrderValue',
            'topExpensiveProducts',
            'salesByCategory',
            'recentSales'
        ));
    }
} 