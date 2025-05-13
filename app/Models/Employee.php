<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_code', 'name', 'email', 'phone', 'department', 'position', 'hire_date', 'salary', 'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (empty($employee->employee_code)) {
                // Generate the code based on the department prefix
                $prefix = strtoupper(substr($employee->department, 0, 2));
                $lastEmployee = Employee::where('department', $employee->department)->latest()->first();
                $lastId = $lastEmployee ? (int) substr($lastEmployee->employee_code, -3) : 0;
                $nextId = str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
                $employee->employee_code = $prefix . '-' . $nextId;
            }
        });
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function activities()
    {
        return $this->hasMany(HRActivity::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function department()
    {
    return $this->belongsTo(Department::class);  // If you create a Department model
    }

    // app/Models/Employee.php
public function user()
{
    return $this->hasOne(User::class, 'employee_id');
}

public function tasks()
{
    return $this->hasMany(Task::class);
}

public function inventoryRequests()
{
    return $this->hasMany(InventoryRequest::class);
}

public function shifts() // For lifeguards
{
    return $this->hasMany(Shift::class);
}

public function cleaningAssignments() // For housekeepers
{
    return $this->hasMany(CleaningAssignment::class);
}

// app/Models/Employee.php

public function assignedTasks()
{
    return $this->hasMany(Task::class, 'assigned_by');
}

public function taskNotes()
{
    return $this->hasMany(TaskNote::class);
}
    
public function announcements()
{
    return $this->hasMany(Announcement::class);
}

    }
