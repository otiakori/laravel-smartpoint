<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SmartPoint - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'smartpoint-red': '#DC2626',
                        'smartpoint-dark': '#1F2937'
                    }
                }
            }
        }
    </script>
    <style>
        [type='text'], [type='email'], [type='url'], [type='password'], [type='number'], [type='date'], [type='datetime-local'], [type='month'], [type='search'], [type='tel'], [type='time'], [type='week'], [multiple], textarea, select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #fff;
            border-color: #d1d5db;
            border-width: 1px;
            border-radius: 0.375rem;
            padding-top: 0.5rem;
            padding-right: 0.75rem;
            padding-bottom: 0.5rem;
            padding-left: 0.75rem;
            font-size: 1rem;
            line-height: 1.5rem;
            --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        }
    </style>
</head>
<body class="bg-gray-50">
    @yield('content')
    @livewireScripts
</body>
</html> 