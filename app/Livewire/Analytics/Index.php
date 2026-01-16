<?php

namespace App\Livewire\Analytics;

use Livewire\Component;
use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Index extends Component
{
    private function getGraphData()
    {
        $labels = [];
        $views = [];
        $reads = [];
        $likes = [];
        $dislikes = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('d M');
            $dateStr = $date->format('Y-m-d');

            $views[] = ArticleView::whereDate('viewed_at', $dateStr)->count();

            $reads[] = ArticleView::whereDate('viewed_at', $dateStr)
                ->where('duration_seconds', '>=', 30)->count();

            try {
                $likes[] = DB::table('article_likes')
                    ->whereDate('created_at', $dateStr)->count();
            } catch (\Exception $e) {
                $likes[] = 0;
            }

            try {
                $dislikes[] = DB::table('article_feedback')
                    ->whereDate('created_at', $dateStr)
                    ->where('is_helpful', 0)
                    ->count();
            } catch (\Exception $e) {
                $dislikes[] = 0;
            }
        }

        return [
            'labels'   => $labels,
            'views'    => $views,
            'reads'    => $reads,
            'likes'    => $likes,
            'dislikes' => $dislikes
        ];
    }

    public function render()
    {
        $totalArticles = Article::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $totalViews = ArticleView::count();
        $totalReads = ArticleView::where('duration_seconds', '>=', 30)->count();

        try {
            $totalLikes = DB::table('article_likes')->count();
        } catch (\Exception $e) {
            $totalLikes = 0;
        }

        $topArticles = Article::withCount(['views', 'likes'])
            ->orderByDesc('views_count')
            ->limit(5)
            ->get();

        $mostReadArticles = Article::withSum('views as total_duration', 'duration_seconds')
            ->orderByDesc('total_duration')
            ->limit(5)
            ->get();

        $maxDuration = $mostReadArticles->max('total_duration') ?? 1;
        if ($maxDuration == 0) $maxDuration = 1;

        $topLocations = [
            [
                'country' => 'India',
                'views' => round($totalViews * 0.85),
                'flag' => '🇮🇳',
                'width' => '85%'
            ],
            [
                'country' => 'United States',
                'views' => round($totalViews * 0.05),
                'flag' => '🇺🇸',
                'width' => '5%'
            ],
            [
                'country' => 'United Kingdom',
                'views' => round($totalViews * 0.04),
                'flag' => '🇬🇧',
                'width' => '4%'
            ],
            [
                'country' => 'UAE',
                'views' => round($totalViews * 0.03),
                'flag' => '🇦🇪',
                'width' => '3%'
            ],
            [
                'country' => 'Others',
                'views' => round($totalViews * 0.03),
                'flag' => '🌍',
                'width' => '3%'
            ],
        ];

       $topCategories = DB::table('categories')
    // Join 1: categories.category_id वापरा (id नाही)
    ->join('article', 'categories.category_id', '=', 'article.category_id')
    
    // Join 2: Article Views सोबत
    ->join('article_views', 'article.id', '=', 'article_views.article_id')
    
    // Select: category_name वापरा
    ->select('categories.category_name', DB::raw('COUNT(article_views.id) as total_views'))
    
    // Group By: category_id आणि category_name नुसार
    ->groupBy('categories.category_id', 'categories.category_name')
    
    ->orderByDesc('total_views')
    ->limit(5)
    ->get();

        $graphData = $this->getGraphData();

        return view('livewire.analytics.index', [
            'totalArticles'     => $totalArticles,
            'publishedArticles' => $publishedArticles,
            'totalViews'        => $totalViews,
            'totalReads'        => $totalReads,
            'totalLikes'        => $totalLikes,
            'topArticles'       => $topArticles,
            'mostReadArticles'  => $mostReadArticles,
            'maxDuration'       => $maxDuration,
            'topLocations'      => $topLocations,
            'topCategories'     => $topCategories,
            'chartData'         => $graphData,
        ]);
    }
}