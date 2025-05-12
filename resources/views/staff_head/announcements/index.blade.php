@extends('layouts.staff_head')

@section('title', 'Announcements | Blue Belle Resort')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📢 Announcements</h2>

    <a href="{{ route('staff_head.announcements.create') }}" class="text-blue-600 hover:text-blue-800 mb-4 block">➕ Create New Announcement</a>

    @if($announcements->isEmpty())
        <p class="text-gray-500">No announcements found.</p>
    @else
        <ul>
            @foreach($announcements as $announcement)
                <li class="mb-4 border-b pb-4">
                    <h3 class="text-lg font-bold">{{ $announcement->title }}</h3>
                    <p>{{ $announcement->content }}</p>
                    <small class="text-gray-500">{{ $announcement->created_at->format('F d, Y h:i A') }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
