<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'supplier_id',
        'po_number',
        'order_date',
        'expected_delivery_date',
        'status',
        'subtotal',
        'tax_amount',
        'total_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    public function isReceived(): bool
    {
        return $this->status === 'received';
    }

    public function isPartial(): bool
    {
        return $this->status === 'partial';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function getReceivedQuantity(): int
    {
        return $this->items->sum('received_quantity');
    }

    public function getTotalQuantity(): int
    {
        return $this->items->sum('quantity');
    }

    public function getCompletionPercentage(): float
    {
        $totalQuantity = $this->getTotalQuantity();
        if ($totalQuantity === 0) {
            return 0;
        }
        return ($this->getReceivedQuantity() / $totalQuantity) * 100;
    }

    public function isOverdue(): bool
    {
        return $this->expected_delivery_date && 
               $this->expected_delivery_date->isPast() && 
               !$this->isReceived() && 
               !$this->isCancelled();
    }

    public function canBeReceived(): bool
    {
        return in_array($this->status, ['sent', 'partial']);
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['draft', 'sent']);
    }
}
