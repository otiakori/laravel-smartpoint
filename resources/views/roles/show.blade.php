@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('roles.index') }}" class="text-smartpoint-red hover:text-red-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-smartpoint-dark">{{ $role->display_name }}</h1>
                    <p class="text-gray-600 mt-2">Role Details</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @can('edit_roles')
                <a href="{{ route('roles.edit', $role) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Role
                </a>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Role Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-smartpoint-red rounded-full flex items-center justify-center mr-4">
                            <span class="text-white text-xl font-semibold">{{ substr($role->display_name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $role->display_name }}</h2>
                            <p class="text-gray-500">{{ $role->name }}</p>
                            @if($role->is_default)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                    Default Role
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Description</h3>
                            <p class="text-gray-900 mt-1">{{ $role->description ?? 'No description provided' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Statistics</h3>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-2xl font-bold text-smartpoint-red">{{ $role->permissions->count() }}</div>
                                    <div class="text-sm text-gray-600">Permissions</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="text-2xl font-bold text-smartpoint-red">{{ $role->users->count() }}</div>
                                    <div class="text-sm text-gray-600">Users</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Created</h3>
                            <p class="text-gray-900 mt-1">{{ $role->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Permissions</h3>
                    
                    @if($role->permissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($role->permissions->groupBy('module') as $module => $permissions)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h4 class="text-md font-medium text-gray-900 capitalize mb-3">{{ str_replace('_', ' ', $module) }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($permissions as $permission)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm text-gray-700">{{ $permission->display_name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <p class="text-gray-500">No permissions assigned to this role.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Assigned Users -->
        @if($role->users->count() > 0)
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Assigned Users ({{ $role->users->count() }})</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($role->users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-smartpoint-red rounded-full flex items-center justify-center">
                                                <span class="text-white text-sm font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection 