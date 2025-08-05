<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->with(['supplier', 'items.product', 'createdBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('purchase-orders.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Generate PO number
            $poNumber = 'PO-' . date('Y') . '-' . str_pad(PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)->count() + 1, 4, '0', STR_PAD_LEFT);

            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_cost'];
            }

            $taxAmount = 0; // You can add tax calculation logic here
            $totalAmount = $subtotal + $taxAmount;

            // Create purchase order
            $purchaseOrder = PurchaseOrder::create([
                'tenant_id' => Auth::user()->tenant_id,
                'supplier_id' => $request->supplier_id,
                'po_number' => $poNumber,
                'order_date' => $request->order_date,
                'expected_delivery_date' => $request->expected_delivery_date,
                'status' => 'draft',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // Create purchase order items
            foreach ($request->items as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'total_cost' => $item['quantity'] * $item['unit_cost'],
                    'received_quantity' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase order created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to create purchase order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchaseOrder = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->with(['supplier', 'items.product', 'createdBy'])
            ->findOrFail($id);

        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $purchaseOrder = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->with(['items.product'])
            ->findOrFail($id);

        if (!$purchaseOrder->isDraft()) {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Only draft purchase orders can be edited.');
        }

        $suppliers = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $products = Product::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('purchase-orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchaseOrder = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        if (!$purchaseOrder->isDraft()) {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Only draft purchase orders can be edited.');
        }

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'expected_delivery_date' => 'nullable|date|after_or_equal:order_date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['quantity'] * $item['unit_cost'];
            }

            $taxAmount = 0; // You can add tax calculation logic here
            $totalAmount = $subtotal + $taxAmount;

            // Update purchase order
            $purchaseOrder->update([
                'supplier_id' => $request->supplier_id,
                'order_date' => $request->order_date,
                'expected_delivery_date' => $request->expected_delivery_date,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'notes' => $request->notes,
            ]);

            // Delete existing items
            $purchaseOrder->items()->delete();

            // Create new items
            foreach ($request->items as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'total_cost' => $item['quantity'] * $item['unit_cost'],
                    'received_quantity' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase order updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to update purchase order: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchaseOrder = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        if (!$purchaseOrder->isDraft()) {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Only draft purchase orders can be deleted.');
        }

        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully!');
    }

    /**
     * Send the purchase order to supplier.
     */
    public function send(string $id)
    {
        $purchaseOrder = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        if (!$purchaseOrder->isDraft()) {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Only draft purchase orders can be sent.');
        }

        $purchaseOrder->update(['status' => 'sent']);

        return redirect()->route('purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order sent to supplier successfully!');
    }

    /**
     * Receive items from supplier.
     */
    public function receive(string $id)
    {
        $purchaseOrder = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->with(['items.product'])
            ->findOrFail($id);

        if (!$purchaseOrder->canBeReceived()) {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'This purchase order cannot be received.');
        }

        DB::beginTransaction();

        try {
            // Update received quantities
            foreach ($purchaseOrder->items as $item) {
                $receivedQuantity = request("received_quantity_{$item->id}", 0);
                $item->update(['received_quantity' => $receivedQuantity]);

                // Update product inventory
                if ($receivedQuantity > 0) {
                    $product = $item->product;
                    $product->increment('quantity', $receivedQuantity);
                }
            }

            // Update PO status
            $completionPercentage = $purchaseOrder->getCompletionPercentage();
            if ($completionPercentage >= 100) {
                $purchaseOrder->update(['status' => 'received']);
            } else {
                $purchaseOrder->update(['status' => 'partial']);
            }

            DB::commit();

            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('success', 'Items received successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'Failed to receive items: ' . $e->getMessage());
        }
    }

    /**
     * Cancel the purchase order.
     */
    public function cancel(string $id)
    {
        $purchaseOrder = PurchaseOrder::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        if (!$purchaseOrder->canBeCancelled()) {
            return redirect()->route('purchase-orders.show', $purchaseOrder)
                ->with('error', 'This purchase order cannot be cancelled.');
        }

        $purchaseOrder->update(['status' => 'cancelled']);

        return redirect()->route('purchase-orders.show', $purchaseOrder)
            ->with('success', 'Purchase order cancelled successfully!');
    }
}
