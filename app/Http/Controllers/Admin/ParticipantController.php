<?php
// app/Http/Controllers/Admin/ParticipantController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParticipantsImport;
use App\Exports\ParticipantsExport;

class ParticipantController extends Controller
{
    public function index(Event $event)
    {
        $participants = $event->participants()
            ->orderBy('name')
            ->paginate(15);

        return view('admin.participants.index', compact('event', 'participants'));
    }

    public function create(Event $event)
    {
        return view('admin.participants.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $event->participants()->create($validated);

        return redirect()->route('admin.participants.index', $event)
            ->with('success', 'Peserta berhasil ditambahkan!');
    }

    public function import(Request $request, Event $event)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ParticipantsImport($event->id), $request->file('file'));

            return redirect()->route('admin.participants.index', $event)
                ->with('success', 'Data peserta berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error importing file: ' . $e->getMessage());
        }
    }

    public function export(Event $event)
    {
        return Excel::download(
            new ParticipantsExport($event->id),
            'participants-' . $event->name . '.xlsx'
        );
    }

    public function destroy(Event $event, Participant $participant)
    {
        $participant->delete();

        return redirect()->route('admin.participants.index', $event)
            ->with('success', 'Peserta berhasil dihapus!');
    }
}
