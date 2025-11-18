<?php

namespace App\Services;

use OpenAI\Client;
use Illuminate\Support\Facades\Cache;

class OpenAISpaceService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        // The Laravel service container automatically injects the configured OpenAI client
        $this->client = $client;
    }

    /**
     * Calls the AI to get a quality score for a Space based on its name and slug.
     */
    public function getHealthScore(string $name, string $slug): int
    {
        // Use Caching to avoid repeated API calls for the same data (and save money)
        $cacheKey = 'ai_score_' . md5($name . $slug);

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($name, $slug) {

            // Define the instruction prompt for the model
            $prompt = "Analyze the space name '{$name}' and slug '{$slug}'. Rate the combination based on descriptive quality and SEO-friendliness from 0 to 100. Output ONLY the integer score.";

            try {
                $response = $this->client->chat()->create([
                    'model' => 'gpt-3.5-turbo', // Cost-effective model for scoring
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt],
                    ],
                ]);

                // Extract and clean the integer score from the response text
                $score = trim($response->choices[0]->message->content);
                return (int)filter_var($score, FILTER_SANITIZE_NUMBER_INT);

            } catch (\Exception $e) {
                // Log the error and return a safe default score if the API fails
                \Log::error('OpenAI API Error: ' . $e->getMessage());
                return 50; // Neutral default score
            }
        });
    }
    public function generateWikiArticle(string $title, string $context): string
    {
        $prompt = "Generate a comprehensive, professional, and well-structured Wiki article for a title: '{$title}'.
        Use markdown for formatting (headings, bullet points).
        The article should be approximately 400-600 words long.
        Context for the article: {$context}.";

        try {
            $response = $this->client->chat()->create([
                'model' => 'gpt-4o', // Use a more capable model for better article quality
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            return trim($response->choices[0]->message->content);

        } catch (\Exception $e) {
            \Log::error('OpenAI Wiki Generation Error: ' . $e->getMessage());

            return "Wiki article could not be generated for '{$title}' due to an API error. Please enter content manually.";
        }
    }
}
