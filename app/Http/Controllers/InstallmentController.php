<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\InstallmentSale;
use App\Models\InstallmentItem;
use App\Models\InstallmentPayment;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class InstallmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $installmentSales = $user->tenant->installmentSales()
            ->with(['customer', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('installments.index', compact('installmentSales'));
    }

    public function create()
    {
        $user = Auth::user();
        $products = $user->tenant->products()->where('status', 'active')->get();
        $customers = $user->tenant->customers()->where('status', 'active')->get();
        
        return view('installments.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'installment_amount' => 'required|numeric|min:0',
            'total_installments' => 'required|integer|min:1',
            'payment_frequency' => 'required|in:weekly,bi-weekly,monthly,quarterly',
            'interest_rate' => 'nullable|numeric|min:0|max:100',
            'first_payment_date' => 'required|date|after:today',
            'guarantor_name' => 'nullable|string|max:255',
            'guarantor_phone' => 'nullable|string|max:20',
            'guarantor_address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        
        DB::beginTransaction();
        
        try {
            // Calculate totals
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += $item['quantity'] * $item['unit_price'];
            }

            $remainingBalance = $totalAmount - $request->down_payment;
            
            if ($remainingBalance <= 0) {
                throw new \Exception('Down payment cannot be greater than or equal to total amount');
            }

            // Create installment sale
            $installmentSale = InstallmentSale::create([
                'tenant_id' => $user->tenant_id,
                'user_id' => $user->id,
                'customer_id' => $request->customer_id,
                'sale_number' => $this->generateInstallmentSaleNumber($user->tenant_id),
                'total_amount' => $totalAmount,
                'down_payment' => $request->down_payment,
                'remaining_balance' => $remainingBalance,
                'installment_amount' => $request->installment_amount,
                'total_installments' => $request->total_installments,
                'payment_frequency' => $request->payment_frequency,
                'interest_rate' => $request->interest_rate ?? 0,
                'sale_date' => now(),
                'first_payment_date' => $request->first_payment_date,
                'status' => 'active',
                'contract_number' => $this->generateContractNumber($user->tenant_id),
                'guarantor_name' => $request->guarantor_name,
                'guarantor_phone' => $request->guarantor_phone,
                'guarantor_address' => $request->guarantor_address,
            ]);

            // Create installment items and update inventory
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}");
                }

                // Create installment item
                InstallmentItem::create([
                    'installment_sale_id' => $installmentSale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['quantity'] * $item['unit_price'],
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
                    'reference_type' => 'installment_sale',
                    'reference_id' => $installmentSale->id,
                    'processed_by' => $user->id,
                    'movement_date' => now(),
                ]);
            }

            // Create installment payment schedule
            $this->createPaymentSchedule($installmentSale, $request->first_payment_date, $request->payment_frequency, $request->total_installments, $request->installment_amount);

            DB::commit();
            
            return redirect()->route('installments.show', $installmentSale->id)
                ->with('success', 'Installment sale created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $installmentSale = $user->tenant->installmentSales()
            ->with(['customer', 'user', 'installmentItems.product', 'installmentPayments'])
            ->findOrFail($id);
            
        return view('installments.show', compact('installmentSale'));
    }

    public function recordPayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'installment_payment_id' => 'required|exists:installment_payments,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        
        DB::beginTransaction();
        
        try {
            $installmentPayment = InstallmentPayment::findOrFail($request->installment_payment_id);
            $installmentSale = $installmentPayment->installmentSale;
            
            // Verify this payment belongs to user's tenant
            if ($installmentSale->tenant_id !== $user->tenant_id) {
                throw new \Exception('Unauthorized access');
            }

            $installmentPayment->update([
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'status' => 'paid',
                'processed_by' => $user->id,
                'notes' => $request->notes,
            ]);

            // Update installment sale remaining balance
            $installmentSale->remaining_balance -= $request->amount;
            $installmentSale->save();

            // Check if all payments are completed
            $remainingPayments = $installmentSale->installmentPayments()
                ->where('status', '!=', 'paid')
                ->count();
                
            if ($remainingPayments === 0) {
                $installmentSale->update(['status' => 'completed']);
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function createPaymentSchedule($installmentSale, $firstPaymentDate, $frequency, $totalInstallments, $installmentAmount)
    {
        $currentDate = Carbon::parse($firstPaymentDate);
        
        for ($i = 1; $i <= $totalInstallments; $i++) {
            InstallmentPayment::create([
                'installment_sale_id' => $installmentSale->id,
                'installment_number' => $i,
                'amount' => $installmentAmount,
                'due_date' => $currentDate,
                'status' => 'scheduled',
            ]);
            
            // Calculate next payment date
            switch ($frequency) {
                case 'weekly':
                    $currentDate = $currentDate->addWeek();
                    break;
                case 'bi-weekly':
                    $currentDate = $currentDate->addWeeks(2);
                    break;
                case 'monthly':
                    $currentDate = $currentDate->addMonth();
                    break;
                case 'quarterly':
                    $currentDate = $currentDate->addMonths(3);
                    break;
            }
        }
    }

    private function generateInstallmentSaleNumber($tenantId)
    {
        $prefix = 'INST';
        $year = date('Y');
        $month = date('m');
        
        $lastSale = InstallmentSale::where('tenant_id', $tenantId)
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

    private function generateContractNumber($tenantId)
    {
        $prefix = 'CON';
        $year = date('Y');
        
        $lastContract = InstallmentSale::where('tenant_id', $tenantId)
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();
            
        if ($lastContract) {
            $lastNumber = (int) substr($lastContract->contract_number, -6);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }
} 