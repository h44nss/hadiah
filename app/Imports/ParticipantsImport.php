<?php
// app/Imports/ParticipantsImport.php

namespace App\Imports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ParticipantsImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $eventId;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    public function model(array $row)
    {
        return new Participant([
            'event_id' => $this->eventId,
            'name' => $row['name'] ?? $row['nama'],
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? $row['telepon'] ?? null,
            'company' => $row['company'] ?? $row['perusahaan'] ?? null,
            'notes' => $row['notes'] ?? $row['keterangan'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required_without:nama|string|max:255',
            '*.nama' => 'required_without:name|string|max:255',
            '*.email' => 'nullable|email',
            '*.phone' => 'nullable|string|max:20',
            '*.telepon' => 'nullable|string|max:20',
        ];
    }
}
