@extends('layouts.staff_head')

@section('title', 'Create Announcement | Blue Belle Resort')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">📝 Create Announcement</h2>

    <form action="{{ route('staff_head.announcements.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" name="title" class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Content</label>
            <textarea name="content" class="w-full px-4 py-2 border rounded-lg focus:outline-none" rows="6" required></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Post Announcement</button>
    </form>
</div>
@endsection
