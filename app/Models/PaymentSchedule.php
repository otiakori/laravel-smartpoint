<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'installment_plan_id',
        'tenant_id',
        'installment_number',
        'amount',
        'due_date',
        'status',
        'paid_amount',
        'paid_date',
        'late_fee',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'late_fee' => 'decimal:2',
    ];

    // Relationships
    public function installmentPlan(): BelongsTo
    {
        return $this->belongsTo(InstallmentPlan::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function installmentPayments(): HasMany
    {
        return $this->hasMany(InstallmentPayment::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    public function scopeDueToday($query)
    {
        return $query->where('due_date', today())->where('status', 'pending');
    }

    public function scopePastDue($query)
    {
        return $query->where('due_date', '<', today())->whereIn('status', ['pending', 'partial']);
    }

    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    // Accessors
    public function getIsOverdueAttribute()
    {
        return $this->due_date < today() && in_array($this->status, ['pending', 'partial']);
    }

    public function getIsPaidAttribute()
    {
        return $this->status === 'paid' || $this->paid_amount >= $this->amount;
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    public function getDaysOverdueAttribute()
    {
        if (!$this->is_overdue) return 0;
        return today()->diffInDays($this->due_date);
    }

    // Methods
    public function markAsPaid(float $amount, string $paymentMethod, ?string $referenceNumber = null, ?string $notes = null): void
    {
        $this->update([
            'status' => 'paid',
            'paid_amount' => $this->amount, // Set to full amount when marked as paid
            'paid_date' => now(),
        ]);

        // Create installment payment record
        $this->installmentPayments()->create([
            'installment_sale_id' => null, // Use null since column is now nullable
            'installment_plan_id' => $this->installment_plan_id,
            'payment_schedule_id' => $this->id,
            'installment_number' => $this->installment_number,
            'tenant_id' => $this->tenant_id,
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'reference_number' => $referenceNumber,
            'notes' => $notes,
            'payment_date' => now(),
            'processed_by' => auth()->id(),
        ]);

        // Update installment plan
        $this->installmentPlan->increment('paid_amount', $amount);
        $this->installmentPlan->calculateRemainingAmount();
        $this->installmentPlan->updateStatus();
    }

    public function addPayment($amount, $paymentMethod = 'cash', $referenceNumber = null, $notes = null)
    {
        $newPaidAmount = $this->paid_amount + $amount;
        
        // Update schedule first
        if ($newPaidAmount >= $this->amount) {
            // Mark as fully paid
            $this->markAsPaid($amount, $paymentMethod, $referenceNumber, $notes);
        } else {
            // Update as partial payment
            $this->update([
                'status' => 'partial',
                'paid_amount' => $newPaidAmount,
            ]);
            
            // Create payment record for partial payment
            InstallmentPayment::create([
                'installment_sale_id' => null, // Use null since column is now nullable
                'installment_plan_id' => $this->installment_plan_id,
                'payment_schedule_id' => $this->id,
                'installment_number' => $this->installment_number,
                'amount' => $amount,
                'payment_method' => $paymentMethod,
                'reference_number' => $referenceNumber,
                'notes' => $notes,
                'tenant_id' => $this->tenant_id,
                'payment_date' => now(),
                'processed_by' => auth()->id(),
            ]);
        }
    }

    public function calculateLateFee()
    {
        if (!$this->is_overdue) return 0;
        
        $daysOverdue = $this->days_overdue;
        $lateFeeRate = 0.05; // 5% per month
        $lateFee = $this->remaining_amount * ($lateFeeRate / 30) * $daysOverdue;
        
        $this->update(['late_fee' => $lateFee]);
        return $lateFee;
    }
}
