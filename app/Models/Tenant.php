<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'email',
        'phone',
        'address',
        'currency',
        'currency_symbol',
        'tax_rate',
        'tax_enabled',
        'tax_name',
        'tax_inclusive',
        'theme',
        'timezone',
        'date_format',
        'time_format',
        'subscription_plan',
        'subscription_status',
        'trial_ends_at',
        'settings',
        'status',
    ];

    protected $casts = [
        'settings' => 'array',
        'trial_ends_at' => 'datetime',
        'tax_rate' => 'decimal:2',
        'tax_enabled' => 'boolean',
        'tax_inclusive' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function installmentSales(): HasMany
    {
        return $this->hasMany(InstallmentSale::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function hasSubscription(): bool
    {
        return $this->subscription_status === 'active';
    }

    public function isTaxEnabled(): bool
    {
        return $this->tax_enabled && $this->tax_rate > 0;
    }

    public function calculateTax($amount): float
    {
        if (!$this->isTaxEnabled()) {
            return 0;
        }
        return round($amount * ($this->tax_rate / 100), 2);
    }

    public function calculateTaxInclusivePrice($amount): float
    {
        if (!$this->isTaxEnabled()) {
            return $amount;
        }
        return round($amount / (1 + ($this->tax_rate / 100)), 2);
    }

    public function calculateTaxExclusivePrice($amount): float
    {
        if (!$this->isTaxEnabled()) {
            return $amount;
        }
        return round($amount * (1 + ($this->tax_rate / 100)), 2);
    }
} 