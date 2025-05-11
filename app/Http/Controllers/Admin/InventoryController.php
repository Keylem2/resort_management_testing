<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
{
    $inventory = Inventory::orderBy('name')->paginate(10); // Show 10 items per page
    return view('admin.inventory.index', compact('inventory'));
}

    public function edit(Inventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'is_consumable' => 'required|boolean'
        ]);

        $inventory->update($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item updated successfully');
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock_quantity' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'is_consumable' => 'required|boolean'
        ]);

        Inventory::create($validated);

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item created successfully');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        
        return redirect()->route('admin.inventory.index')
            ->with('success', 'Inventory item deleted successfully');
    }
}
