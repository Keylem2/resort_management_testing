@extends('layouts.hr')

@section('title', 'Create Event')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Create New Event</h2>

    <form action="{{ route('hr.events.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block font-medium text-gray-700">Title</label>
            <input type="text" name="title" class="w-full border-gray-300 rounded-lg py-2 px-3">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Date</label>
            <input type="date" name="date" class="w-full border-gray-300 rounded-lg py-2 px-3">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Time (Optional)</label>
            <input type="text" name="time" class="w-full border-gray-300 rounded-lg py-2 px-3">
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700">Type</label>
            <select name="type" class="w-full border-gray-300 rounded-lg py-2 px-3">
                <option value="holiday">Holiday</option>
                <option value="birthday">Birthday</option>
                <option value="meeting">Meeting</option>
                <option value="training">Training</option>
                <option value="other">Other</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Create Event</button>
    </form>
</div>
@endsection
