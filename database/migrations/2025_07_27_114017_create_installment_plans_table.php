<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('installment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->integer('installment_count');
            $table->decimal('installment_amount', 10, 2);
            $table->enum('payment_frequency', ['weekly', 'monthly'])->default('monthly');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'completed', 'cancelled', 'overdue'])->default('active');
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('remaining_amount', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'status']);
            $table->index(['customer_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_plans');
    }
};
