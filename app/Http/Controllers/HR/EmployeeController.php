<?php

namespace App\Http\Controllers\HR;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StaffTeam;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate(10);
        return view('HR.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('HR.employees.create');
    }

    public function store(Request $request)
{
    DB::beginTransaction();
    try {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email',
            'phone' => 'nullable|string|max:255',
            'department' => 'required|string|max:255', // Department should be selected
            'position' => 'required|string|max:255', // Ensure position is included for role assignment
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Create the employee
        $employee = Employee::create($validated);

        // Determine the usertype based on department
        $usertype = $this->determineUserType($employee->department);

        // Create user account for login purposes
        $user = User::create([
            'name' => $employee->name,
            'email' => $employee->email,
            'password' => bcrypt('defaultpassword'), // or generate a random password
            'usertype' => $usertype,  // Assign the correct usertype based on department
            'employee_id' => $employee->id,
        ]);

        // Create staff team entry depending on the department
        if ($employee->department == 'Finance') {
            StaffTeam::create([
                'staff_head_id' => $employee->id,  // Assign Finance Head if applicable
                'employee_id' => $employee->id,
                'role' => $employee->position, // Finance role (Finance Head, Inventory Manager, etc.)
            ]);
        } elseif ($employee->department == 'HR') {
            // Add employee to HR if the department is HR
            StaffTeam::create([
                'staff_head_id' => $employee->id,  // Assign HR head if needed
                'employee_id' => $employee->id,
                'role' => $employee->position, // HR role
            ]);
        } elseif ($employee->department == 'Staff') {
            // Add employee to Staff
            StaffTeam::create([
                'staff_head_id' => $employee->id,  // Assign staff head if needed
                'employee_id' => $employee->id,
                'role' => $employee->position, // Staff role (Lifeguard, Housekeeper)
            ]);
        }

        DB::commit();

        return redirect()->route('hr.employees.index')->with('success', 'Employee added successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Error occurred: ' . $e->getMessage());
    }
}

    
    // Helper function to determine usertype based on department
protected function determineUserType($department)
{
    switch ($department) {
        case 'HR':
            return 'hr';
        case 'Finance':
            return 'finance';
        case 'Staff':
            return 'staff';
        default:
            return 'staff';  // Default to 'staff' if department is not recognized
    }
}

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('HR.employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('HR.employees.edit', compact('employee'));
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
            'hire_date' => 'nullable|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Update the employee
        $employee->update($validated);

        return redirect()->route('hr.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('hr.employees.index')->with('success', 'Employee deleted successfully.');
    }
}
