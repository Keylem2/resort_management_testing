@extends('layouts.admin')

@section('title', 'Add New Staff')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Add New Staff Member</h1>
        <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">
            Back to Staff
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800">Personal Information</h3>
                    
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name *</label>
                        <input type="text" name="first_name" id="first_name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                    </div>
                    
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" id="phone"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                    </div>
                    
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="date_of_birth"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                    </div>
                    
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" id="address" rows="2"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]"></textarea>
                    </div>
                </div>
                
                <!-- Employment Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-gray-800">Employment Information</h3>
                    
                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700">Position *</label>
                        <select name="position" id="position" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                            <option value="">Select Position</option>
                            <option value="Housekeeper">Housekeeper</option>
                            <option value="LifeGuard">LifeGuard</option>
                            <option value="FrontDesk">Front Desk</option>
                            <option value="HumanResource">Human Resource</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date *</label>
                        <input type="date" name="hire_date" id="hire_date" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                    </div>
                    
                    <div class="pt-4">
                        <h3 class="text-lg font-medium text-gray-800">Emergency Contact</h3>
                        
                        <div class="mt-2">
                            <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                        </div>
                        
                        <div class="mt-2">
                            <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="emergency_contact_phone" id="emergency_contact_phone"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <h3 class="text-lg font-medium text-gray-800">Login Credentials</h3>
                        
                        <div class="mt-2">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                        </div>
                        
                        <div class="mt-2">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password *</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" id="notes" rows="3"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#f59e0b] focus:border-[#f59e0b]"></textarea>
            </div>
            
            <div class="mt-8">
                <button type="submit" class="w-full md:w-auto px-6 py-3 bg-[#f59e0b] hover:bg-[#d97706] text-white font-medium rounded-lg transition">
                    Add Staff Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection