<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;

class AssignDefaultRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-default-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign default role to users who do not have a role assigned';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $defaultRole = Role::getDefault();
        
        if (!$defaultRole) {
            $this->error('No default role found. Please run the RolesAndPermissionsSeeder first.');
            return 1;
        }

        $usersWithoutRole = User::whereNull('role_id')->get();
        
        if ($usersWithoutRole->isEmpty()) {
            $this->info('All users already have roles assigned.');
            return 0;
        }

        $count = 0;
        foreach ($usersWithoutRole as $user) {
            $user->assignRole($defaultRole);
            $count++;
        }

        $this->info("Successfully assigned default role to {$count} users.");
        
        return 0;
    }
}
