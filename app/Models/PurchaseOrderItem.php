<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'quantity',
        'unit_cost',
        'total_cost',
        'received_quantity',
        'notes',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'quantity' => 'integer',
        'received_quantity' => 'integer',
    ];

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getRemainingQuantity(): int
    {
        return $this->quantity - $this->received_quantity;
    }

    public function isFullyReceived(): bool
    {
        return $this->received_quantity >= $this->quantity;
    }

    public function isPartiallyReceived(): bool
    {
        return $this->received_quantity > 0 && $this->received_quantity < $this->quantity;
    }

    public function isNotReceived(): bool
    {
        return $this->received_quantity === 0;
    }

    public function getCompletionPercentage(): float
    {
        if ($this->quantity === 0) {
            return 0;
        }
        return ($this->received_quantity / $this->quantity) * 100;
    }
}
