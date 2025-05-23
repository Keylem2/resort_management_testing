<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id', 'payroll_date', 'gross_salary', 'deductions', 'net_salary', 'processed'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
