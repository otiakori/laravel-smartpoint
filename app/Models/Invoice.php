<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'customer_id',
        'invoice_number',
        'reference_number',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'invoice_status',
        'notes',
        'terms_conditions',
        'invoice_date',
        'due_date',
        'sent_at',
        'viewed_at',
        'paid_at',
    ];

    protected $casts = [
        'invoice_date' => 'datetime',
        'due_date' => 'datetime',
        'sent_at' => 'datetime',
        'viewed_at' => 'datetime',
        'paid_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
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

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('invoice_status', $status);
    }

    public function scopeByPaymentStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->whereIn('payment_status', ['pending', 'partial']);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', today())
            ->whereIn('payment_status', ['pending', 'partial']);
    }

    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [now(), now()->addWeek()])
            ->whereIn('payment_status', ['pending', 'partial']);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date && $this->due_date->isPast() && 
               in_array($this->payment_status, ['pending', 'partial']);
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->is_overdue) {
            return 0;
        }
        return $this->due_date->diffInDays(now());
    }

    public function getDaysUntilDueAttribute(): int
    {
        if (!$this->due_date || $this->is_overdue) {
            return 0;
        }
        return $this->due_date->diffInDays(now(), false);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->invoice_status) {
            'draft' => 'gray',
            'sent' => 'blue',
            'viewed' => 'yellow',
            'paid' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            'pending' => 'yellow',
            'partial' => 'orange',
            'paid' => 'green',
            'overdue' => 'red',
            'cancelled' => 'gray',
            default => 'gray'
        };
    }

    public function markAsSent(): void
    {
        $this->update([
            'invoice_status' => 'sent',
            'sent_at' => now()
        ]);
    }

    public function markAsViewed(): void
    {
        $this->update([
            'invoice_status' => 'viewed',
            'viewed_at' => now()
        ]);
    }

    public function markAsPaid(): void
    {
        $this->update([
            'payment_status' => 'paid',
            'invoice_status' => 'paid',
            'paid_at' => now()
        ]);
    }

    public function markAsCancelled(): void
    {
        $this->update([
            'payment_status' => 'cancelled',
            'invoice_status' => 'cancelled'
        ]);
    }

    public function generateInvoiceNumber(): string
    {
        $prefix = 'INV';
        $year = now()->format('Y');
        $month = now()->format('m');
        
        $tenantId = $this->tenant_id ?? Auth::user()->tenant_id;
        
        $lastInvoice = static::where('tenant_id', $tenantId)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastInvoice && preg_match('/(\d{4})$/', $lastInvoice->invoice_number, $matches)) {
            $sequence = (int)$matches[1] + 1;
        } else {
            $sequence = 1;
        }
        
        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = $invoice->generateInvoiceNumber();
            }
        });
    }
} 