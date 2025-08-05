<?php

namespace App\Http\Controllers;

use App\Models\InstallmentPlan;
use App\Models\PaymentSchedule;
use App\Models\Sale;
use App\Models\Customer;
use App\Services\InstallmentPlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InstallmentPlanController extends Controller
{
    protected $installmentPlanService;

    public function __construct(InstallmentPlanService $installmentPlanService)
    {
        $this->installmentPlanService = $installmentPlanService;
    }

    /**
     * Display a listing of installment plans
     */
    public function index(Request $request)
    {
        $query = InstallmentPlan::with(['customer', 'sale'])
            ->where('tenant_id', Auth::user()->tenant_id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Search by customer name
        if ($request->filled('search')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $installmentPlans = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get statistics
        $stats = $this->installmentPlanService->getStatistics(Auth::user()->tenant_id);

        return view('installment-plans.index', compact('installmentPlans', 'stats'));
    }

    /**
     * Show the form for creating a new installment plan
     */
    public function create(Request $request)
    {
        $customers = Customer::where('tenant_id', Auth::user()->tenant_id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $recentSales = Sale::where('tenant_id', Auth::user()->tenant_id)
            ->where('payment_method', 'cash')
            ->whereDoesntHave('installmentPlan')
            ->with(['customer'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $sales = Sale::where('tenant_id', Auth::user()->tenant_id)
            ->where('payment_method', 'cash')
            ->whereDoesntHave('installmentPlan')
            ->with(['customer', 'saleItems.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        // If sale_id is provided, pre-select that sale
        $selectedSale = null;
        if ($request->has('sale_id')) {
            $selectedSale = Sale::where('id', $request->sale_id)
                ->where('tenant_id', Auth::user()->tenant_id)
                ->with(['customer', 'saleItems.product'])
                ->first();
        }

        return view('installment-plans.create', compact('customers', 'sales', 'selectedSale'));
    }

    /**
     * Store a newly created installment plan
     */
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'customer_id' => 'required|exists:customers,id',
            'installment_count' => 'required|integer|min:2|max:24',
            'payment_frequency' => 'required|in:weekly,biweekly,monthly,quarterly',
            'start_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        try {
            // Debug: Log the request data
            \Log::info('Installment plan creation request', $request->all());
            
            $sale = Sale::findOrFail($request->sale_id);
            $customer = Customer::findOrFail($request->customer_id);

            // Calculate installment amount
            $installmentAmount = round($sale->total_amount / $request->installment_count, 2);

            $data = [
                'installment_count' => $request->installment_count,
                'installment_amount' => $installmentAmount,
                'payment_frequency' => $request->payment_frequency,
                'start_date' => $request->start_date,
                'notes' => $request->notes,
            ];

            // Debug: Log the data being passed to service
            \Log::info('Installment plan data', $data);

            $installmentPlan = $this->installmentPlanService->createFromSale($sale, $customer, $data);

            // Debug: Log the created installment plan
            \Log::info('Installment plan created', ['id' => $installmentPlan->id]);

            return redirect()->route('installment-plans.show', $installmentPlan)
                ->with('success', 'Installment plan created successfully!');
        } catch (\Exception $e) {
            // Debug: Log the error
            \Log::error('Installment plan creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['error' => 'Failed to create installment plan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified installment plan
     */
    public function show(InstallmentPlan $installmentPlan)
    {
        $installmentPlan->load(['customer', 'sale', 'paymentSchedules.installmentPayments']);

        // Ensure user can only access their tenant's data
        if ($installmentPlan->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        return view('installment-plans.show', compact('installmentPlan'));
    }

    /**
     * Show the form for editing the specified installment plan
     */
    public function edit(InstallmentPlan $installmentPlan)
    {
        // Ensure user can only access their tenant's data
        if ($installmentPlan->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $installmentPlan->load(['customer', 'sale', 'paymentSchedules']);

        return view('installment-plans.edit', compact('installmentPlan'));
    }

    /**
     * Update the specified installment plan
     */
    public function update(Request $request, InstallmentPlan $installmentPlan)
    {
        // Ensure user can only access their tenant's data
        if ($installmentPlan->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $request->validate([
            'notes' => 'nullable|string',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $installmentPlan->update([
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('installment-plans.show', $installmentPlan)
            ->with('success', 'Installment plan updated successfully!');
    }

    /**
     * Process a payment for an installment plan
     */
    public function processPayment(Request $request, InstallmentPlan $installmentPlan)
    {
        // Debug: Log the request
        \Log::info('Processing payment for installment plan', [
            'plan_id' => $installmentPlan->id,
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        // Ensure user can only access their tenant's data
        if ($installmentPlan->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,card,bank_transfer,mobile_money',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $this->installmentPlanService->processPayment(
                $installmentPlan,
                $request->amount,
                $request->payment_method,
                $request->reference_number,
                $request->notes
            );

            \Log::info('Payment processed successfully', ['plan_id' => $installmentPlan->id]);
            return response()->json(['success' => true, 'message' => 'Payment processed successfully!']);
        } catch (\Exception $e) {
            \Log::error('Payment processing failed', [
                'plan_id' => $installmentPlan->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to process payment: ' . $e->getMessage()]);
        }
    }

    /**
     * Pay a specific payment schedule
     */
    public function paySchedule(Request $request, InstallmentPlan $installmentPlan, PaymentSchedule $paymentSchedule)
    {
        // Debug: Log the request
        \Log::info('Processing payment for schedule', [
            'plan_id' => $installmentPlan->id,
            'schedule_id' => $paymentSchedule->id,
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        // Ensure user can only access their tenant's data
        if ($installmentPlan->tenant_id !== Auth::user()->tenant_id || 
            $paymentSchedule->installment_plan_id !== $installmentPlan->id) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,card,bank_transfer,mobile_money',
            'reference_number' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        try {
            $paymentSchedule->markAsPaid($request->amount, $request->payment_method, $request->reference_number, $request->notes);
            
            \Log::info('Schedule payment processed successfully', [
                'plan_id' => $installmentPlan->id,
                'schedule_id' => $paymentSchedule->id
            ]);
            return response()->json(['success' => true, 'message' => 'Payment processed successfully!']);
        } catch (\Exception $e) {
            \Log::error('Schedule payment processing failed', [
                'plan_id' => $installmentPlan->id,
                'schedule_id' => $paymentSchedule->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Failed to process payment: ' . $e->getMessage()]);
        }
    }

    /**
     * Get overdue payments
     */
    public function overdue()
    {
        $overdueSchedules = $this->installmentPlanService->getOverdueSchedules(Auth::user()->tenant_id);

        return view('installment-plans.overdue', compact('overdueSchedules'));
    }

    /**
     * Get due today payments
     */
    public function dueToday()
    {
        $dueTodaySchedules = $this->installmentPlanService->getDueTodaySchedules(Auth::user()->tenant_id);

        return view('installment-plans.due-today', compact('dueTodaySchedules'));
    }

    /**
     * Get installment plan statistics for dashboard
     */
    public function statistics()
    {
        $statistics = $this->installmentPlanService->getStatistics(Auth::user()->tenant_id);

        return response()->json($statistics);
    }
}
