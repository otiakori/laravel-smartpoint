<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->decimal('tax_rate', 5, 2)->default(0)->after('currency_symbol');
            $table->boolean('tax_enabled')->default(false)->after('tax_rate');
            $table->string('tax_name')->default('Tax')->after('tax_enabled');
            $table->boolean('tax_inclusive')->default(false)->after('tax_name');
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['tax_rate', 'tax_enabled', 'tax_name', 'tax_inclusive']);
        });
    }
}; 