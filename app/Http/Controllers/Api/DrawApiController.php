<?php
// app/Http/Controllers/Api/DrawApiController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Draw;

class DrawApiController extends Controller
{
    public function status(...$params)
    {
        // Extract the draw from params
        $draw = $params[0] ?? null;

        if ($draw) {
            return response()->json([
                'status' => $draw->status,
                'winner_count' => $draw->winner_count,
                'current_winners' => $draw->winners()->count(),
                'winners' => $draw->winners()
                    ->with('participant:id,name,email,company')
                    ->orderBy('position')
                    ->get()
                    ->map(function ($winner) {
                        return [
                            'position' => $winner->position,
                            'participant' => [
                                'name' => $winner->participant->name,
                                'company' => $winner->participant->company,
                            ],
                            'drawn_at' => $winner->drawn_at->format('Y-m-d H:i:s')
                        ];
                    })
            ]);
        }

        // Fallback - this shouldn't happen with the current routes
        return response()->json(['error' => 'Draw not found'], 404);
    }

    public function execute(...$params)
    {
        // Extract the draw from params
        $draw = $params[0] ?? null;

        if ($draw) {
            if ($draw->status === 'completed') {
                return response()->json(['error' => 'Draw already completed'], 400);
            }

            $event = $draw->event;

            // Ambil peserta yang belum pernah menang
            $participants = $event->participants()
                ->whereNotIn('id', function ($query) use ($draw) {
                    $query->select('participant_id')
                        ->from('winners')
                        ->where('draw_id', $draw->id);
                })
                ->get();

            if ($participants->isEmpty()) {
                $draw->update(['status' => 'completed']);
                return response()->json(['status' => 'completed']);
            }

            // Ambil satu peserta secara acak
            $participant = $participants->random();

            // Hitung posisi pemenang selanjutnya
            $nextPosition = $draw->winners()->count() + 1;

            // Simpan pemenang
            $draw->winners()->create([
                'participant_id' => $participant->id,
                'position' => $nextPosition,
                'drawn_at' => now(),
            ]);

            // Update status ke "completed" kalau jumlah sudah cukup
            if ($nextPosition >= $draw->winner_count) {
                $draw->update(['status' => 'completed']);
            }

            return $this->status($draw);
        }

        // Fallback - this shouldn't happen with the current routes
        return response()->json(['error' => 'Draw not found'], 404);
    }
}
