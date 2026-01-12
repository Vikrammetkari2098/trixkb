<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackManagerController extends Controller
{
    public function index(Request $request)
    {
        $viewMode = $request->query('viewMode', 'articles');

        $articles = [
            ['title' => 'Article 1', 'content' => 'Content of Article 1'],
            ['title' => 'Article 2', 'content' => 'Content of Article 2'],
        ];

        $eddyAIContent = "Eddy AI संबंधित फीडबॅक कंटेंट.";

        return view('feedback.index', compact('articles', 'eddyAIContent', 'viewMode'));
    }
}
