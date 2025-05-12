@extends('layouts.staff_head')

@section('title', 'Leave Approvals | Blue Belle Resort')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📅 Leave Approvals</h2>

    @if($leaveRequests->isEmpty())
        <p class="text-gray-500">No leave requests found.</p>
    @else
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-100 border-b">Employee</th>
                    <th class="py-2 px-4 bg-gray-100 border-b">Start Date</th>
                    <th class="py-2 px-4 bg-gray-100 border-b">End Date</th>
                    <th class="py-2 px-4 bg-gray-100 border-b">Status</th>
                    <th class="py-2 px-4 bg-gray-100 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaveRequests as $leave)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $leave->employee->name }}</td>
                        <td class="py-2 px-4">{{ $leave->start_date->format('F d, Y') }}</td>
                        <td class="py-2 px-4">{{ $leave->end_date->format('F d, Y') }}</td>
                        <td class="py-2 px-4">
                            @if($leave->status === 'approved')
                                <span class="text-green-600 font-bold">Approved</span>
                            @elseif($leave->status === 'rejected')
                                <span class="text-red-600 font-bold">Rejected</span>
                            @else
                                <span class="text-yellow-600 font-bold">Pending</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            <a href="{{ route('staff_head.leave.show', $leave->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
