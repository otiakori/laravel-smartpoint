<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }

    public function create()
    {
        $customers = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('name')
            ->get();
        
        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->where('stock_quantity', '>', 0)
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('invoices.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        // Debug: Log the request data
        \Log::info('Invoice creation request:', $request->all());
        
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $invoice = Invoice::create([
                'tenant_id' => Auth::user()->tenant_id,
                'user_id' => Auth::user()->id,
                'customer_id' => $request->customer_id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'terms_conditions' => $request->terms_conditions,
                'subtotal' => 0,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => 0,
            ]);

            $subtotal = 0;
            $totalTax = 0;
            $totalDiscount = 0;

            foreach ($request->items as $itemData) {
                $item = InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $itemData['product_id'] ?? null,
                    'item_name' => $itemData['item_name'],
                    'description' => $itemData['description'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'tax_rate' => $itemData['tax_rate'] ?? 0,
                    'discount_amount' => $itemData['discount_amount'] ?? 0,
                ]);

                $subtotal += $item->quantity * $item->unit_price;
                $totalTax += $item->tax_amount;
                $totalDiscount += $item->discount_amount;
            }

            $invoice->update([
                'subtotal' => $subtotal,
                'tax_amount' => $totalTax,
                'discount_amount' => $totalDiscount,
                'total_amount' => $subtotal + $totalTax - $totalDiscount,
            ]);

            DB::commit();

            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Invoice creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'items.product', 'user']);
        
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load(['customer', 'items.product']);
        
        $customers = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('name')
            ->get();
        
        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->where('stock_quantity', '>', 0)
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('invoices.edit', compact('invoice', 'customers', 'products'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax_rate' => 'nullable|numeric|min:0|max:100',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $invoice->update([
                'customer_id' => $request->customer_id,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'terms_conditions' => $request->terms_conditions,
            ]);

            // Delete existing items
            $invoice->items()->delete();

            $subtotal = 0;
            $totalTax = 0;
            $totalDiscount = 0;

            foreach ($request->items as $itemData) {
                $item = InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $itemData['product_id'] ?? null,
                    'item_name' => $itemData['item_name'],
                    'description' => $itemData['description'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'tax_rate' => $itemData['tax_rate'] ?? 0,
                    'discount_amount' => $itemData['discount_amount'] ?? 0,
                ]);

                $subtotal += $item->quantity * $item->unit_price;
                $totalTax += $item->tax_amount;
                $totalDiscount += $item->discount_amount;
            }

            $invoice->update([
                'subtotal' => $subtotal,
                'tax_amount' => $totalTax,
                'discount_amount' => $totalDiscount,
                'total_amount' => $subtotal + $totalTax - $totalDiscount,
            ]);

            DB::commit();

            return redirect()->route('invoices.show', $invoice)
                ->with('success', 'Invoice updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update invoice: ' . $e->getMessage());
        }
    }

    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
            return redirect()->route('invoices.index')
                ->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete invoice: ' . $e->getMessage());
        }
    }

    public function markAsSent(Invoice $invoice)
    {
        $invoice->markAsSent();
        return back()->with('success', 'Invoice marked as sent!');
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->markAsPaid();
        return back()->with('success', 'Invoice marked as paid!');
    }

    public function markAsCancelled(Invoice $invoice)
    {
        $invoice->markAsCancelled();
        return back()->with('success', 'Invoice marked as cancelled!');
    }

    public function duplicate(Invoice $invoice)
    {
        try {
            DB::beginTransaction();

            $newInvoice = $invoice->replicate();
            $newInvoice->invoice_number = null; // Will be auto-generated
            $newInvoice->invoice_status = 'draft';
            $newInvoice->payment_status = 'pending';
            $newInvoice->sent_at = null;
            $newInvoice->viewed_at = null;
            $newInvoice->paid_at = null;
            $newInvoice->save();

            // Duplicate items
            foreach ($invoice->items as $item) {
                $newItem = $item->replicate();
                $newItem->invoice_id = $newInvoice->id;
                $newItem->save();
            }

            DB::commit();

            return redirect()->route('invoices.edit', $newInvoice)
                ->with('success', 'Invoice duplicated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to duplicate invoice: ' . $e->getMessage());
        }
    }
} 