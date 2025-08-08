<?php
// app/Http/Controllers/PublicDrawController.php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Draw;

class PublicDrawController extends Controller
{
    public function show($eventSlug, $drawSlug)
    {
        $event = Event::where('slug', $eventSlug)->firstOrFail();
        $draw = $event->draws()->where('slug', $drawSlug)->with(['winners.participant'])->firstOrFail();

        return view('draws.public', compact('event', 'draw'));
    }

    public function event($eventSlug)
    {
        $event = Event::where('slug', $eventSlug)
            ->with(['draws.winners.participant'])
            ->firstOrFail();

        return view('events.public', compact('event'));
    }
}
