<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\Tenant;
use Carbon\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first tenant and user
        $tenant = Tenant::first();
        $user = User::first();
        
        if (!$tenant || !$user) {
            return;
        }

        // Get some customers and products
        $customers = Customer::where('tenant_id', $tenant->id)->take(3)->get();
        $products = Product::where('tenant_id', $tenant->id)->take(5)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        // Create sample invoices
        for ($i = 1; $i <= 5; $i++) {
            $customer = $customers->random();
            $invoice = Invoice::create([
                'tenant_id' => $tenant->id,
                'user_id' => $user->id,
                'customer_id' => $customer->id,
                'invoice_date' => Carbon::now()->subDays(rand(1, 30)),
                'due_date' => Carbon::now()->addDays(rand(7, 30)),
                'reference_number' => 'PO-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'notes' => 'Sample invoice notes for testing purposes.',
                'terms_conditions' => 'Payment due within 30 days. Late payments subject to 1.5% monthly interest.',
                'subtotal' => 0,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => 0,
                'invoice_status' => ['draft', 'sent', 'paid'][rand(0, 2)],
                'payment_status' => ['pending', 'partial', 'paid'][rand(0, 2)],
            ]);

            // Add 2-4 items to each invoice
            $numItems = rand(2, 4);
            $subtotal = 0;
            $totalTax = 0;
            $totalDiscount = 0;

            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                $quantity = rand(1, 5);
                $unitPrice = $product->price;
                $taxRate = rand(0, 15);
                $discount = rand(0, 10);

                $itemSubtotal = $quantity * $unitPrice;
                $taxAmount = ($itemSubtotal * $taxRate) / 100;
                $itemTotal = $itemSubtotal + $taxAmount - $discount;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'item_name' => $product->name,
                    'description' => $product->description,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'tax_rate' => $taxRate,
                    'tax_amount' => $taxAmount,
                    'discount_amount' => $discount,
                    'total_amount' => $itemTotal,
                ]);

                $subtotal += $itemSubtotal;
                $totalTax += $taxAmount;
                $totalDiscount += $discount;
            }

            // Update invoice totals
            $invoice->update([
                'subtotal' => $subtotal,
                'tax_amount' => $totalTax,
                'discount_amount' => $totalDiscount,
                'total_amount' => $subtotal + $totalTax - $totalDiscount,
            ]);
        }
    }
} 