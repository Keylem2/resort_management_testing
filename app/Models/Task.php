<?php

// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'assigned_by',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime'
    ];

    // Relationship to the employee this task is assigned to
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relationship to the employee who assigned this task
    public function assigner()
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    // Task notes relationship
    public function notes()
    {
        return $this->hasMany(TaskNote::class);
    }

    // Scope for today's tasks
    public function scopeToday($query)
    {
        return $query->whereDate('due_date', today());
    }

    // Scope for completed tasks
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Check if task is overdue
    public function isOverdue()
    {
        return !$this->completed_at && $this->due_date->isPast();
    }
}