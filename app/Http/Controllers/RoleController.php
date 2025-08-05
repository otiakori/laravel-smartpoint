<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_roles')->only(['index', 'show']);
        $this->middleware('permission:create_roles')->only(['create', 'store']);
        $this->middleware('permission:edit_roles')->only(['edit', 'update']);
        $this->middleware('permission:delete_roles')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::forTenant()->with('permissions')->get();
        
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::getByModule();
        
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,NULL,id,tenant_id,' . auth()->user()->tenant_id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'is_default' => false,
            'tenant_id' => auth()->user()->tenant_id
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // Ensure the role belongs to the current tenant
        if ($role->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to role.');
        }
        
        $role->load('permissions', 'users');
        
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Ensure the role belongs to the current tenant
        if ($role->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to role.');
        }
        
        $permissions = Permission::getByModule();
        $role->load('permissions');
        
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Ensure the role belongs to the current tenant
        if ($role->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to role.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->where('tenant_id', auth()->user()->tenant_id)->ignore($role->id)],
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Ensure the role belongs to the current tenant
        if ($role->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to role.');
        }
        
        // Prevent deletion of default role
        if ($role->is_default) {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot delete the default role.');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot delete role that has assigned users.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
