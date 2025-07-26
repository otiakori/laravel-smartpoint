<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installment_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('installment_sale_id')->constrained()->onDelete('cascade');
            $table->integer('installment_number');
            $table->decimal('amount', 12, 2);
            $table->timestamp('due_date');
            $table->timestamp('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->default('scheduled'); // scheduled, paid, partial, overdue
            $table->decimal('late_fees', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('reference_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installment_payments');
    }
};
