<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Invoice;
use App\Models\InstallmentPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_currency_symbol_is_used_in_invoices()
    {
        // Create a tenant with custom currency
        $tenant = Tenant::create([
            'name' => 'Test Business',
            'email' => 'test@business.com',
            'currency' => 'EUR',
            'currency_symbol' => '€',
            'status' => 'active',
        ]);

        // Create a user for this tenant
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create an invoice
        $invoice = Invoice::create([
            'tenant_id' => $tenant->id,
            'user_id' => $user->id,
            'invoice_number' => 'INV-001',
            'invoice_date' => now(),
            'total_amount' => 1000.00,
            'subtotal' => 900.00,
            'tax_amount' => 90.00,
            'discount_amount' => 10.00,
            'invoice_status' => 'draft',
            'payment_status' => 'pending',
        ]);

        // Act as the user
        $this->actingAs($user);

        // Test that formatCurrency uses the tenant's currency symbol
        $this->assertEquals('€1,000.00', formatCurrency($invoice->total_amount));
        $this->assertEquals('€', getCurrencySymbol());
        $this->assertEquals('EUR', getCurrencyCode());
    }

    public function test_currency_symbol_is_used_in_installment_plans()
    {
        // Create a tenant with custom currency
        $tenant = Tenant::create([
            'name' => 'Test Business',
            'email' => 'test@business.com',
            'currency' => 'GBP',
            'currency_symbol' => '£',
            'status' => 'active',
        ]);

        // Create a user for this tenant
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create an installment plan
        $installmentPlan = InstallmentPlan::create([
            'tenant_id' => $tenant->id,
            'customer_id' => 1, // Assuming customer exists
            'total_amount' => 5000.00,
            'installment_amount' => 500.00,
            'installment_count' => 10,
            'payment_frequency' => 'monthly',
            'status' => 'active',
        ]);

        // Act as the user
        $this->actingAs($user);

        // Test that formatCurrency uses the tenant's currency symbol
        $this->assertEquals('£5,000.00', formatCurrency($installmentPlan->total_amount));
        $this->assertEquals('£500.00', formatCurrency($installmentPlan->installment_amount));
        $this->assertEquals('£', getCurrencySymbol());
        $this->assertEquals('GBP', getCurrencyCode());
    }

    public function test_default_currency_when_not_authenticated()
    {
        // Test that formatCurrency returns default when not authenticated
        $this->assertEquals('$1,000.00', formatCurrency(1000.00));
        $this->assertEquals('$', getCurrencySymbol());
        $this->assertEquals('USD', getCurrencyCode());
    }
} 