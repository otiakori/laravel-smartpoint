<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->orderBy('name')
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
            'credit_balance' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Customer::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'credit_limit' => $request->credit_limit ?? 0,
            'credit_balance' => $request->credit_balance ?? 0,
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully!');
    }

    public function edit(Customer $customer)
    {
        // Ensure user can only edit customers from their tenant
        if ($customer->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        // Ensure user can only update customers from their tenant
        if ($customer->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
            'credit_balance' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'credit_limit' => $request->credit_limit ?? 0,
            'credit_balance' => $request->credit_balance ?? 0,
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    public function destroy(Customer $customer)
    {
        // Ensure user can only delete customers from their tenant
        if ($customer->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }

    public function show(Customer $customer)
    {
        // Ensure user can only view customers from their tenant
        if ($customer->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        // Load related sales and installment sales
        $customer->load(['sales', 'installmentSales']);

        return view('customers.show', compact('customer'));
    }

    public function apiIndex()
    {
        $customers = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->select('id', 'name', 'email', 'phone')
            ->orderBy('name')
            ->get();

        return response()->json(['customers' => $customers]);
    }
} 