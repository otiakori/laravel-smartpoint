<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->with('category')
            ->orderBy('name')
            ->paginate(15);

        return view('inventory.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Ensure user can only view products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $movements = InventoryMovement::where('product_id', $product->id)
            ->where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('movement_date', 'desc')
            ->paginate(20);

        return view('inventory.show', compact('product', 'movements'));
    }

    public function restock(Product $product)
    {
        // Ensure user can only restock products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        return view('inventory.restock', compact('product'));
    }

    public function processRestock(Request $request, Product $product)
    {
        // Ensure user can only restock products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            'cost_per_unit' => 'required|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'restock_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $previousQuantity = $product->stock_quantity;
            $newQuantity = $previousQuantity + $request->quantity;

            // Update product stock
            $product->update([
                'stock_quantity' => $newQuantity,
                'cost_price' => $request->cost_per_unit, // Update cost price if provided
            ]);

            // Record inventory movement
            InventoryMovement::create([
                'tenant_id' => Auth::user()->tenant_id,
                'product_id' => $product->id,
                'movement_type' => 'restock',
                'quantity' => $request->quantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $newQuantity,
                'reference_type' => 'restock',
                'reference_id' => null,
                'processed_by' => Auth::user()->id,
                'movement_date' => $request->restock_date,
                'notes' => $request->notes,
                'supplier' => $request->supplier,
                'cost_per_unit' => $request->cost_per_unit,
            ]);

            DB::commit();

            return redirect()->route('inventory.show', $product)
                ->with('success', "Successfully restocked {$request->quantity} units of {$product->name}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error processing restock: ' . $e->getMessage());
        }
    }

    public function adjustStock(Product $product)
    {
        // Ensure user can only adjust products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        return view('inventory.adjust', compact('product'));
    }

    public function processStockAdjustment(Request $request, Product $product)
    {
        // Ensure user can only adjust products from their tenant
        if ($product->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'adjustment_type' => 'required|in:add,subtract',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'adjustment_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $previousQuantity = $product->stock_quantity;
            
            if ($request->adjustment_type === 'add') {
                $newQuantity = $previousQuantity + $request->quantity;
            } else {
                if ($previousQuantity < $request->quantity) {
                    return back()->with('error', 'Cannot subtract more than available stock');
                }
                $newQuantity = $previousQuantity - $request->quantity;
            }

            // Update product stock
            $product->update(['stock_quantity' => $newQuantity]);

            // Record inventory movement
            InventoryMovement::create([
                'tenant_id' => Auth::user()->tenant_id,
                'product_id' => $product->id,
                'movement_type' => 'adjustment',
                'quantity' => $request->adjustment_type === 'add' ? $request->quantity : -$request->quantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $newQuantity,
                'reference_type' => 'adjustment',
                'reference_id' => null,
                'processed_by' => Auth::user()->id,
                'movement_date' => $request->adjustment_date,
                'notes' => $request->notes,
                'reason' => $request->reason,
            ]);

            DB::commit();

            $action = $request->adjustment_type === 'add' ? 'added' : 'subtracted';
            return redirect()->route('inventory.show', $product)
                ->with('success', "Successfully {$action} {$request->quantity} units of {$product->name}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error processing stock adjustment: ' . $e->getMessage());
        }
    }

    public function lowStock()
    {
        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->where('stock_quantity', '<=', 10) // Products with 10 or fewer items
            ->with('category')
            ->orderBy('stock_quantity')
            ->paginate(20);

        return view('inventory.low-stock', compact('products'));
    }

    public function movements()
    {
        $movements = InventoryMovement::where('tenant_id', Auth::user()->tenant_id)
            ->with(['product', 'processedBy'])
            ->orderBy('movement_date', 'desc')
            ->paginate(50);

        return view('inventory.movements', compact('movements'));
    }
} 