<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'credit_limit',
        'current_balance',
        'payment_terms',
        'status',
        'notes',
        'date_of_birth',
        'gender',
        'loyalty_points',
        'total_spent',
        'last_purchase_date',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'loyalty_points' => 'integer',
        'total_spent' => 'decimal:2',
        'last_purchase_date' => 'datetime',
        'date_of_birth' => 'date',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function installmentSales(): HasMany
    {
        return $this->hasMany(InstallmentSale::class);
    }

    public function creditPayments(): HasMany
    {
        return $this->hasMany(CreditPayment::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function hasCredit(): bool
    {
        return $this->credit_limit > 0;
    }

    public function getAvailableCredit(): float
    {
        return max(0, $this->credit_limit - $this->current_balance);
    }

    public function isOverdue(): bool
    {
        return $this->current_balance > 0;
    }

    public function getCreditUtilization(): float
    {
        if ($this->credit_limit <= 0) {
            return 0;
        }
        return ($this->current_balance / $this->credit_limit) * 100;
    }

    public function getLoyaltyTier(): string
    {
        if ($this->total_spent >= 10000) {
            return 'platinum';
        } elseif ($this->total_spent >= 5000) {
            return 'gold';
        } elseif ($this->total_spent >= 1000) {
            return 'silver';
        } else {
            return 'bronze';
        }
    }
} 