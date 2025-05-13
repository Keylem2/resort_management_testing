<?php

namespace App\Http\Controllers\StaffTeam;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        
        return view('staff_team.tasks.index', [
            'currentTasks' => $employee->tasks()
                                ->where('due_date', '>=', now()->startOfDay())
                                ->where('status', '!=', 'completed')
                                ->orderBy('priority', 'desc')
                                ->orderBy('due_date')
                                ->get(),
            'completedTasks' => $employee->tasks()
                                ->where('status', 'completed')
                                ->orderBy('completed_at', 'desc')
                                ->take(5)
                                ->get()
        ]);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        
        return view('staff_team.tasks.show', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
            'notes' => 'nullable|string|max:500'
        ]);
        
        $updateData = ['status' => $validated['status']];
        
        if ($validated['status'] === 'completed') {
            $updateData['completed_at'] = now();
        }
        
        $task->update($updateData);
        
        if ($request->filled('notes')) {
            $task->notes()->create([
                'content' => $validated['notes'],
                'employee_id' => Auth::user()->employee->id
            ]);
        }

        return redirect()->route('staff_team.tasks.index')
            ->with('success', 'Task updated successfully');
    }
}