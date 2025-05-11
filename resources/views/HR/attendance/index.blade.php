@extends('layouts.hr')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Attendance Records</h2>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 border">Employee ID</th>
                <th class="px-4 py-2 border">Date</th>
                <th class="px-4 py-2 border">Check In</th>
                <th class="px-4 py-2 border">Check Out</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td class="px-4 py-2 border">{{ $attendance->employee_id }}</td>
                <td class="px-4 py-2 border">{{ $attendance->date }}</td>
                <td class="px-4 py-2 border">{{ $attendance->check_in }}</td>
                <td class="px-4 py-2 border">{{ $attendance->check_out ?? 'N/A' }}</td>
                <td class="px-4 py-2 border">{{ ucfirst($attendance->status) }}</td>
                <td class="px-4 py-2 border">
                    <a href="{{ route('hr.attendance.show', $attendance->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $attendances->links() }}
    </div>
</div>
@endsection
