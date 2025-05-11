<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HRActivity extends Model
{
    protected $table = 'hr_activities';  // Ensure this matches the actual table name

    protected $fillable = [
        'employee_id', 'type', 'title', 'description', 'action_url'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
