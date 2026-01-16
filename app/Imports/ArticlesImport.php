<?php

namespace App\Imports;

use App\Models\Article;
use App\Models\ArticleVersion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticlesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        
        if (empty($row['title'])) {
            return null;
        }

        
        $article = Article::updateOrCreate(
            ['title' => $row['title']],
            [
                'slug'   => Str::slug($row['title']),
                'status' => $row['status'] ?? 'Draft',
                'is_favourite' => false,
                'author_id' => Auth::id() ?? 1,
            ]
        );
        
        $contentFromExcel = $row['content'] ?? '';

        
        $editorJsData = [
            'time' => now()->getTimestamp() * 1000, 
            'blocks' => [
                [
                    'id' => Str::random(10), 
                    'type' => 'paragraph',
                    'data' => [
                        'text' => $contentFromExcel 
                    ]
                ]
            ],
            'version' => '2.29.1' 
        ];
       
        $version = ArticleVersion::create([
            'article_id'   => $article->id,
            'version'      => 1.0,
            'editor_id'    => Auth::id() ?? 1,
            
            
            'content'      => $editorJsData, 
            
            'status'       => $article->status,
            'published_at' => (strtolower($row['status'] ?? '') === 'published') ? now() : null,
        ]);

       
        $article->update(['current_version_id' => $version->id]);

        return $article;
    }
}