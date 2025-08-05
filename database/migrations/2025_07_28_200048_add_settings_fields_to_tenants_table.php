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
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('currency', 10)->default('USD')->after('address');
            $table->string('currency_symbol', 5)->default('$')->after('currency');
            $table->enum('theme', ['light', 'dark', 'auto'])->default('light')->after('currency_symbol');
            $table->string('timezone', 50)->default('UTC')->after('theme');
            $table->string('date_format', 20)->default('Y-m-d')->after('timezone');
            $table->enum('time_format', ['12', '24'])->default('24')->after('date_format');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'currency',
                'currency_symbol',
                'theme',
                'timezone',
                'date_format',
                'time_format'
            ]);
        });
    }
};
