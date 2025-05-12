<?php

// AnnouncementController.php

namespace App\Http\Controllers\StaffHead;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Show all announcements
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('staff_head.announcements.index', compact('announcements'));
    }

    public function create()
    {
        // Show the create announcement form
        return view('staff_head.announcements.create');
    }

    public function store(Request $request)
    {
        // Create a new announcement
        Announcement::create([
            'title' => $request->title,
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('staff_head.announcements.index')->with('success', 'Announcement posted successfully.');
    }
}
