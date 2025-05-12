@extends('layouts.staff_head')

@section('title', 'Mark Attendance | Bluebelle Resort')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">📝 Mark Attendance</h1>

        <form method="POST" action="{{ route('staff_head.attendance.mark') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Employee</label>
                <select name="employee_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    @foreach ($teamMembers as $member)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Mark as Late</label>
                <input type="checkbox" name="late" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Mark Attendance
            </button>
        </form>
    </div>
</div>
@endsection
