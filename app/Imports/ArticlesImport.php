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
        // 1. Title नसेल तर स्किप करा
        if (empty($row['title'])) {
            return null;
        }

        // 2. Article तयार करा
        $article = Article::updateOrCreate(
            ['title' => $row['title']],
            [
                'slug'   => Str::slug($row['title']),
                'status' => $row['status'] ?? 'Draft',
                'is_favourite' => false,
                'author_id' => Auth::id() ?? 1,
            ]
        );

        // ---------------------------------------------------------
        // ✅ MAIN FIX: Excel Text -> Editor.js Block Format
        // ---------------------------------------------------------
        
        $contentFromExcel = $row['content'] ?? '';

        // एडिटरला लागणारा JSON साचा
        $editorJsData = [
            'time' => now()->getTimestamp() * 1000, // Current timestamp in ms
            'blocks' => [
                [
                    'id' => Str::random(10), // प्रत्येक ब्लॉकला युनिक ID लागतो
                    'type' => 'paragraph',
                    'data' => [
                        'text' => $contentFromExcel // इथे आपला डेटा जाईल
                    ]
                ]
            ],
            'version' => '2.29.1' // Editor.js version
        ];

        // ---------------------------------------------------------

        // 3. Version तयार करा (Convert Array to JSON automatically if cast exists)
        $version = ArticleVersion::create([
            'article_id'   => $article->id,
            'version'      => 1.0,
            'editor_id'    => Auth::id() ?? 1,
            
            // इथे आपण तयार केलेला ब्लॉक फॉरमॅट पास करत आहोत
            'content'      => $editorJsData, 
            
            'status'       => $article->status,
            'published_at' => (strtolower($row['status'] ?? '') === 'published') ? now() : null,
        ]);

        // 4. Article अपडेट करा
        $article->update(['current_version_id' => $version->id]);

        return $article;
    }
}