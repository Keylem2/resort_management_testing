@extends('layouts.hr')

@section('title', 'Create Leave Request | Bluebelle Resort')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">📝 Create Leave Request</h1>

        <form method="POST" action="{{ route('hr.leave.store') }}" onsubmit="return validateDates()">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Employee</label>
                <select name="employee_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">End Date</label>
                <input type="date" id="end_date" name="end_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Reason</label>
                <textarea name="reason" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" rows="4" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Submit
            </button>
        </form>
    </div>
</div>

<script>
function validateDates() {
    const startDate = new Date(document.getElementById('start_date').value);
    const endDate = new Date(document.getElementById('end_date').value);
    const today = new Date();

    // Remove time portion for accurate date comparison
    today.setHours(0, 0, 0, 0);

    if (startDate < today) {
        alert("Start date cannot be in the past.");
        return false;
    }

    if (endDate < startDate) {
        alert("End date cannot be earlier than the start date.");
        return false;
    }

    return true;
}
</script>
@endsection
