<?php

namespace App\Exports;

use App\Models\Wiki;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DirectoryExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Wiki::with([
            'organisation.ministry',
            'organisation.department',
            'organisation.segment',
            'organisation.unit',
            'organisation.subUnit',
        ])->where('wiki_type', 'directory');

        // Apply filters if passed
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('designation', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        return $query->get()->map(function ($wiki) {
            return [
                'Name' => $wiki->name,
                'Designation' => $wiki->designation,
                'Ministry' => $wiki->organisation->ministry->name ?? '-',
                'Department' => $wiki->organisation->department->name ?? '-',
                'Division' => $wiki->organisation->segment->name ?? '-',
                'Unit/Section' => $wiki->organisation->unit->name ?? '-',
                'Sub Unit/Sub Section' => $wiki->organisation->subUnit->name ?? '-',
                'Dial Code' => $wiki->dial_code ?? '-',
                'Office Number' => $wiki->office_number ?? '-',
                'Mobile Number' => $wiki->mobile_number ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Designation',
            'Ministry',
            'Department',
            'Division',
            'Unit/Section',
            'Sub Unit/Sub Section',
            'Dial Code',
            'Office Number',
            'Mobile Number',
        ];
    }
}
