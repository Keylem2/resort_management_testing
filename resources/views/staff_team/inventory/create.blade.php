@extends('layouts.staff_team')

@section('title', 'Create Inventory Request | Blue Belle Resort')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">New Inventory Request</h2>
        <a href="{{ route('staff_team.inventory.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <form method="POST" action="{{ route('staff_team.inventory.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Item Selection -->
                <div class="mb-4">
                    <label for="item_id" class="block text-sm font-medium text-gray-700 mb-1">Item Needed *</label>
                    <select name="item_id" id="item_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Select an item</option>
                        @foreach($items as $item)
                            <option value="{{ $item->id }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->current_stock }} available)
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Quantity -->
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                
                <!-- Urgency -->
                <div class="mb-4">
                    <label for="urgency" class="block text-sm font-medium text-gray-700 mb-1">Urgency *</label>
                    <select name="urgency" id="urgency" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="low" {{ old('urgency') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('urgency') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('urgency') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
                
                <!-- Reason -->
                <div class="mb-4 md:col-span-2">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Request *</label>
                    <textarea name="reason" id="reason" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required>{{ old('reason') }}</textarea>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-paper-plane mr-2"></i> Submit Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection