<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffTeam extends Model
{
    protected $fillable = ['staff_head_id', 'employee_id', 'role'];

    public function staffHead()
    {
        return $this->belongsTo(Employee::class, 'staff_head_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}