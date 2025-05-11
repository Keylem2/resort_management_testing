@extends('layouts.admin')

@section('title', 'Staff Details')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Staff Details</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.staff.edit', $staff) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Edit
            </a>
            <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">
                Back to Staff
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Personal Information -->
            <div class="md:col-span-1">
                <div class="flex flex-col items-center">
                    <div class="h-24 w-24 bg-amber-100 rounded-full flex items-center justify-center text-amber-600 text-3xl font-bold mb-4">
                        {{ substr($staff->first_name, 0, 1) }}{{ substr($staff->last_name, 0, 1) }}
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $staff->full_name }}</h2>
                    <p class="text-gray-600">{{ $staff->position }}</p>
                    
                    @php
                        $statusClasses = [
                            'active' => 'bg-green-100 text-green-800',
                            'on_leave' => 'bg-yellow-100 text-yellow-800',
                            'terminated' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="mt-2 px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses[$staff->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst(str_replace('_', ' ', $staff->status)) }}
                    </span>
                </div>
                
                <div class="mt-6 space-y-3">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Email</h3>
                        <p class="text-gray-900">{{ $staff->email }}</p>
                    </div>
                    
                    @if($staff->phone)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                        <p class="text-gray-900">{{ $staff->phone }}</p>
                    </div>
                    @endif
                    
                    @if($staff->date_of_birth)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Date of Birth</h3>
                        <p class="text-gray-900">{{ $staff->date_of_birth->format('M d, Y') }}</p>
                    </div>
                    @endif
                    
                    @if($staff->address)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Address</h3>
                        <p class="text-gray-900 whitespace-pre-line">{{ $staff->address }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Employment Details -->
            <div class="md:col-span-2 space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Employment Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Position</h4>
                            <p class="text-gray-900">{{ $staff->position }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Hire Date</h4>
                            <p class="text-gray-900">{{ $staff->hire_date->format('M d, Y') }}</p>
                        </div>
                        
                        @if($staff->salary)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Salary</h4>
                            <p class="text-gray-900">₱{{ number_format($staff->salary, 2) }}</p>
                        </div>
                        @endif
                        
                        @if($staff->user)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">User Account</h4>
                            <p class="text-gray-900">Active ({{ $staff->user->role }})</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Emergency Contact -->
                @if($staff->emergency_contact_name || $staff->emergency_contact_phone)
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Emergency Contact</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($staff->emergency_contact_name)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Name</h4>
                            <p class="text-gray-900">{{ $staff->emergency_contact_name }}</p>
                        </div>
                        @endif
                        
                        @if($staff->emergency_contact_phone)
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Phone</h4>
                            <p class="text-gray-900">{{ $staff->emergency_contact_phone }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Notes -->
                @if($staff->notes)
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Notes</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">{{ $staff->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection