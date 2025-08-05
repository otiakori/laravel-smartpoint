<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class TestRegistrationProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:registration-process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the registration process to ensure roles and permissions are created correctly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Registration Process...');
        
        // Get the latest tenant
        $tenant = Tenant::latest()->first();
        if (!$tenant) {
            $this->error('No tenants found!');
            return 1;
        }
        
        $this->info("Testing tenant: {$tenant->name} (ID: {$tenant->id})");
        
        // Check roles
        $roles = Role::where('tenant_id', $tenant->id)->get();
        $this->info("Roles found: {$roles->count()}");
        
        foreach ($roles as $role) {
            $this->info("- {$role->name}: {$role->permissions->count()} permissions");
        }
        
        // Check permissions
        $permissions = Permission::where('tenant_id', $tenant->id)->get();
        $this->info("Permissions found: {$permissions->count()}");
        
        // Check admin user
        $adminUser = User::where('tenant_id', $tenant->id)->whereHas('role', function($query) {
            $query->where('name', 'admin');
        })->first();
        
        if ($adminUser) {
            $this->info("Admin user found: {$adminUser->name} ({$adminUser->email})");
            $this->info("Admin permissions: {$adminUser->role->permissions->count()}");
            
            // Test some key permissions
            $testPermissions = ['view_users', 'create_roles', 'access_pos', 'view_dashboard'];
            foreach ($testPermissions as $permission) {
                $hasPermission = $adminUser->hasPermission($permission);
                $this->info("- Can {$permission}: " . ($hasPermission ? 'YES' : 'NO'));
            }
        } else {
            $this->error('No admin user found for this tenant!');
        }
        
        $this->info('Registration process test completed!');
        return 0;
    }
}
