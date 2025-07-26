<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Business - SmartPoint POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Register Your Business
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Start your 30-day free trial with SmartPoint POS
                </p>
            </div>
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Business Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Business Information</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                            <input type="text" name="business_name" id="business_name" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('business_name') }}">
                        </div>
                        <div>
                            <label for="business_email" class="block text-sm font-medium text-gray-700">Business Email</label>
                            <input type="email" name="business_email" id="business_email" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('business_email') }}">
                        </div>
                        <div>
                            <label for="business_phone" class="block text-sm font-medium text-gray-700">Business Phone</label>
                            <input type="text" name="business_phone" id="business_phone"
                                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('business_phone') }}">
                        </div>
                        <div class="sm:col-span-2">
                            <label for="business_address" class="block text-sm font-medium text-gray-700">Business Address</label>
                            <textarea name="business_address" id="business_address" rows="3"
                                      class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('business_address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Admin Information -->
                <div class="border-b border-gray-200 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Account</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="admin_name" class="block text-sm font-medium text-gray-700">Admin Name</label>
                            <input type="text" name="admin_name" id="admin_name" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('admin_name') }}">
                        </div>
                        <div>
                            <label for="admin_email" class="block text-sm font-medium text-gray-700">Admin Email</label>
                            <input type="email" name="admin_email" id="admin_email" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   value="{{ old('admin_email') }}">
                        </div>
                        <div>
                            <label for="admin_password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="admin_password" id="admin_password" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="admin_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="admin_password_confirmation" id="admin_password_confirmation" required
                                   class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500">
                        Already have an account? Sign in
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Register Business
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 