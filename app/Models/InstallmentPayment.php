<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallmentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'installment_sale_id',
        'installment_number',
        'amount',
        'due_date',
        'payment_date',
        'payment_method',
        'status',
        'late_fees',
        'notes',
        'processed_by',
        'reference_number',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'datetime',
        'payment_date' => 'datetime',
        'late_fees' => 'decimal:2',
        'installment_number' => 'integer',
    ];

    public function installmentSale(): BelongsTo
    {
        return $this->belongsTo(InstallmentSale::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'paid';
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function isPartial(): bool
    {
        return $this->status === 'partial';
    }

    public function getDaysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }
        return $this->due_date->diffInDays(now());
    }

    public function getTotalAmount(): float
    {
        return $this->amount + $this->late_fees;
    }

    public function isLate(): bool
    {
        return $this->payment_date && $this->due_date && $this->payment_date->gt($this->due_date);
    }

    public function getDaysLate(): int
    {
        if (!$this->isLate()) {
            return 0;
        }
        return $this->due_date->diffInDays($this->payment_date);
    }
} 