<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_code', 'name', 'email', 'phone', 'department', 'position', 'hire_date', 'salary', 'status'
    ];

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
}
