@extends('layouts.hr')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Attendance Details</h2>
    <div class="bg-white p-4 border rounded-lg">
        <p><strong>Employee ID:</strong> {{ $attendance->employee_id }}</p>
        <p><strong>Date:</strong> {{ $attendance->date }}</p>
        <p><strong>Check In:</strong> {{ $attendance->check_in }}</p>
        <p><strong>Check Out:</strong> {{ $attendance->check_out ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($attendance->status) }}</p>
    </div>
</div>
@endsection
