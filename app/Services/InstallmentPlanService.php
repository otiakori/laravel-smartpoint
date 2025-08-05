<?php

namespace App\Services;

use App\Models\InstallmentPlan;
use App\Models\PaymentSchedule;
use App\Models\Sale;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InstallmentPlanService
{
    /**
     * Create an installment plan from a sale
     */
    public function createFromSale(Sale $sale, Customer $customer, array $data): InstallmentPlan
    {
        return DB::transaction(function () use ($sale, $customer, $data) {
            // Debug: Log the data being used
            \Log::info('Creating installment plan from sale', [
                'sale_id' => $sale->id,
                'customer_id' => $customer->id,
                'tenant_id' => $sale->tenant_id,
                'data' => $data
            ]);

            // Parse start date to Carbon instance
            $startDate = Carbon::parse($data['start_date'] ?? now());
            
            // Create installment plan
            $installmentPlan = InstallmentPlan::create([
                'sale_id' => $sale->id,
                'customer_id' => $customer->id,
                'tenant_id' => $sale->tenant_id,
                'total_amount' => $sale->total_amount,
                'installment_count' => $data['installment_count'],
                'installment_amount' => $data['installment_amount'],
                'payment_frequency' => $data['payment_frequency'] ?? 'monthly',
                'start_date' => $startDate,
                'end_date' => $this->calculateEndDate($startDate, $data['installment_count'], $data['payment_frequency'] ?? 'monthly'),
                'status' => 'active',
                'paid_amount' => 0,
                'remaining_amount' => $sale->total_amount,
                'notes' => $data['notes'] ?? null,
            ]);

            // Debug: Log the created installment plan
            \Log::info('Installment plan created', ['id' => $installmentPlan->id]);

            // Create payment schedules
            $this->createPaymentSchedules($installmentPlan, $data);

            // Debug: Log the payment schedules
            \Log::info('Payment schedules created', ['count' => $installmentPlan->paymentSchedules()->count()]);

            return $installmentPlan;
        });
    }

    /**
     * Create payment schedules for an installment plan
     */
    private function createPaymentSchedules(InstallmentPlan $installmentPlan, array $data): void
    {
        $startDate = Carbon::parse($data['start_date'] ?? now());
        $installmentCount = $data['installment_count'];
        $installmentAmount = $data['installment_amount'];
        $frequency = $data['payment_frequency'] ?? 'monthly';

        // Debug: Log the payment schedule creation
        \Log::info('Creating payment schedules', [
            'installment_plan_id' => $installmentPlan->id,
            'start_date' => $startDate,
            'installment_count' => $installmentCount,
            'installment_amount' => $installmentAmount,
            'frequency' => $frequency
        ]);

        for ($i = 1; $i <= $installmentCount; $i++) {
            $dueDate = $this->calculateDueDate($startDate, $i, $frequency);
            
            // Calculate amount for this installment
            $amount = $installmentAmount;
            if ($i === $installmentCount) {
                // Last installment gets the remainder
                $totalScheduled = $installmentAmount * ($installmentCount - 1);
                $amount = $installmentPlan->total_amount - $totalScheduled;
            }

            $paymentSchedule = PaymentSchedule::create([
                'installment_plan_id' => $installmentPlan->id,
                'tenant_id' => $installmentPlan->tenant_id,
                'installment_number' => $i,
                'amount' => $amount,
                'due_date' => $dueDate,
                'status' => 'pending',
                'paid_amount' => 0,
                'late_fee' => 0,
            ]);

            // Debug: Log each payment schedule
            \Log::info('Payment schedule created', [
                'id' => $paymentSchedule->id,
                'installment_number' => $i,
                'amount' => $amount,
                'due_date' => $dueDate->format('Y-m-d')
            ]);
        }
    }

    /**
     * Calculate due date for an installment
     */
    private function calculateDueDate(Carbon $startDate, int $installmentNumber, string $frequency): Carbon
    {
        $dueDate = $startDate->copy();
        
        switch ($frequency) {
            case 'weekly':
                $dueDate->addWeeks($installmentNumber - 1);
                break;
            case 'biweekly':
                $dueDate->addWeeks(($installmentNumber - 1) * 2);
                break;
            case 'quarterly':
                $dueDate->addMonths(($installmentNumber - 1) * 3);
                break;
            default: // monthly
                $dueDate->addMonths($installmentNumber - 1);
                break;
        }

        return $dueDate;
    }

    /**
     * Calculate end date for the installment plan
     */
    private function calculateEndDate(Carbon $startDate, int $installmentCount, string $frequency): Carbon
    {
        $endDate = $startDate->copy();
        
        switch ($frequency) {
            case 'weekly':
                $endDate->addWeeks($installmentCount - 1);
                break;
            case 'biweekly':
                $endDate->addWeeks(($installmentCount - 1) * 2);
                break;
            case 'quarterly':
                $endDate->addMonths(($installmentCount - 1) * 3);
                break;
            default: // monthly
                $endDate->addMonths($installmentCount - 1);
                break;
        }

        return $endDate;
    }

    /**
     * Process a payment for an installment plan
     */
    public function processPayment(InstallmentPlan $installmentPlan, float $amount, string $paymentMethod = 'cash', ?string $referenceNumber = null, ?string $notes = null): void
    {
        \Log::info('InstallmentPlanService::processPayment called', [
            'plan_id' => $installmentPlan->id,
            'amount' => $amount,
            'payment_method' => $paymentMethod
        ]);

        DB::transaction(function () use ($installmentPlan, $amount, $paymentMethod, $referenceNumber, $notes) {
            // Find the next due payment schedule
            $paymentSchedule = $installmentPlan->paymentSchedules()
                ->where('status', '!=', 'paid')
                ->orderBy('due_date')
                ->first();

            \Log::info('Found payment schedule', [
                'schedule_id' => $paymentSchedule ? $paymentSchedule->id : null,
                'status' => $paymentSchedule ? $paymentSchedule->status : null
            ]);

            if (!$paymentSchedule) {
                throw new \Exception('No pending payments found for this installment plan.');
            }

            // Process the payment
            $paymentSchedule->addPayment($amount, $paymentMethod, $referenceNumber, $notes);
            
            \Log::info('Payment processed successfully', [
                'schedule_id' => $paymentSchedule->id,
                'amount' => $amount
            ]);
        });
    }

    /**
     * Get installment plan statistics
     */
    public function getStatistics(int $tenantId): array
    {
        $activePlans = InstallmentPlan::byTenant($tenantId)->active()->count();
        $completedPlans = InstallmentPlan::byTenant($tenantId)->completed()->count();
        $overduePlans = InstallmentPlan::byTenant($tenantId)->overdue()->count();
        
        $totalAmount = InstallmentPlan::byTenant($tenantId)->sum('total_amount');
        $totalPaid = InstallmentPlan::byTenant($tenantId)->sum('paid_amount');
        $totalRemaining = InstallmentPlan::byTenant($tenantId)->sum('remaining_amount');

        $overdueCount = PaymentSchedule::byTenant($tenantId)->pastDue()->count();
        $dueToday = PaymentSchedule::byTenant($tenantId)->dueToday()->count();

        return [
            'active_plans' => $activePlans,
            'completed_plans' => $completedPlans,
            'overdue_plans' => $overduePlans,
            'total_amount' => $totalAmount,
            'total_paid' => $totalPaid,
            'total_remaining' => $totalRemaining,
            'total_outstanding' => $totalRemaining,
            'overdue_count' => $overdueCount,
            'due_today' => $dueToday,
            'collection_rate' => $totalAmount > 0 ? round(($totalPaid / $totalAmount) * 100, 2) : 0,
        ];
    }

    /**
     * Get overdue payment schedules
     */
    public function getOverdueSchedules(int $tenantId): \Illuminate\Database\Eloquent\Collection
    {
        return PaymentSchedule::byTenant($tenantId)
            ->pastDue()
            ->with(['installmentPlan.customer'])
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Get due today payment schedules
     */
    public function getDueTodaySchedules(int $tenantId): \Illuminate\Database\Eloquent\Collection
    {
        return PaymentSchedule::byTenant($tenantId)
            ->dueToday()
            ->with(['installmentPlan.customer'])
            ->get();
    }
} 