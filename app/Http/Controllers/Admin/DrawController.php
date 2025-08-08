<?php
// app/Http/Controllers/Admin/DrawController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Draw;
use App\Models\Winner;
use Illuminate\Http\Request;

class DrawController extends Controller
{
    public function index(Event $event)
    {
        $draws = $event->draws()
            ->withCount('winners')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.draws.index', compact('event', 'draws'));
    }

    public function create(Event $event)
    {
        return view('admin.draws.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'winner_count' => 'required|integer|min:1',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['event_id'] = $event->id;

        // Simpan gambar ke public/uploads/draws
        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/draws'), $filename);
            $validated['image'] = 'draws/' . $filename; // Simpan relatif ke folder uploads
        }

        // Simpan ke database
        Draw::create($validated); // Simpan data undian ke database

        return redirect()->route('admin.draws.index', $event)
            ->with('success', 'Undian berhasil dibuat!');
    }


    public function show(Event $event, Draw $draw)
    {
        $draw->load(['winners.participant']);
        return view('admin.draws.show', compact('event', 'draw'));
    }

    public function execute(Event $event, Draw $draw)
    {
        // Hitung jumlah pemenang yang sudah ada
        $currentWinners = $draw->winners()->count();

        // Cek jika sudah selesai
        if ($currentWinners >= $draw->winner_count) {
            $draw->update(['status' => 'completed']);
            return redirect()->back()->with('error', 'Undian sudah selesai!');
        }

        // Ambil peserta yang belum menang
        $eligibleParticipants = $event->participants()
            ->whereNotIn('id', function ($query) use ($draw) {
                $query->select('participant_id')
                    ->from('winners')
                    ->where('draw_id', $draw->id);
            })
            ->get();

        if ($eligibleParticipants->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada peserta tersisa!');
        }

        // Pilih satu peserta acak
        $winner = $eligibleParticipants->random();

        // Simpan sebagai pemenang berikutnya
        $position = $currentWinners + 1;

        Winner::create([
            'draw_id' => $draw->id,
            'participant_id' => $winner->id,
            'position' => $position,
            'drawn_at' => now(),
        ]);

        // Tandai "completed" jika sudah cukup pemenang
        if ($position >= $draw->winner_count) {
            $draw->update(['status' => 'completed']);
        }

        return redirect()->route('admin.draws.show', [$event, $draw])
            ->with('success', "Pemenang ke-$position berhasil dipilih!");
    }
}
