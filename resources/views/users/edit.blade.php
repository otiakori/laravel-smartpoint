@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('users.index') }}" class="text-smartpoint-red hover:text-red-700 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-smartpoint-dark">Edit User</h1>
                <p class="text-gray-600 mt-2">Update user information and role</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('name') border-red-500 @enderror"
                               placeholder="Enter full name">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('email') border-red-500 @enderror"
                               placeholder="Enter email address">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password (Optional)</label>
                        <input type="password" name="password" id="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('password') border-red-500 @enderror"
                               placeholder="Leave blank to keep current password">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red"
                               placeholder="Confirm new password">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role_id" id="role_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('role_id') border-red-500 @enderror">
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->display_name }} - {{ $role->description }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" id="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('status') border-red-500 @enderror">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Optional)</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('phone') border-red-500 @enderror"
                           placeholder="Enter phone number">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('users.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-smartpoint-red text-white rounded-lg font-semibold hover:bg-red-700 transition-colors">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 