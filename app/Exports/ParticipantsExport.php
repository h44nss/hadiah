<?php
// app/Exports/ParticipantsExport.php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function collection()
    {
        return Participant::where('event_id', $this->eventId)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'Telepon',
            'Perusahaan',
            'Keterangan',
            'Tanggal Daftar'
        ];
    }

    public function map($participant): array
    {
        return [
            $participant->id,
            $participant->name,
            $participant->email,
            $participant->phone,
            $participant->company,
            $participant->notes,
            $participant->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
