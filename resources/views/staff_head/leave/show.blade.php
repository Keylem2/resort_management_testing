@extends('layouts.staff_head')

@section('title', 'Leave Request Details | Blue Belle Resort')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Leave Request Details</h2>

    <div class="space-y-4">
        <p><strong>Employee:</strong> {{ $leaveRequest->employee->name }}</p>
        <p><strong>Start Date:</strong> {{ $leaveRequest->start_date->format('F d, Y') }}</p>
        <p><strong>End Date:</strong> {{ $leaveRequest->end_date->format('F d, Y') }}</p>
        <p><strong>Reason:</strong> {{ $leaveRequest->reason }}</p>
        <p><strong>Status:</strong> 
            @if($leaveRequest->status === 'approved')
                <span class="text-green-600 font-bold">Approved</span>
            @elseif($leaveRequest->status === 'rejected')
                <span class="text-red-600 font-bold">Rejected</span>
            @else
                <span class="text-yellow-600 font-bold">Pending</span>
            @endif
        </p>

        <div class="flex space-x-4">
            <form action="{{ route('staff_head.leave.approve', $leaveRequest->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800">Approve</button>
            </form>

            <form action="{{ route('staff_head.leave.reject', $leaveRequest->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 hover:text-red-800">Reject</button>
            </form>
        </div>

        <a href="{{ route('staff_head.leave.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Leave Requests</a>
    </div>
</div>
@endsection
