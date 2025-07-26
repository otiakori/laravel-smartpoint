<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstallmentSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'customer_id',
        'sale_number',
        'total_amount',
        'down_payment',
        'remaining_balance',
        'installment_amount',
        'total_installments',
        'payment_frequency',
        'interest_rate',
        'sale_date',
        'first_payment_date',
        'status',
        'notes',
        'contract_number',
        'guarantor_name',
        'guarantor_phone',
        'guarantor_address',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'total_installments' => 'integer',
        'interest_rate' => 'decimal:2',
        'sale_date' => 'datetime',
        'first_payment_date' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function installmentItems(): HasMany
    {
        return $this->hasMany(InstallmentItem::class);
    }

    public function installmentPayments(): HasMany
    {
        return $this->hasMany(InstallmentPayment::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isDefaulted(): bool
    {
        return $this->status === 'defaulted';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function getPaidAmount(): float
    {
        return $this->installmentPayments()->sum('amount');
    }

    public function getRemainingAmount(): float
    {
        return $this->remaining_balance - $this->getPaidAmount();
    }

    public function isFullyPaid(): bool
    {
        return $this->getRemainingAmount() <= 0;
    }

    public function getNextPaymentDate(): ?string
    {
        $lastPayment = $this->installmentPayments()->latest('payment_date')->first();
        
        if (!$lastPayment) {
            return $this->first_payment_date?->format('Y-m-d');
        }

        $nextDate = $lastPayment->payment_date;
        
        switch ($this->payment_frequency) {
            case 'weekly':
                $nextDate = $nextDate->addWeek();
                break;
            case 'bi-weekly':
                $nextDate = $nextDate->addWeeks(2);
                break;
            case 'monthly':
                $nextDate = $nextDate->addMonth();
                break;
            case 'quarterly':
                $nextDate = $nextDate->addMonths(3);
                break;
        }

        return $nextDate->format('Y-m-d');
    }

    public function getOverdueAmount(): float
    {
        $overduePayments = $this->installmentPayments()
            ->where('due_date', '<', now())
            ->where('status', '!=', 'paid')
            ->get();

        return $overduePayments->sum('amount');
    }

    public function getCompletedInstallments(): int
    {
        return $this->installmentPayments()->where('status', 'paid')->count();
    }

    public function getRemainingInstallments(): int
    {
        return $this->total_installments - $this->getCompletedInstallments();
    }

    public function getProgressPercentage(): float
    {
        if ($this->total_installments <= 0) {
            return 0;
        }
        return ($this->getCompletedInstallments() / $this->total_installments) * 100;
    }
} 