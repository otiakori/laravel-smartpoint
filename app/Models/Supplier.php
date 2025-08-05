<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'tax_id',
        'payment_terms',
        'credit_limit',
        'current_balance',
        'status',
        'rating',
        'notes',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'rating' => 'integer',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SupplierPayment::class);
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

    public function getPerformanceRating(): string
    {
        if ($this->rating >= 4) {
            return 'excellent';
        } elseif ($this->rating >= 3) {
            return 'good';
        } elseif ($this->rating >= 2) {
            return 'fair';
        } else {
            return 'poor';
        }
    }

    public function getTotalPurchases(): float
    {
        return $this->purchaseOrders()
            ->where('status', '!=', 'cancelled')
            ->sum('total_amount');
    }

    public function getOutstandingBalance(): float
    {
        return $this->current_balance;
    }
}
