<?php

namespace App\Http\Controllers\StaffTeam;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $employee = Auth::user()->employee;
        
        return view('staff_team.inventory.index', [
            'pendingRequests' => $employee->inventoryRequests()
                                    ->where('status', 'pending')
                                    ->with('item')
                                    ->get(),
            'approvedRequests' => $employee->inventoryRequests()
                                    ->where('status', 'approved')
                                    ->with('item')
                                    ->take(5)
                                    ->get(),
            'availableItems' => InventoryItem::where('department', $employee->department)
                                    ->get()
        ]);
    }

    public function create()
    {
        $employee = Auth::user()->employee;
        
        return view('staff_team.inventory.create', [
            'items' => InventoryItem::where('department', $employee->department)
                            ->orderBy('name')
                            ->get()
        ]);
    }

    public function store(InventoryRequest $request)
    {
        $employee = Auth::user()->employee;
        
        $inventoryRequest = InventoryRequest::create([
            'employee_id' => $employee->id,
            'inventory_item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
            'urgency' => $request->urgency,
            'status' => 'pending'
        ]);

        return redirect()->route('staff_team.inventory.index')
            ->with('success', 'Inventory request submitted successfully');
    }
}