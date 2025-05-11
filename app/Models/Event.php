<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'date', 'time', 'type', 'employee_id'
    ];

    protected $casts = [
        'date' => 'date', // This ensures date is treated as a Carbon instance
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
