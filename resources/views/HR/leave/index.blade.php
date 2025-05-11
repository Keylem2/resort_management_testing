@extends('layouts.hr')

@section('title', 'Leave Management | Bluebelle Resort')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">📝 Leave Requests</h1>

        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-gray-600">Manage all employee leave requests</p>
            </div>
            <a href="{{ route('hr.leave.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus"></i> Create Leave Request
            </a>
        </div>

        <table class="w-full border-collapse bg-gray-50 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6">Employee</th>
                    <th class="py-3 px-6">Start Date</th>
                    <th class="py-3 px-6">End Date</th>
                    <th class="py-3 px-6">Reason</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaveRequests as $leave)
                    <tr class="border-b border-gray-200 bg-white hover:bg-gray-100 text-gray-700">
                        <td class="py-3 px-6">{{ $leave->employee->name }}</td>
                        <td class="py-3 px-6">{{ \Carbon\Carbon::parse($leave->start_date)->format('Y-m-d') }}</td>
                        <td class="py-3 px-6">{{ \Carbon\Carbon::parse($leave->end_date)->format('Y-m-d') }}</td>
                        <td class="py-3 px-6">{{ $leave->reason }}</td>
                        <td class="py-3 px-6">
                            @if($leave->status == 'approved')
                                <span class="text-green-500 font-bold">Approved</span>
                            @elseif($leave->status == 'rejected')
                                <span class="text-red-500 font-bold">Rejected</span>
                            @else
                                <span class="text-yellow-500 font-bold">Pending</span>
                            @endif
                        </td>
                        <td class="py-3 px-6">
                            <a href="#" class="text-blue-500 hover:text-blue-700 mr-3"><i class="fas fa-eye"></i> View</a>
                            <a href="#" class="text-yellow-500 hover:text-yellow-700 mr-3"><i class="fas fa-edit"></i> Edit</a>
                            <a href="#" class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $leaveRequests->links() }}
        </div>
    </div>
</div>
@endsection
