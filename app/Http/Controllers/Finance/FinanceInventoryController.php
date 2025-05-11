<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryRequest;
use Illuminate\Http\Request;

class FinanceInventoryController extends Controller
{
    public function index()
    {
        $requests = InventoryRequest::with(['user', 'inventoryItem'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('finance.inventory.index', compact('requests'));
    }

    public function show(InventoryRequest $request)
    {
        return view('finance.inventory.show', compact('request'));
    }

    public function approve(Request $request, InventoryRequest $inventoryRequest)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        // Check if enough stock is available
        if ($inventoryRequest->inventoryItem->stock_quantity < $inventoryRequest->quantity_requested) {
            return back()->with('error', 'Not enough stock available to fulfill this request.');
        }

        // Update inventory
        $inventoryRequest->inventoryItem->decrement('stock_quantity', $inventoryRequest->quantity_requested);

        // Update request status
        $inventoryRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('finance.inventory.index')
            ->with('success', 'Inventory request approved successfully!');
    }

    public function reject(Request $request, InventoryRequest $inventoryRequest)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $inventoryRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('finance.inventory.index')
            ->with('success', 'Inventory request rejected successfully!');
    }
}