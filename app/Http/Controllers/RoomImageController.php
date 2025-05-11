<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomImageController extends Controller
{
    public function upload(Request $request, Room $room)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('room_images', 'public');
            $room->update(['image' => $path]);
        }

        return back()->with('success', 'Room image updated successfully');
    }
}