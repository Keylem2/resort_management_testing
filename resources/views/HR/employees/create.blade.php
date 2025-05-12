@extends('layouts.hr')

@section('title', 'Add New Employee | Bluebelle Resort')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">➕ Add New Employee</h1>

        <form action="{{ route('hr.employees.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone</label>
                <input type="text" id="phone" name="phone" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="department" class="block text-gray-700 font-semibold mb-2">Department</label>
                <select name="department" id="department" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    <option value="">Select Department</option>
                    <option value="HR">HR</option>
                    <option value="Finance">Finance</option>
                    <option value="Front Office">Front Office</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="position" class="block text-gray-700 font-semibold mb-2">Position</label>
                <select name="position" id="position" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    <option value="">Select Department First</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="salary" class="block text-gray-700 font-semibold mb-2">Salary</label>
                <input type="number" id="salary" name="salary" step="0.01" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                <select id="status" name="status" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Add Employee</button>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded");
    
    const departmentSelect = document.getElementById('department');
    const positionSelect = document.getElementById('position');
    
    const departmentPositions = {
        'HR': ['Staff Head', 'Lifeguard', 'Housekeeper'],
        'Finance': ['Finance Head', 'Inventory Manager', 'Sales Clerk'],
        'Front Office': ['Front Desk Staff'],
        'Staff': ['Staff Head', 'Housekeeper', 'Lifeguard']
    };

    function updatePositions() {
        console.log("Function updatePositions called");
        const selectedDepartment = departmentSelect.value;
        console.log("Selected department:", selectedDepartment);

        // Clear existing options
        positionSelect.innerHTML = '<option value="">Select Position</option>';

        // Add positions if department is selected
        if (selectedDepartment && departmentPositions[selectedDepartment]) {
            console.log("Adding positions for:", selectedDepartment);
            departmentPositions[selectedDepartment].forEach(position => {
                const option = document.createElement('option');
                option.value = position;
                option.textContent = position;
                positionSelect.appendChild(option);
            });
        }
    }

    // Initialize
    updatePositions();

    // Add event listener
    departmentSelect.addEventListener('change', function() {
        console.log("Department change detected");
        updatePositions();
    });
});

</script>
@endsection

@endsection