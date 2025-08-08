<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Draw;
use App\Models\Participant;
use App\Models\Winner;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_events' => Event::count(),
            'active_events' => Event::where('status', 'active')->count(),
            'total_participants' => Participant::count(),
            'total_draws' => Draw::count(),
            'completed_draws' => Draw::where('status', 'completed')->count(),
        ];

        $recent_events = Event::with('draws', 'participants')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_events'));
    }
}
