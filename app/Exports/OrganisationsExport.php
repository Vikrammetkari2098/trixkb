<?php

namespace App\Exports;

use App\Models\Organisation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrganisationsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Load relationships for names
        return Organisation::with(['ministry', 'department', 'segment', 'unit', 'subUnit'])
            ->get()
            ->map(function ($org) {
                return [
                    'ID' => $org->id,
                    'Name' => $org->name,
                    'Ministry' => $org->ministry->name ?? '-',
                    'Department' => $org->department->name ?? '-',
                    'Division' => $org->segment->name ?? '-',
                    'Unit' => $org->unit->name ?? '-',
                    'Sub Unit' => $org->subUnit->name ?? '-',
                    'Status' => $org->status ? 'Active' : 'Inactive',
                ];
            });
    }

    public function headings(): array
    {
        return ['ID','Name','Ministry','Department','Division','Unit','Sub Unit','Status'];
    }
}
