@extends('layouts.dashboard')

@section('title', 'Chat Test')

@section('page-content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">SmartPoint AI Chat Test</h1>
        <p class="text-gray-600 mb-6">This page is for testing the Gemini AI chat integration. The chat widget should appear in the bottom right corner.</p>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <h2 class="font-semibold text-gray-900 mb-2">Test Instructions:</h2>
            <ul class="list-disc list-inside text-gray-600 space-y-1">
                <li>Look for the chat button in the bottom right corner</li>
                <li>Click it to open the chat interface</li>
                <li>Try asking questions about the POS system</li>
                <li>Test different types of queries</li>
            </ul>
        </div>
    </div>
</div>
@endsection 