<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'item_name',
        'description',
        'quantity',
        'unit_price',
        'tax_rate',
        'tax_amount',
        'discount_amount',
        'total_amount',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateTotals(): void
    {
        $subtotal = $this->quantity * $this->unit_price;
        $this->tax_amount = ($subtotal * $this->tax_rate) / 100;
        $this->total_amount = $subtotal + $this->tax_amount - $this->discount_amount;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($item) {
            $item->calculateTotals();
        });
    }
} 