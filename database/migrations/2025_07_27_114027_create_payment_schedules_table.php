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
        Schema::create('payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installment_plan_id')->constrained('installment_plans')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->integer('installment_number');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->enum('status', ['pending', 'paid', 'overdue', 'partial'])->default('pending');
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->date('paid_date')->nullable();
            $table->decimal('late_fee', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['tenant_id', 'status']);
            $table->index(['installment_plan_id', 'status']);
            $table->index(['due_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_schedules');
    }
};
