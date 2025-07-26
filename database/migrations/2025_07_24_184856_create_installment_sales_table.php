<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installment_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('sale_number')->unique();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('down_payment', 12, 2)->default(0);
            $table->decimal('remaining_balance', 12, 2);
            $table->decimal('installment_amount', 12, 2);
            $table->integer('total_installments');
            $table->string('payment_frequency'); // weekly, bi-weekly, monthly, quarterly
            $table->decimal('interest_rate', 5, 2)->default(0);
            $table->timestamp('sale_date');
            $table->timestamp('first_payment_date')->nullable();
            $table->string('status')->default('active');
            $table->text('notes')->nullable();
            $table->string('contract_number')->unique();
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_phone')->nullable();
            $table->text('guarantor_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installment_sales');
    }
};
