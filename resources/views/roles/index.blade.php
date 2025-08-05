@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-smartpoint-dark">Role Management</h1>
            <p class="text-gray-600 mt-2">Manage user roles and their permissions</p>
        </div>
        @can('create_roles')
        <a href="{{ route('roles.create') }}" class="bg-smartpoint-red text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create New Role
        </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Desktop View -->
    <div class="hidden lg:block">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($roles as $role)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-smartpoint-red rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-semibold">{{ substr($role->display_name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $role->display_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $role->name }}</div>
                                        @if($role->is_default)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Default
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $role->description ?? 'No description' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $role->permissions->count() }} permissions
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    @foreach($role->permissions->take(3) as $permission)
                                        <span class="inline-block bg-gray-100 rounded px-2 py-1 mr-1 mb-1">{{ $permission->display_name }}</span>
                                    @endforeach
                                    @if($role->permissions->count() > 3)
                                        <span class="text-gray-400">+{{ $role->permissions->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $role->users->count() }} users</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    @can('view_roles')
                                    <a href="{{ route('roles.show', $role) }}" class="text-smartpoint-red hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    @endcan
                                    @can('edit_roles')
                                    <a href="{{ route('roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    @endcan
                                    @can('delete_roles')
                                    @if(!$role->is_default && $role->users->count() == 0)
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="lg:hidden space-y-4">
        @foreach($roles as $role)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-smartpoint-red rounded-full flex items-center justify-center mr-3">
                        <span class="text-white text-sm font-semibold">{{ substr($role->display_name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $role->display_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $role->name }}</p>
                        @if($role->is_default)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                Default
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    @can('view_roles')
                    <a href="{{ route('roles.show', $role) }}" class="text-smartpoint-red hover:text-red-700 p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </a>
                    @endcan
                    @can('edit_roles')
                    <a href="{{ route('roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900 p-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    @endcan
                </div>
            </div>
            
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">{{ $role->description ?? 'No description' }}</p>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">{{ $role->permissions->count() }} permissions</span>
                    <span class="text-gray-600">{{ $role->users->count() }} users</span>
                </div>
                
                <div class="flex flex-wrap gap-1">
                    @foreach($role->permissions->take(4) as $permission)
                        <span class="inline-block bg-gray-100 rounded px-2 py-1 text-xs">{{ $permission->display_name }}</span>
                    @endforeach
                    @if($role->permissions->count() > 4)
                        <span class="text-gray-400 text-xs">+{{ $role->permissions->count() - 4 }} more</span>
                    @endif
                </div>
                
                @can('delete_roles')
                @if(!$role->is_default && $role->users->count() == 0)
                <div class="pt-3 border-t">
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                            Delete Role
                        </button>
                    </form>
                </div>
                @endif
                @endcan
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection 