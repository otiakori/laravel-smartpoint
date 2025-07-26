<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('sale_number')->unique();
            $table->decimal('subtotal', 12, 2);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('sale_status')->default('completed');
            $table->text('notes')->nullable();
            $table->timestamp('sale_date');
            $table->timestamp('due_date')->nullable();
            $table->string('reference_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
