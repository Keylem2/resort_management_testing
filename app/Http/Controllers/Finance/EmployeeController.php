<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\StaffTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::where('department', 'Finance')->paginate(10);
        return view('finance.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('finance.employees.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate input
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:employees,email',
                'phone' => 'nullable|string|max:255',
                'department' => 'required|string|max:255',
                'position' => 'required|string|max:255',
                'salary' => 'required|numeric|min:0',
                'status' => 'required|in:active,inactive',
            ]);

            // Create employee
            $employee = Employee::create($validated);

            // Create user for login
            $user = User::create([
                'name' => $employee->name,
                'email' => $employee->email,
                'password' => bcrypt('defaultpassword'), // or generate a random password
                'usertype' => 'staff',
                'employee_id' => $employee->id,
            ]);

            // Create staff team entry if department is Finance
            if ($employee->department == 'Finance') {
                StaffTeam::create([
                    'staff_head_id' => $employee->id,  // Adjust this logic for Finance Head, etc.
                    'employee_id' => $employee->id,
                    'role' => $employee->position,
                ]);
            }

            DB::commit();

            return redirect()->route('finance.employees.index')->with('success', 'Finance Employee added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('finance.employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('finance.employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Update the employee
        $employee->update($validated);

        return redirect()->route('finance.employees.index')->with('success', 'Finance Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('finance.employees.index')->with('success', 'Finance Employee deleted successfully!');
    }
}

