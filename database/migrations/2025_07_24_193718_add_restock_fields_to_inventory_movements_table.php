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
        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->string('supplier')->nullable()->after('notes');
            $table->decimal('cost_per_unit', 10, 2)->nullable()->after('supplier');
            $table->string('reason')->nullable()->after('cost_per_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_movements', function (Blueprint $table) {
            $table->dropColumn(['supplier', 'cost_per_unit', 'reason']);
        });
    }
};
