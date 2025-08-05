@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('users.index') }}" class="text-smartpoint-red hover:text-red-700 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-smartpoint-dark">{{ $user->name }}</h1>
                    <p class="text-gray-600 mt-2">User Details</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @can('edit_users')
                <a href="{{ route('users.edit', $user) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit User
                </a>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-smartpoint-red rounded-full flex items-center justify-center mr-4">
                            <span class="text-white text-xl font-semibold">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-gray-500">{{ $user->email }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} mt-1">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Contact Information</h3>
                            <div class="mt-2 space-y-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-900">{{ $user->email }}</span>
                                </div>
                                @if($user->phone)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-900">{{ $user->phone }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Role Information</h3>
                            <div class="mt-2">
                                @if($user->role)
                                    <div class="bg-blue-50 rounded-lg p-3">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-blue-900">{{ $user->role->display_name }}</span>
                                            <span class="text-xs text-blue-600">{{ $user->role->name }}</span>
                                        </div>
                                        @if($user->role->description)
                                            <p class="text-xs text-blue-700 mt-1">{{ $user->role->description }}</p>
                                        @endif
                                    </div>
                                @else
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <span class="text-sm text-gray-500">No role assigned</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Account Information</h3>
                            <div class="mt-2 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Member since:</span>
                                    <span class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Last login:</span>
                                    <span class="text-sm text-gray-900">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Permissions</h3>
                    
                    @if($user->role && $user->role->permissions->count() > 0)
                        <div class="space-y-4">
                            @foreach($user->role->permissions->groupBy('module') as $module => $permissions)
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
                            <p class="text-gray-500">No permissions assigned to this user.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity (if any) -->
        @if($user->sales->count() > 0)
        <div class="mt-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Sales Activity</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sale ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($user->sales->take(5) as $sale)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $sale->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $sale->customer->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ formatCurrency($sale->total_amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $sale->created_at->format('M d, Y g:i A') }}
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