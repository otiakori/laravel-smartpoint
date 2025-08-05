<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the foreign key constraint first
        Schema::table('installment_payments', function (Blueprint $table) {
            $table->dropForeign(['installment_sale_id']);
        });

        // Use raw SQL to modify the column
        DB::statement('ALTER TABLE installment_payments MODIFY installment_sale_id BIGINT UNSIGNED NULL');

        // Re-add the foreign key constraint
        Schema::table('installment_payments', function (Blueprint $table) {
            $table->foreign('installment_sale_id')->references('id')->on('installment_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraint first
        Schema::table('installment_payments', function (Blueprint $table) {
            $table->dropForeign(['installment_sale_id']);
        });

        // Use raw SQL to modify the column back to NOT NULL
        DB::statement('ALTER TABLE installment_payments MODIFY installment_sale_id BIGINT UNSIGNED NOT NULL');

        // Re-add the foreign key constraint
        Schema::table('installment_payments', function (Blueprint $table) {
            $table->foreign('installment_sale_id')->references('id')->on('installment_sales')->onDelete('cascade');
        });
    }
};
