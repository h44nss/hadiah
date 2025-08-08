<?php
// app/Http/Controllers/Admin/EventController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::withCount(['draws', 'participants'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'organizer_name' => 'required|string|max:255',
            'organizer_email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|in:active,inactive,completed'
        ]);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME));
            $ext = $request->image->getClientOriginalExtension();
            $fullName = $filename . '.' . $ext;

            $request->file('image')->move(public_path('uploads/events'), $fullName);
            $validated['image'] = 'events/' . $fullName; // Simpan relatif ke folder 'uploads'
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dibuat!');
    }


    public function show(Event $event)
    {
        $event->load(['draws.winners.participant', 'participants']);
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'status' => 'required|in:active,inactive,completed',
            'organizer_name' => 'required|string|max:255',
            'organizer_email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // (Opsional) hapus gambar lama jika perlu
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }

            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diupdate!');
    }


    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }
}
