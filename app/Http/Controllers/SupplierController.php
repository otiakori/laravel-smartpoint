<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->with(['purchaseOrders', 'payments'])
            ->orderBy('name')
            ->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:100',
            'payment_terms' => 'nullable|string|max:255',
            'credit_limit' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'rating' => 'nullable|integer|min:0|max:5',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Supplier::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'tax_id' => $request->tax_id,
            'payment_terms' => $request->payment_terms,
            'credit_limit' => $request->credit_limit ?? 0,
            'current_balance' => 0,
            'status' => $request->status,
            'rating' => $request->rating ?? 0,
            'notes' => $request->notes,
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->with(['purchaseOrders.items.product', 'payments'])
            ->findOrFail($id);

        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:100',
            'payment_terms' => 'nullable|string|max:255',
            'credit_limit' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'rating' => 'nullable|integer|min:0|max:5',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $supplier->update([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'tax_id' => $request->tax_id,
            'payment_terms' => $request->payment_terms,
            'credit_limit' => $request->credit_limit ?? 0,
            'status' => $request->status,
            'rating' => $request->rating ?? 0,
            'notes' => $request->notes,
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        // Check if supplier has any purchase orders
        if ($supplier->purchaseOrders()->count() > 0) {
            return redirect()->route('suppliers.index')
                ->with('error', 'Cannot delete supplier with existing purchase orders.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier deleted successfully!');
    }
}
