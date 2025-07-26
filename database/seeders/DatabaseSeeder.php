<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a sample tenant
        $tenant = Tenant::create([
            'name' => 'Sample Store',
            'email' => 'store@example.com',
            'phone' => '+1234567890',
            'address' => '123 Main Street, City, State 12345',
            'subscription_plan' => 'basic',
            'subscription_status' => 'trial',
            'trial_ends_at' => now()->addDays(30),
            'status' => 'active',
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create cashier user
        $cashier = User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@example.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role' => 'cashier',
            'status' => 'active',
        ]);

        // Create categories
        $electronics = Category::create([
            'tenant_id' => $tenant->id,
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories',
            'status' => 'active',
        ]);

        $clothing = Category::create([
            'tenant_id' => $tenant->id,
            'name' => 'Clothing',
            'description' => 'Apparel and accessories',
            'status' => 'active',
        ]);

        $home = Category::create([
            'tenant_id' => $tenant->id,
            'name' => 'Home & Garden',
            'description' => 'Home improvement and garden items',
            'status' => 'active',
        ]);

        // Create products
        $products = [
            [
                'name' => 'Smartphone',
                'description' => 'Latest smartphone with advanced features',
                'sku' => 'PHONE001',
                'barcode' => '1234567890123',
                'price' => 599.99,
                'cost_price' => 450.00,
                'stock_quantity' => 50,
                'min_stock_level' => 5,
                'max_stock_level' => 100,
                'category_id' => $electronics->id,
            ],
            [
                'name' => 'Laptop',
                'description' => 'High-performance laptop for work and gaming',
                'sku' => 'LAPTOP001',
                'barcode' => '1234567890124',
                'price' => 1299.99,
                'cost_price' => 1000.00,
                'stock_quantity' => 25,
                'min_stock_level' => 3,
                'max_stock_level' => 50,
                'category_id' => $electronics->id,
            ],
            [
                'name' => 'T-Shirt',
                'description' => 'Comfortable cotton t-shirt',
                'sku' => 'TSHIRT001',
                'barcode' => '1234567890125',
                'price' => 19.99,
                'cost_price' => 12.00,
                'stock_quantity' => 100,
                'min_stock_level' => 10,
                'max_stock_level' => 200,
                'category_id' => $clothing->id,
            ],
            [
                'name' => 'Jeans',
                'description' => 'Classic blue jeans',
                'sku' => 'JEANS001',
                'barcode' => '1234567890126',
                'price' => 49.99,
                'cost_price' => 30.00,
                'stock_quantity' => 75,
                'min_stock_level' => 8,
                'max_stock_level' => 150,
                'category_id' => $clothing->id,
            ],
            [
                'name' => 'Garden Tool Set',
                'description' => 'Complete set of essential garden tools',
                'sku' => 'GARDEN001',
                'barcode' => '1234567890127',
                'price' => 89.99,
                'cost_price' => 60.00,
                'stock_quantity' => 30,
                'min_stock_level' => 5,
                'max_stock_level' => 60,
                'category_id' => $home->id,
            ],
            [
                'name' => 'Coffee Maker',
                'description' => 'Automatic coffee maker with timer',
                'sku' => 'COFFEE001',
                'barcode' => '1234567890128',
                'price' => 79.99,
                'cost_price' => 50.00,
                'stock_quantity' => 40,
                'min_stock_level' => 5,
                'max_stock_level' => 80,
                'category_id' => $home->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create(array_merge($productData, [
                'tenant_id' => $tenant->id,
                'status' => 'active',
                'tax_rate' => 0.15,
                'is_taxable' => true,
            ]));
        }

        // Create customers
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567891',
                'address' => '456 Oak Street, City, State 12345',
                'credit_limit' => 1000.00,
                'current_balance' => 0.00,
                'payment_terms' => '30 days',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567892',
                'address' => '789 Pine Avenue, City, State 12345',
                'credit_limit' => 500.00,
                'current_balance' => 0.00,
                'payment_terms' => '15 days',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'phone' => '+1234567893',
                'address' => '321 Elm Road, City, State 12345',
                'credit_limit' => 2000.00,
                'current_balance' => 0.00,
                'payment_terms' => '45 days',
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create(array_merge($customerData, [
                'tenant_id' => $tenant->id,
                'status' => 'active',
                'loyalty_points' => 0,
                'total_spent' => 0.00,
            ]));
        }
    }
}
