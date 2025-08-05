<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Tenant;

class AddSupplierPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:add-supplier';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add supplier permissions to existing roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding supplier permissions to existing roles...');

        // Get all tenants
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $this->info("Processing tenant: {$tenant->name}");

            // Create supplier permissions for this tenant
            $supplierPermissions = [
                'view_suppliers',
                'create_suppliers', 
                'edit_suppliers',
                'delete_suppliers',
                'view_purchase_orders',
                'create_purchase_orders',
                'edit_purchase_orders', 
                'delete_purchase_orders',
                'view_supplier_payments',
                'create_supplier_payments',
                'edit_supplier_payments',
                'delete_supplier_payments'
            ];

            foreach ($supplierPermissions as $permissionName) {
                $permission = Permission::firstOrCreate([
                    'name' => $permissionName,
                    'tenant_id' => $tenant->id
                ], [
                    'display_name' => ucwords(str_replace('_', ' ', $permissionName)),
                    'module' => explode('_', $permissionName)[1] . 's'
                ]);
            }

            // Get admin role for this tenant
            $adminRole = Role::where('name', 'admin')->where('tenant_id', $tenant->id)->first();
            
            if ($adminRole) {
                // Get all supplier permissions for this tenant
                $supplierPermissionIds = Permission::where('tenant_id', $tenant->id)
                    ->whereIn('name', $supplierPermissions)
                    ->pluck('id');

                // Attach supplier permissions to admin role
                $adminRole->permissions()->attach($supplierPermissionIds);
                $this->info("Added supplier permissions to admin role for tenant: {$tenant->name}");
            }

            // Get manager role for this tenant
            $managerRole = Role::where('name', 'manager')->where('tenant_id', $tenant->id)->first();
            
            if ($managerRole) {
                // Get basic supplier permissions for manager
                $managerSupplierPermissions = [
                    'view_suppliers',
                    'create_suppliers',
                    'edit_suppliers',
                    'view_purchase_orders',
                    'create_purchase_orders',
                    'edit_purchase_orders',
                    'view_supplier_payments',
                    'create_supplier_payments'
                ];

                $managerPermissionIds = Permission::where('tenant_id', $tenant->id)
                    ->whereIn('name', $managerSupplierPermissions)
                    ->pluck('id');

                // Attach supplier permissions to manager role
                $managerRole->permissions()->attach($managerPermissionIds);
                $this->info("Added supplier permissions to manager role for tenant: {$tenant->name}");
            }
        }

        $this->info('Supplier permissions added successfully!');
    }
}
