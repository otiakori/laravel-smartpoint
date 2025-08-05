@extends('layouts.dashboard')

@section('title', 'Supplier Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Supplier Management</h1>
        <p class="text-gray-600 mt-2">Manage your suppliers and vendor relationships</p>
    </div>

    @livewire('supplier-management')
</div>
@endsection 