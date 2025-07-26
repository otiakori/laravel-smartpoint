<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'product_id',
        'movement_type',
        'quantity',
        'previous_quantity',
        'new_quantity',
        'reference_type',
        'reference_id',
        'notes',
        'supplier',
        'cost_per_unit',
        'reason',
        'processed_by',
        'movement_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'previous_quantity' => 'integer',
        'new_quantity' => 'integer',
        'reference_id' => 'integer',
        'cost_per_unit' => 'decimal:2',
        'movement_date' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function isInbound(): bool
    {
        return in_array($this->movement_type, ['purchase', 'return', 'adjustment_in']);
    }

    public function isOutbound(): bool
    {
        return in_array($this->movement_type, ['sale', 'damage', 'adjustment_out']);
    }

    public function getMovementDescription(): string
    {
        return match($this->movement_type) {
            'purchase' => 'Stock Purchase',
            'sale' => 'Sale',
            'return' => 'Customer Return',
            'damage' => 'Damaged Stock',
            'adjustment_in' => 'Stock Adjustment (In)',
            'adjustment_out' => 'Stock Adjustment (Out)',
            default => 'Unknown Movement'
        };
    }
} 