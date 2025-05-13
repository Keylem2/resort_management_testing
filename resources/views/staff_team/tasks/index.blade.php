@extends('layouts.staff_team')

@section('title', 'My Tasks | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">My Tasks</h2>
        <span class="text-sm text-gray-500">
            {{ $currentTasks->where('status', 'completed')->count() }}/{{ $currentTasks->count() }} completed
        </span>
    </div>

    <!-- Current Tasks -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Current Tasks</h3>
        
        @forelse($currentTasks as $task)
            <div class="p-4 border rounded-lg mb-3 hover:bg-gray-50 {{ $task->status === 'completed' ? 'border-green-200 bg-green-50' : '' }}">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="font-medium {{ $task->status === 'completed' ? 'text-green-800' : 'text-gray-800' }}">
                            {{ $task->title }}
                        </h4>
                        <p class="text-sm text-gray-500 mt-1">
                            Due: {{ $task->due_date->format('M j, Y') }}
                            • Priority: <span class="font-medium {{ $task->priority === 'high' ? 'text-red-500' : ($task->priority === 'medium' ? 'text-amber-500' : 'text-gray-500') }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('staff_team.tasks.show', $task) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                
                @if($task->status !== 'completed')
                    <form method="POST" action="{{ route('staff_team.tasks.update', $task) }}" class="mt-3">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="text-sm bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                            Mark Complete
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-500">No current tasks assigned</p>
        @endforelse
    </div>

    <!-- Recently Completed -->
    @if($completedTasks->isNotEmpty())
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recently Completed</h3>
            <div class="space-y-3">
                @foreach($completedTasks as $task)
                    <div class="p-3 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-800">{{ $task->title }}</p>
                            <p class="text-sm text-gray-500">
                                Completed: {{ $task->completed_at->format('M j, h:i A') }}
                            </p>
                        </div>
                        <a href="{{ route('staff_team.tasks.show', $task) }}" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection