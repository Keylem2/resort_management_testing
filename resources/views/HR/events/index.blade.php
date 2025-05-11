@extends('layouts.hr')

@section('title', 'Events')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Upcoming Events</h2>

    <a href="{{ route('hr.events.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg mb-4 inline-block">Add New Event</a>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr>
                <th class="border-b py-2">Title</th>
                <th class="border-b py-2">Date</th>
                <th class="border-b py-2">Time</th>
                <th class="border-b py-2">Type</th>
                <th class="border-b py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td class="border-b py-2">{{ $event->title }}</td>
                    <td class="border-b py-2">{{ $event->date }}</td>
                    <td class="border-b py-2">{{ $event->time ?? 'N/A' }}</td>
                    <td class="border-b py-2">{{ ucfirst($event->type) }}</td>
                    <td class="border-b py-2">
                        <a href="{{ route('hr.events.edit', $event->id) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('hr.events.destroy', $event->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
