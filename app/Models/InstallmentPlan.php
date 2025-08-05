<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstallmentPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'customer_id',
        'tenant_id',
        'total_amount',
        'installment_count',
        'installment_amount',
        'payment_frequency',
        'start_date',
        'end_date',
        'status',
        'paid_amount',
        'remaining_amount',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    // Relationships
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function paymentSchedules(): HasMany
    {
        return $this->hasMany(PaymentSchedule::class);
    }

    public function installmentPayments(): HasMany
    {
        return $this->hasMany(InstallmentPayment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue');
    }

    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    // Accessors
    public function getProgressPercentageAttribute()
    {
        if ($this->total_amount == 0) return 0;
        return round(($this->paid_amount / $this->total_amount) * 100, 2);
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed' || $this->paid_amount >= $this->total_amount;
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === 'overdue' || 
               ($this->paymentSchedules()->where('status', 'overdue')->count() > 0);
    }

    // Methods
    public function updateStatus()
    {
        if ($this->paid_amount >= $this->total_amount) {
            $this->update(['status' => 'completed']);
        } elseif ($this->paymentSchedules()->where('status', 'overdue')->count() > 0) {
            $this->update(['status' => 'overdue']);
        } else {
            $this->update(['status' => 'active']);
        }
    }

    public function calculateRemainingAmount()
    {
        $this->remaining_amount = $this->total_amount - $this->paid_amount;
        $this->save();
    }
}
