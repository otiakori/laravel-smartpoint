<?php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = SupplierPayment::where('tenant_id', Auth::user()->tenant_id)
            ->with(['supplier', 'createdBy'])
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('supplier-payments.index', compact('payments'));
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

        return view('supplier-payments.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string|max:100',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Create payment
            $payment = SupplierPayment::create([
                'tenant_id' => Auth::user()->tenant_id,
                'supplier_id' => $request->supplier_id,
                'payment_date' => $request->payment_date,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // Update supplier balance
            $supplier = Supplier::find($request->supplier_id);
            $supplier->decrement('current_balance', $request->amount);

            DB::commit();

            return redirect()->route('supplier-payments.show', $payment)
                ->with('success', 'Payment recorded successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to record payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = SupplierPayment::where('tenant_id', Auth::user()->tenant_id)
            ->with(['supplier', 'createdBy'])
            ->findOrFail($id);

        return view('supplier-payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = SupplierPayment::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $suppliers = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('supplier-payments.edit', compact('payment', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = SupplierPayment::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string|max:100',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Revert old payment amount
            $oldSupplier = Supplier::find($payment->supplier_id);
            $oldSupplier->increment('current_balance', $payment->amount);

            // Update payment
            $payment->update([
                'supplier_id' => $request->supplier_id,
                'payment_date' => $request->payment_date,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
            ]);

            // Update new supplier balance
            $newSupplier = Supplier::find($request->supplier_id);
            $newSupplier->decrement('current_balance', $request->amount);

            DB::commit();

            return redirect()->route('supplier-payments.show', $payment)
                ->with('success', 'Payment updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Failed to update payment: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = SupplierPayment::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($id);

        DB::beginTransaction();

        try {
            // Revert supplier balance
            $supplier = Supplier::find($payment->supplier_id);
            $supplier->increment('current_balance', $payment->amount);

            $payment->delete();

            DB::commit();

            return redirect()->route('supplier-payments.index')
                ->with('success', 'Payment deleted successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('supplier-payments.index')
                ->with('error', 'Failed to delete payment: ' . $e->getMessage());
        }
    }

    /**
     * Show payment history for a specific supplier.
     */
    public function history(string $supplierId)
    {
        $supplier = Supplier::where('tenant_id', Auth::user()->tenant_id)
            ->findOrFail($supplierId);

        $payments = SupplierPayment::where('tenant_id', Auth::user()->tenant_id)
            ->where('supplier_id', $supplierId)
            ->with(['createdBy'])
            ->orderBy('payment_date', 'desc')
            ->paginate(10);

        return view('supplier-payments.history', compact('supplier', 'payments'));
    }
}
