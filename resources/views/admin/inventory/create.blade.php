@extends('layouts.admin')

@section('title', 'Add Inventory Item')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Inventory Item</h2>
    
    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Item Name *</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500"></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Initial Stock *</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (₱)</label>
                    <input type="number" step="0.01" name="price" id="price" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Item Type *</label>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input id="consumable" name="is_consumable" type="radio" value="1" checked
                            class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300">
                        <label for="consumable" class="ml-2 block text-sm text-gray-700">Consumable</label>
                    </div>
                    <div class="flex items-center">
                        <input id="non-consumable" name="is_consumable" type="radio" value="0"
                            class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300">
                        <label for="non-consumable" class="ml-2 block text-sm text-gray-700">Non-Consumable</label>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Save Item
                </button>
            </div>
        </div>
    </form>
</div>
@endsection