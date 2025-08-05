<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'customer_id',
        'sale_number',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'sale_status',
        'notes',
        'sale_date',
        'due_date',
        'reference_number',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'sale_date' => 'datetime',
        'due_date' => 'datetime',
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

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function installmentPlan(): HasMany
    {
        return $this->hasMany(InstallmentPlan::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isCancelled(): bool
    {
        return $this->sale_status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->sale_status === 'completed';
    }

    public function getPaidAmount(): float
    {
        return $this->payments()->sum('amount');
    }

    public function getRemainingAmount(): float
    {
        return $this->total_amount - $this->getPaidAmount();
    }

    public function isFullyPaid(): bool
    {
        return $this->getRemainingAmount() <= 0;
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !$this->isFullyPaid();
    }
} 