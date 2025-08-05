@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('roles.index') }}" class="text-smartpoint-red hover:text-red-700 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-smartpoint-dark">Edit Role</h1>
                <p class="text-gray-600 mt-2">Update role details and permissions</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('name') border-red-500 @enderror"
                               placeholder="e.g., supervisor">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="display_name" class="block text-sm font-medium text-gray-700 mb-2">Display Name</label>
                        <input type="text" name="display_name" id="display_name" value="{{ old('display_name', $role->display_name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('display_name') border-red-500 @enderror"
                               placeholder="e.g., Supervisor">
                        @error('display_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-8">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red @error('description') border-red-500 @enderror"
                              placeholder="Describe the role's responsibilities...">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Permissions</h3>
                    <p class="text-gray-600 mb-6">Select the permissions this role should have access to.</p>

                    <div class="space-y-6">
                        @foreach($permissions as $module => $modulePermissions)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $module) }}</h4>
                                <button type="button" class="text-sm text-smartpoint-red hover:text-red-700" 
                                        onclick="toggleModule('{{ $module }}')">
                                    Toggle All
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach($modulePermissions as $permission)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           class="h-4 w-4 text-smartpoint-red focus:ring-smartpoint-red border-gray-300 rounded"
                                           data-module="{{ $module }}"
                                           {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-700">{{ $permission->display_name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @error('permissions')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('roles.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-smartpoint-red text-white rounded-lg font-semibold hover:bg-red-700 transition-colors">
                        Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleModule(module) {
    const checkboxes = document.querySelectorAll(`input[data-module="${module}"]`);
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });
}
</script>
@endsection 