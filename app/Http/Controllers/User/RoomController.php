<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Display all rooms grouped by categories with 360° previews
    public function index()
    {
        // Get all couple rooms (both available and occupied)
        $coupleRooms = Room::where('room_type', 'Couple Room')
            ->orderBy('room_number')
            ->get();

        // Get all family rooms (both available and occupied)
        $familyRooms = Room::where('room_type', 'Family Room')
            ->orderBy('room_number')
            ->get();

        return view('user.rooms.index', compact('coupleRooms', 'familyRooms'));
    }

    // Show rooms by type (Couple or Family)
    public function showByType($type)
    {
        // Ensure the room type is valid (either 'Couple Room' or 'Family Room')
        $validTypes = ['Couple Room', 'Family Room'];

        if (!in_array($type, $validTypes)) {
            abort(404); // If the type is invalid, show a 404 error
        }

        // Get the rooms of the given type
        $rooms = Room::where('room_type', $type)
            ->orderBy('room_number')
            ->get();

        // Return the appropriate view based on the room type
        if ($type == 'Couple Room') {
            return view('user.rooms.couple', compact('rooms')); // Pass rooms to the couple view
        } elseif ($type == 'Family Room') {
            return view('user.rooms.family', compact('rooms')); // Pass rooms to the family view
        }

        // Default fall back in case something goes wrong
        return redirect()->route('rooms')->with('error', 'Invalid room type!');
    }
}
