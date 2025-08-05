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
        // Update permissions table - remove global unique constraint and add tenant-specific unique
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->unique(['tenant_id', 'name'], 'permissions_tenant_name_unique');
        });

        // Update roles table - remove global unique constraint and add tenant-specific unique
        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->unique(['tenant_id', 'name'], 'roles_tenant_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore global unique constraints
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropUnique('permissions_tenant_name_unique');
            $table->unique(['name']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropUnique('roles_tenant_name_unique');
            $table->unique(['name']);
        });
    }
};
