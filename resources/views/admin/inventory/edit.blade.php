@extends('layouts.admin')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Inventory Item</h2>
    
    <form action="{{ route('admin.inventory.update', $inventory) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $inventory->name) }}" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500">{{ old('description', $inventory->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $inventory->stock_quantity) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (₱)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $inventory->price) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Item Type</label>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input id="consumable" name="is_consumable" type="radio" value="1" 
                            {{ old('is_consumable', $inventory->is_consumable) ? 'checked' : '' }}
                            class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300">
                        <label for="consumable" class="ml-2 block text-sm text-gray-700">Consumable</label>
                    </div>
                    <div class="flex items-center">
                        <input id="non-consumable" name="is_consumable" type="radio" value="0" 
                            {{ !old('is_consumable', $inventory->is_consumable) ? 'checked' : '' }}
                            class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300">
                        <label for="non-consumable" class="ml-2 block text-sm text-gray-700">Non-Consumable</label>
                    </div>
                </div>
                @error('is_consumable')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Update Item
                </button>
            </div>
        </div>
    </form>
</div>
@endsection