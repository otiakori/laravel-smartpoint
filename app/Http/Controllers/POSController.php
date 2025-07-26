<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Payment;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class POSController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('query');
        $user = Auth::user();
        
        $products = $user->tenant->products()
            ->where('status', 'active')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%")
                  ->orWhere('barcode', 'like', "%{$query}%");
            })
            ->get();
            
        return response()->json(['products' => $products]);
    }

    public function getProduct($id)
    {
        $user = Auth::user();
        $product = $user->tenant->products()->findOrFail($id);
        
        return response()->json($product);
    }

    public function processSale(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        
        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = 0;
            $taxRate = 0.1; // 10% tax
            $taxAmount = 0;
            $discountAmount = 0;
            
            // Calculate subtotal from items
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                $subtotal += $product->price * $item['quantity'];
            }
            
            $taxAmount = $subtotal * $taxRate;
            $totalAmount = $subtotal + $taxAmount - $discountAmount;

            // Create sale
            $sale = Sale::create([
                'tenant_id' => $user->tenant_id,
                'user_id' => $user->id,
                'customer_id' => $request->customer_id,
                'sale_number' => $this->generateSaleNumber($user->tenant_id),
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid',
                'sale_status' => 'completed',
                'sale_date' => now(),
            ]);

            // Create sale items and update inventory
            foreach ($request->items as $item) {
                $product = Product::find($item['id']);
                
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total_price' => $item['quantity'] * $product->price,
                    'discount_amount' => 0,
                    'tax_amount' => ($item['quantity'] * $product->price) * $taxRate,
                ]);

                // Update inventory
                $previousQuantity = $product->stock_quantity;
                $product->stock_quantity -= $item['quantity'];
                $product->save();

                // Record inventory movement
                InventoryMovement::create([
                    'tenant_id' => $user->tenant_id,
                    'product_id' => $product->id,
                    'movement_type' => 'sale',
                    'quantity' => $item['quantity'],
                    'previous_quantity' => $previousQuantity,
                    'new_quantity' => $product->stock_quantity,
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'processed_by' => $user->id,
                    'movement_date' => now(),
                ]);
            }

            // Create payment record
            Payment::create([
                'sale_id' => $sale->id,
                'amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_date' => now(),
                'status' => 'successful',
                'processed_by' => $user->id,
            ]);

            // Update customer stats if customer exists
            if ($request->customer_id) {
                $customer = Customer::find($request->customer_id);
                $customer->update([
                    'total_spent' => $customer->total_spent + $totalAmount,
                    'last_purchase_date' => now(),
                ]);
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'sale_number' => $sale->sale_number,
                'message' => 'Sale completed successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function showReceipt($id)
    {
        $user = Auth::user();
        $sale = $user->tenant->sales()->with(['saleItems.product', 'customer', 'user'])->findOrFail($id);
        
        return view('pos.receipt', compact('sale'));
    }

    private function generateSaleNumber($tenantId)
    {
        $prefix = 'SALE';
        $year = date('Y');
        $month = date('m');
        
        $lastSale = Sale::where('tenant_id', $tenantId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
            
        if ($lastSale) {
            $lastNumber = (int) substr($lastSale->sale_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
} 