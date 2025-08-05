<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\Role;
use App\Models\Permission;

class CreateTenantRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create-roles-permissions {tenant_id? : The ID of the tenant to create roles for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create roles and permissions for a specific tenant or all tenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        
        if ($tenantId) {
            $tenant = Tenant::find($tenantId);
            if (!$tenant) {
                $this->error("Tenant with ID {$tenantId} not found.");
                return 1;
            }
            $this->createForTenant($tenant);
        } else {
            $tenants = Tenant::all();
            $this->info("Creating roles and permissions for {$tenants->count()} tenants...");
            
            foreach ($tenants as $tenant) {
                $this->createForTenant($tenant);
            }
        }
        
        $this->info('Roles and permissions created successfully!');
        return 0;
    }

    /**
     * Create roles and permissions for a specific tenant.
     */
    private function createForTenant($tenant)
    {
        $this->info("Creating roles and permissions for tenant: {$tenant->name} (ID: {$tenant->id})");
        
        // Check if roles already exist for this tenant
        if (Role::where('tenant_id', $tenant->id)->exists()) {
            $this->warn("Roles already exist for tenant {$tenant->name}. Skipping...");
            return;
        }

        $permissions = [
            // Dashboard
            ['name' => 'view_dashboard', 'display_name' => 'View Dashboard', 'module' => 'dashboard'],
            
            // POS
            ['name' => 'access_pos', 'display_name' => 'Access POS', 'module' => 'pos'],
            ['name' => 'process_sales', 'display_name' => 'Process Sales', 'module' => 'pos'],
            ['name' => 'void_transactions', 'display_name' => 'Void Transactions', 'module' => 'pos'],
            
            // Products
            ['name' => 'view_products', 'display_name' => 'View Products', 'module' => 'products'],
            ['name' => 'create_products', 'display_name' => 'Create Products', 'module' => 'products'],
            ['name' => 'edit_products', 'display_name' => 'Edit Products', 'module' => 'products'],
            ['name' => 'delete_products', 'display_name' => 'Delete Products', 'module' => 'products'],
            
            // Customers
            ['name' => 'view_customers', 'display_name' => 'View Customers', 'module' => 'customers'],
            ['name' => 'create_customers', 'display_name' => 'Create Customers', 'module' => 'customers'],
            ['name' => 'edit_customers', 'display_name' => 'Edit Customers', 'module' => 'customers'],
            ['name' => 'delete_customers', 'display_name' => 'Delete Customers', 'module' => 'customers'],
            
            // Sales
            ['name' => 'view_sales', 'display_name' => 'View Sales', 'module' => 'sales'],
            ['name' => 'create_sales', 'display_name' => 'Create Sales', 'module' => 'sales'],
            ['name' => 'edit_sales', 'display_name' => 'Edit Sales', 'module' => 'sales'],
            ['name' => 'delete_sales', 'display_name' => 'Delete Sales', 'module' => 'sales'],
            
            // Invoices
            ['name' => 'view_invoices', 'display_name' => 'View Invoices', 'module' => 'invoices'],
            ['name' => 'create_invoices', 'display_name' => 'Create Invoices', 'module' => 'invoices'],
            ['name' => 'edit_invoices', 'display_name' => 'Edit Invoices', 'module' => 'invoices'],
            ['name' => 'delete_invoices', 'display_name' => 'Delete Invoices', 'module' => 'invoices'],
            
            // Installment Plans
            ['name' => 'view_installment_plans', 'display_name' => 'View Installment Plans', 'module' => 'installment_plans'],
            ['name' => 'create_installment_plans', 'display_name' => 'Create Installment Plans', 'module' => 'installment_plans'],
            ['name' => 'edit_installment_plans', 'display_name' => 'Edit Installment Plans', 'module' => 'installment_plans'],
            ['name' => 'delete_installment_plans', 'display_name' => 'Delete Installment Plans', 'module' => 'installment_plans'],
            
            // Inventory
            ['name' => 'view_inventory', 'display_name' => 'View Inventory', 'module' => 'inventory'],
            ['name' => 'adjust_inventory', 'display_name' => 'Adjust Inventory', 'module' => 'inventory'],
            ['name' => 'restock_inventory', 'display_name' => 'Restock Inventory', 'module' => 'inventory'],
            
            // Reports
            ['name' => 'view_reports', 'display_name' => 'View Reports', 'module' => 'reports'],
            ['name' => 'export_reports', 'display_name' => 'Export Reports', 'module' => 'reports'],
            
            // Settings
            ['name' => 'view_settings', 'display_name' => 'View Settings', 'module' => 'settings'],
            ['name' => 'edit_settings', 'display_name' => 'Edit Settings', 'module' => 'settings'],
            
            // User Management
            ['name' => 'view_users', 'display_name' => 'View Users', 'module' => 'users'],
            ['name' => 'create_users', 'display_name' => 'Create Users', 'module' => 'users'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'module' => 'users'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'module' => 'users'],
            
            // Role Management
            ['name' => 'view_roles', 'display_name' => 'View Roles', 'module' => 'roles'],
            ['name' => 'create_roles', 'display_name' => 'Create Roles', 'module' => 'roles'],
            ['name' => 'edit_roles', 'display_name' => 'Edit Roles', 'module' => 'roles'],
            ['name' => 'delete_roles', 'display_name' => 'Delete Roles', 'module' => 'roles'],
            
            // AI Chat
            ['name' => 'access_ai_chat', 'display_name' => 'Access AI Chat', 'module' => 'ai_chat'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
                'description' => $permission['description'] ?? null,
                'module' => $permission['module'],
                'tenant_id' => $tenant->id
            ]);
        }

        $this->info("Created " . count($permissions) . " permissions for tenant {$tenant->name}");

        // Create roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full access to all features and settings',
                'is_default' => false,
                'permissions' => Permission::where('tenant_id', $tenant->id)->pluck('name')->toArray()
            ],
            [
                'name' => 'manager',
                'display_name' => 'Manager',
                'description' => 'Can manage sales, inventory, and basic settings',
                'is_default' => false,
                'permissions' => [
                    'view_dashboard', 'access_pos', 'process_sales', 'void_transactions',
                    'view_products', 'create_products', 'edit_products',
                    'view_customers', 'create_customers', 'edit_customers',
                    'view_sales', 'create_sales', 'edit_sales',
                    'view_invoices', 'create_invoices', 'edit_invoices',
                    'view_installment_plans', 'create_installment_plans', 'edit_installment_plans',
                    'view_inventory', 'adjust_inventory', 'restock_inventory',
                    'view_reports', 'export_reports',
                    'view_settings', 'edit_settings',
                    'access_ai_chat'
                ]
            ],
            [
                'name' => 'cashier',
                'display_name' => 'Cashier',
                'description' => 'Can process sales and view basic information',
                'is_default' => true,
                'permissions' => [
                    'view_dashboard', 'access_pos', 'process_sales',
                    'view_products', 'view_customers', 'view_sales',
                    'view_invoices', 'access_ai_chat'
                ]
            ]
        ];

        foreach ($roles as $roleData) {
            $permissions = $roleData['permissions'];
            unset($roleData['permissions']);
            
            $role = Role::create([
                'name' => $roleData['name'],
                'display_name' => $roleData['display_name'],
                'description' => $roleData['description'],
                'is_default' => $roleData['is_default'],
                'tenant_id' => $tenant->id
            ]);
            
            // Attach permissions for this tenant
            $role->permissions()->attach(
                Permission::where('tenant_id', $tenant->id)
                    ->whereIn('name', $permissions)
                    ->pluck('id')
            );
        }

        $this->info("Created " . count($roles) . " roles for tenant {$tenant->name}");
    }
}
