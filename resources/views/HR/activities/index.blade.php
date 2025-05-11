@extends('layouts.hr')

@section('title', 'Recent HR Activities | Bluebelle Resort')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">📝 Recent HR Activities</h1>

        @if($activities->count() > 0)
            <ul class="space-y-4">
                @foreach($activities as $activity)
                    <li class="border-b border-gray-200 pb-4 last:border-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="font-semibold text-lg text-gray-800">{{ $activity->title }}</h2>
                                <p class="text-gray-600 text-sm">{{ $activity->description }}</p>
                                <span class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                            @if($activity->action_url)
                                <a href="{{ $activity->action_url }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View Details</a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-6">
                {{ $activities->links() }}
            </div>
        @else
            <div class="text-center py-6 text-gray-500">
                No recent activities found.
            </div>
        @endif
    </div>
</div>
@endsection
