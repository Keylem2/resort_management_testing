@extends('layouts.staff_team')

@section('title', 'Task Details | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Task Details</h2>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
            {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
            {{ ucfirst($task->status) }}
        </span>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $task->title }}</h3>
                <p class="text-gray-600">{{ $task->description }}</p>
                
                <div class="mt-4 space-y-2">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Due Date:</span>
                        <span class="ml-2 {{ $task->isOverdue() ? 'text-red-600' : 'text-gray-700' }}">
                            {{ $task->due_date->format('M j, Y') }}
                        </span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Priority:</span>
                        <span class="ml-2 font-medium 
                            {{ $task->priority === 'high' ? 'text-red-600' : 
                               ($task->priority === 'medium' ? 'text-amber-600' : 'text-gray-600') }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Assigned By:</span>
                        <span class="ml-2 text-gray-700">{{ $task->assigner->name }}</span>
                    </div>
                </div>
            </div>
            
            <div>
                <h4 class="text-md font-bold text-gray-800 mb-2">Update Task</h4>
                <form method="POST" action="{{ route('staff_team.tasks.update', $task) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm">
                            @foreach(['pending', 'in_progress', 'completed'] as $status)
                                <option value="{{ $status }}" {{ $task->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Add Note</label>
                        <textarea name="notes" id="notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary">
                        Update Task
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Task Notes -->
        @if($task->notes->isNotEmpty())
            <div class="mt-8">
                <h4 class="text-md font-bold text-gray-800 mb-3">Task Notes</h4>
                <div class="space-y-4">
                    @foreach($task->notes->sortByDesc('created_at') as $note)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium">{{ $note->employee->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $note->created_at->format('M j, Y h:i A') }}</p>
                                </div>
                            </div>
                            <p class="mt-2 text-gray-700">{{ $note->content }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection