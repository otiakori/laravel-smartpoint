<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_default',
        'tenant_id'
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the tenant that owns the role.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the permissions for this role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * Get the users with this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Scope a query to only include roles for a specific tenant.
     */
    public function scopeForTenant($query, $tenantId = null)
    {
        $tenantId = $tenantId ?? auth()->user()->tenant_id ?? null;
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Check if the role has a specific permission.
     */
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            return $this->permissions()->where('name', $permission)->exists();
        }
        
        return $this->permissions()->where('id', $permission->id)->exists();
    }

    /**
     * Check if the role has any of the given permissions.
     */
    public function hasAnyPermission($permissions)
    {
        if (is_string($permissions)) {
            $permissions = [$permissions];
        }
        
        return $this->permissions()->whereIn('name', $permissions)->exists();
    }

    /**
     * Check if the role has all of the given permissions.
     */
    public function hasAllPermissions($permissions)
    {
        if (is_string($permissions)) {
            $permissions = [$permissions];
        }
        
        $rolePermissions = $this->permissions()->whereIn('name', $permissions)->pluck('name');
        return count(array_intersect($permissions, $rolePermissions->toArray())) === count($permissions);
    }

    /**
     * Get the default role for the current tenant.
     */
    public static function getDefault($tenantId = null)
    {
        $tenantId = $tenantId ?? auth()->user()->tenant_id ?? null;
        return static::where('is_default', true)->where('tenant_id', $tenantId)->first();
    }
}
