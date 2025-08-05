<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'tenant_id'
    ];

    /**
     * Get the tenant that owns the permission.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the roles that have this permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    /**
     * Scope a query to only include permissions for a specific tenant.
     */
    public function scopeForTenant($query, $tenantId = null)
    {
        $tenantId = $tenantId ?? auth()->user()->tenant_id ?? null;
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Get permissions grouped by module for the current tenant.
     */
    public static function getByModule($tenantId = null)
    {
        $tenantId = $tenantId ?? auth()->user()->tenant_id ?? null;
        return static::where('tenant_id', $tenantId)->orderBy('module')->orderBy('display_name')->get()->groupBy('module');
    }

    /**
     * Get permissions for a specific module for the current tenant.
     */
    public static function getByModuleName($module, $tenantId = null)
    {
        $tenantId = $tenantId ?? auth()->user()->tenant_id ?? null;
        return static::where('module', $module)->where('tenant_id', $tenantId)->orderBy('display_name')->get();
    }
}
