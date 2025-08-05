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
        Schema::table('installment_payments', function (Blueprint $table) {
            // Add missing tenant_id column
            $table->foreignId('tenant_id')->nullable()->after('payment_schedule_id')->constrained('tenants')->onDelete('cascade');
            
            // Add index for better performance
            $table->index(['tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('installment_payments', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['tenant_id']);
            
            // Drop index
            $table->dropIndex(['tenant_id']);
            
            // Drop column
            $table->dropColumn(['tenant_id']);
        });
    }
};
