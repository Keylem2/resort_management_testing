@extends('layouts.hr')

@section('title', 'Create Leave Request')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Create Leave Request</h2>

    <form action="{{ route('hr.leave.store') }}" method="POST">
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
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full p-2 border rounded-lg" required>
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" class="w-full p-2 border rounded-lg" required>
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                <textarea id="reason" name="reason" rows="4" class="w-full p-2 border rounded-lg" required></textarea>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status" name="status" class="w-full p-2 border rounded-lg">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Save Leave Request</button>
        </div>
    </form>
</div>
@endsection
