<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ArticlesExport implements FromCollection, WithHeadings, WithMapping
{
    protected array $ids;

    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        return Article::with(['tags', 'labels'])
            ->when(!empty($this->ids), fn ($q) =>
                $q->whereIn('id', $this->ids)
            )
            ->orderBy('id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Status',
            'Tags',
            'Labels',
            'Updated At',
        ];
    }

    public function map($article): array
    {
        return [
            $article->id,
            $article->title,
            $article->status,
            $article->tags->pluck('name')->implode(', '),
            $article->labels->pluck('name')->implode(', '),
            $article->updated_at->format('Y-m-d H:i'),
        ];
    }
}
