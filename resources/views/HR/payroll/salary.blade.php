@extends('layouts.hr')

@section('title', 'Salary Management | Bluebelle Resort')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">💰 Salary Management</h1>
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-gray-600">View and manage employee salaries</p>
            </div>
            <a href="{{ route('hr.payroll.run') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-play"></i> Run Payroll
            </a>
        </div>

        <table class="w-full border-collapse bg-gray-50 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6">Employee</th>
                    <th class="py-3 px-6">Position</th>
                    <th class="py-3 px-6">Monthly Salary</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr class="border-b border-gray-200 bg-white hover:bg-gray-100 text-gray-700">
                        <td class="py-3 px-6">{{ $employee->name }}</td>
                        <td class="py-3 px-6">{{ $employee->position }}</td>
                        <td class="py-3 px-6">₱{{ number_format($employee->salary, 2) }}</td>
                        <td class="py-3 px-6">
                            @if($employee->status == 'active')
                                <span class="text-green-500 font-bold">Active</span>
                            @else
                                <span class="text-red-500 font-bold">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 px-6">
                            <a href="{{ route('hr.payroll.payslip', ['employee' => $employee->id]) }}" class="text-blue-500 hover:text-blue-700 mr-3">
                                <i class="fas fa-eye"></i> View Payslip
                            </a>
                            <a href="#" class="text-yellow-500 hover:text-yellow-700 mr-3"><i class="fas fa-edit"></i> Edit</a>
                            <a href="#" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $employees->links() }}
        </div>
    </div>
</div>
@endsection
