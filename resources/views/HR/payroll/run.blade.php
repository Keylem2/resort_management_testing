@extends('layouts.hr')

@section('title', 'Run Payroll')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Run Payroll</h2>

    <form action="{{ route('hr.payroll.process') }}" method="POST">
        @csrf
        <div class="space-y-4">
            @foreach($employees as $employee)
                <div class="flex items-center">
                    <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}" class="mr-3">
                    <span>{{ $employee->name }} - {{ $employee->position }}</span>
                </div>
            @endforeach
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg mt-4">Process Payroll</button>
    </form>
</div>
@endsection
