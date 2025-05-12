@extends('layouts.staff_head')

@section('title', 'Team Management | Blue Belle Resort')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">🧍‍♂️ Team Management</h2>

    @if($teamMembers->isEmpty())
        <p class="text-gray-500">No team members found.</p>
    @else
        <table class="min-w-full bg-white rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-100 border-b">Name</th>
                    <th class="py-2 px-4 bg-gray-100 border-b">Position</th>
                    <th class="py-2 px-4 bg-gray-100 border-b">Contact</th>
                    <th class="py-2 px-4 bg-gray-100 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teamMembers as $member)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $member->name }}</td>
                        <td class="py-2 px-4">{{ $member->position }}</td>
                        <td class="py-2 px-4">{{ $member->phone }}</td>
                        <td class="py-2 px-4">
                            <a href="{{ route('staff_head.team.show', $member->id) }}" class="text-blue-600 hover:text-blue-800">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
