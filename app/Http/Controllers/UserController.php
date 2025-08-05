<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_users')->only(['index', 'show']);
        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:edit_users')->only(['edit', 'update']);
        $this->middleware('permission:delete_users')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('tenant_id', auth()->user()->tenant_id)->with('role', 'tenant')->get();
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::forTenant()->get();
        
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,tenant_id,' . auth()->user()->tenant_id,
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        // Ensure the role belongs to the current tenant
        $role = Role::find($request->role_id);
        if (!$role || $role->tenant_id !== auth()->user()->tenant_id) {
            return back()->withErrors(['role_id' => 'Invalid role selected.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'status' => $request->status,
            'tenant_id' => auth()->user()->tenant_id
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Ensure the user belongs to the current tenant
        if ($user->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to user.');
        }
        
        $user->load('role', 'tenant');
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Ensure the user belongs to the current tenant
        if ($user->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to user.');
        }
        
        $roles = Role::forTenant()->get();
        
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Ensure the user belongs to the current tenant
        if ($user->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to user.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where('tenant_id', auth()->user()->tenant_id)->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive'
        ]);

        // Ensure the role belongs to the current tenant
        $role = Role::find($request->role_id);
        if (!$role || $role->tenant_id !== auth()->user()->tenant_id) {
            return back()->withErrors(['role_id' => 'Invalid role selected.']);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'status' => $request->status
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Ensure the user belongs to the current tenant
        if ($user->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Unauthorized access to user.');
        }
        
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
