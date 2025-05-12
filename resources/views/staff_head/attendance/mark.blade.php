@extends('layouts.staff_head')

@section('title', 'Mark Attendance')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Mark Attendance</h2>
        
        <form method="POST" action="{{ route('staff_head.attendance.mark') }}">
            @csrf
            
            <div class="mb-4">
                <label for="employee_id" class="block text-gray-700">Employee</label>
                <select name="employee_id" id="employee_id" class="w-full p-2 border rounded">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->position }})</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date</label>
                <input type="date" name="date" id="date" class="w-full p-2 border rounded" 
                       value="{{ now()->format('Y-m-d') }}">
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="check_in" class="block text-gray-700">Check In</label>
                    <input type="time" name="check_in" id="check_in" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label for="check_out" class="block text-gray-700">Check Out</label>
                    <input type="time" name="check_out" id="check_out" class="w-full p-2 border rounded">
                </div>
            </div>
            
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="late" class="rounded border-gray-300 text-blue-600 shadow-sm">
                    <span class="ml-2">Mark as Late</span>
                </label>
            </div>
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Submit Attendance
            </button>
        </form>
    </div>
</div>
@endsection