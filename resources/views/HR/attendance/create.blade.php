@extends('layouts.hr')

@section('title', 'Record Attendance')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Record Attendance</h2>

    <form action="{{ route('hr.attendance.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee</label>
                <select id="employee_id" name="employee_id" class="w-full p-2 border rounded-lg">
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" id="date" name="date" class="w-full p-2 border rounded-lg" required>
            </div>

            <div>
                <label for="check_in" class="block text-sm font-medium text-gray-700">Check In</label>
                <input type="time" id="check_in" name="check_in" class="w-full p-2 border rounded-lg" required>
            </div>

            <div>
                <label for="check_out" class="block text-sm font-medium text-gray-700">Check Out (optional)</label>
                <input type="time" id="check_out" name="check_out" class="w-full p-2 border rounded-lg">
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="w-full p-2 border rounded-lg">
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="late">Late</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Save Attendance</button>
        </div>
    </form>
</div>
@endsection
