@extends('layouts.staff_head')

@section('title', 'Team Member Details | Blue Belle Resort')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">👤 Team Member Details</h2>

    <div class="space-y-4">
        <p><strong>Name:</strong> {{ $employee->name }}</p>
        <p><strong>Position:</strong> {{ $employee->position }}</p>
        <p><strong>Contact:</strong> {{ $employee->phone }}</p>
        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Hire Date:</strong> {{ $employee->hire_date->format('F d, Y') }}</p>
        <p><strong>Status:</strong> 
            @if($employee->status === 'active')
                <span class="text-green-600 font-bold">Active</span>
            @else
                <span class="text-red-600 font-bold">Inactive</span>
            @endif
        </p>

        <a href="{{ route('staff_head.team.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Team</a>
    </div>
</div>
@endsection
