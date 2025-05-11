@extends('layouts.hr')

@section('title', 'Employee Payslip')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Payslip for {{ $employee->name }}</h1>
    
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h2 class="text-lg font-semibold">Employee Details</h2>
                <p><strong>Name:</strong> {{ $employee->name }}</p>
                <p><strong>Position:</strong> {{ $employee->position }}</p>
                <p><strong>Employee ID:</strong> {{ $employee->id }}</p>
                <p><strong>Monthly Salary:</strong> ₱{{ number_format($employee->salary, 2) }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold">Payment Details</h2>
                <p><strong>Processed Date:</strong> {{ now()->format('F d, Y') }}</p>
                <p><strong>Status:</strong> <span class="text-green-500 font-bold">Processed</span></p>
            </div>
        </div>
    </div>
    
    <a href="#" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
        <i class="fas fa-print"></i> Print Payslip
    </a>
</div>
@endsection
