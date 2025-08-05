<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'role_id',
        'phone',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function installmentSales(): HasMany
    {
        return $this->hasMany(InstallmentSale::class);
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission($permission): bool
    {
        // Handle legacy string-based role system
        if (is_string($this->role) && !$this->role_id) {
            return $this->hasLegacyPermission($permission);
        }
        
        if (!$this->role) {
            return false;
        }
        
        return $this->role->hasPermission($permission);
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission($permissions): bool
    {
        // Handle legacy string-based role system
        if (is_string($this->role) && !$this->role_id) {
            return $this->hasLegacyAnyPermission($permissions);
        }
        
        if (!$this->role) {
            return false;
        }
        
        return $this->role->hasAnyPermission($permissions);
    }

    /**
     * Check if user has all of the given permissions.
     */
    public function hasAllPermissions($permissions): bool
    {
        // Handle legacy string-based role system
        if (is_string($this->role) && !$this->role_id) {
            return $this->hasLegacyAllPermissions($permissions);
        }
        
        if (!$this->role) {
            return false;
        }
        
        return $this->role->hasAllPermissions($permissions);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role): bool
    {
        // Handle legacy string-based role system
        if (is_string($this->role) && !$this->role_id) {
            return $this->role === $role;
        }
        
        if (!$this->role) {
            return false;
        }
        
        if (is_string($role)) {
            return $this->role->name === $role;
        }
        
        return $this->role->id === $role->id;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole($roles): bool
    {
        // Handle legacy string-based role system
        if (is_string($this->role) && !$this->role_id) {
            if (is_string($roles)) {
                $roles = [$roles];
            }
            return in_array($this->role, $roles);
        }
        
        if (!$this->role) {
            return false;
        }
        
        if (is_string($roles)) {
            $roles = [$roles];
        }
        
        return in_array($this->role->name, $roles);
    }

    // Legacy permission methods for backward compatibility
    private function hasLegacyPermission($permission): bool
    {
        $legacyPermissions = [
            'admin' => [
                'view_dashboard', 'access_pos', 'process_sales', 'void_transactions',
                'view_products', 'create_products', 'edit_products', 'delete_products',
                'view_customers', 'create_customers', 'edit_customers', 'delete_customers',
                'view_sales', 'create_sales', 'edit_sales', 'delete_sales',
                'view_invoices', 'create_invoices', 'edit_invoices', 'delete_invoices',
                'view_installment_plans', 'create_installment_plans', 'edit_installment_plans', 'delete_installment_plans',
                'view_inventory', 'adjust_inventory', 'restock_inventory',
                'view_reports', 'export_reports', 'view_settings', 'edit_settings',
                'view_users', 'create_users', 'edit_users', 'delete_users',
                'view_roles', 'create_roles', 'edit_roles', 'delete_roles',
                'access_ai_chat'
            ],
            'manager' => [
                'view_dashboard', 'access_pos', 'process_sales', 'void_transactions',
                'view_products', 'create_products', 'edit_products',
                'view_customers', 'create_customers', 'edit_customers',
                'view_sales', 'create_sales', 'edit_sales',
                'view_invoices', 'create_invoices', 'edit_invoices',
                'view_installment_plans', 'create_installment_plans', 'edit_installment_plans',
                'view_inventory', 'adjust_inventory', 'restock_inventory',
                'view_reports', 'export_reports', 'view_settings', 'edit_settings',
                'access_ai_chat'
            ],
            'cashier' => [
                'view_dashboard', 'access_pos', 'process_sales',
                'view_products', 'view_customers', 'view_sales',
                'view_invoices', 'access_ai_chat'
            ]
        ];

        return in_array($permission, $legacyPermissions[$this->role] ?? []);
    }

    private function hasLegacyAnyPermission($permissions): bool
    {
        if (is_string($permissions)) {
            $permissions = [$permissions];
        }

        foreach ($permissions as $permission) {
            if ($this->hasLegacyPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    private function hasLegacyAllPermissions($permissions): bool
    {
        if (is_string($permissions)) {
            $permissions = [$permissions];
        }

        foreach ($permissions as $permission) {
            if (!$this->hasLegacyPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    // Legacy methods for backward compatibility
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isCashier(): bool
    {
        return $this->hasRole('cashier');
    }

    public function canManageUsers(): bool
    {
        return $this->hasAnyPermission(['view_users', 'create_users', 'edit_users', 'delete_users']);
    }

    public function canManageInventory(): bool
    {
        return $this->hasAnyPermission(['view_inventory', 'adjust_inventory', 'restock_inventory']);
    }

    public function canViewReports(): bool
    {
        return $this->hasPermission('view_reports');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get user's permissions.
     */
    public function getPermissions()
    {
        if (!$this->role) {
            return collect();
        }
        
        return $this->role->permissions;
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        
        if ($role) {
            $this->role()->associate($role);
            $this->save();
        }
        
        return $this;
    }

    /**
     * Remove role from user.
     */
    public function removeRole()
    {
        $this->role()->dissociate();
        $this->save();
        
        return $this;
    }
}
