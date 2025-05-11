<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StaffController extends Controller
{
    public function index()
    {
        $staffMembers = Staff::latest()->paginate(10);
        return view('admin.staff.index', compact('staffMembers'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:staff,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:Housekeeper,LifeGuard,FrontDesk,HumanResource',
            'hire_date' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => 'staff',
        ]);

        // Create staff record
        $staff = Staff::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'hire_date' => $request->hire_date,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'notes' => $request->notes,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member added successfully.');
    }

    public function show(Staff $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:staff,email,'.$staff->id,
            'phone' => 'nullable|string|max:20',
            'position' => 'required|in:Housekeeper,LifeGuard,FrontDesk,HumanResource',
            'hire_date' => 'required|date',
        ]);

        $staff->update($request->all());

        // Update corresponding user if exists
        if ($staff->user) {
            $staff->user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        // Delete user account if exists
        if ($staff->user) {
            $staff->user->delete();
        }
        
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}