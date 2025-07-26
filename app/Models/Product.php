<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'cost_price',
        'stock_quantity',
        'min_stock_level',
        'max_stock_level',
        'unit',
        'status',
        'image',
        'tax_rate',
        'is_taxable',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_stock_level' => 'integer',
        'max_stock_level' => 'integer',
        'tax_rate' => 'decimal:2',
        'is_taxable' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function installmentItems(): HasMany
    {
        return $this->hasMany(InstallmentItem::class);
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->min_stock_level;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getStockPercentage(): float
    {
        if ($this->max_stock_level <= 0) {
            return 0;
        }
        return ($this->stock_quantity / $this->max_stock_level) * 100;
    }

    public function getTotalValue(): float
    {
        return $this->stock_quantity * $this->cost_price;
    }
} 