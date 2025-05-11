<?php

namespace App\Http\Controllers\FrontDesk;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{
    // Display all rooms for the Front Desk view with 360° previews
    public function index()
    {
        // Get all rooms (both available and occupied)
        $coupleRooms = Room::where('room_type', 'Couple Room')->orderBy('room_number')->get();
        $familyRooms = Room::where('room_type', 'Family Room')->orderBy('room_number')->get();
        
        return view('frontdesk.rooms.index', compact('coupleRooms', 'familyRooms'));
    }

    // Show rooms that are available
    public function available()
    {
        $rooms = Room::where('status', 'available')->orderBy('room_number')->get();
        return view('frontdesk.rooms.available', compact('rooms'));
    }

    // Show rooms that are occupied
    public function occupied()
    {
        $rooms = Room::where('status', 'occupied')->orderBy('room_number')->get();
        return view('frontdesk.rooms.occupied', compact('rooms'));
    }

    // Show rooms by type (e.g., Couple Room or Family Room)
    public function showByType($type)
    {
        $validTypes = ['Couple Room', 'Family Room'];

        if (!in_array($type, $validTypes)) {
            abort(404); // If the type is invalid, show a 404 error
        }

        // Get rooms by the given type
        $rooms = Room::where('room_type', $type)->orderBy('room_number')->get();
        
        return view('frontdesk.rooms.show_by_type', compact('rooms', 'type'));
    }
}
