@extends('layouts.staff_team')

@section('title', 'Announcements | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold text-gray-800">Announcements</h2>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        @forelse($announcements as $announcement)
            <div class="p-6 border-b border-gray-100 last:border-b-0">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">{{ $announcement->title }}</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Posted: {{ $announcement->created_at->format('M j, Y \a\t h:i A') }}
                            @if($announcement->reads->contains('employee_id', Auth::user()->employee->id))
                                <span class="ml-2 text-green-500">
                                    <i class="fas fa-check-circle"></i> Read
                                </span>
                            @endif
                        </p>
                    </div>
                    @if($announcement->is_important)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                            Important
                        </span>
                    @endif
                </div>
                
                <div class="mt-4 text-gray-700">
                    {!! nl2br(e($announcement->content)) !!}
                </div>
                
                @if($announcement->attachments->count())
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Attachments</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($announcement->attachments as $attachment)
                                <a href="{{ Storage::url($attachment->path) }}" target="_blank" 
                                   class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-paperclip mr-2"></i> {{ $attachment->original_name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-8">
                <i class="fas fa-bullhorn text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">No announcements found</p>
            </div>
        @endforelse
        
        <!-- Pagination -->
        @if($announcements->hasPages())
            <div class="mt-6">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection