<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use OpenAI\Client;
use OpenAI;
class OpenAIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            $apiKey = env('OPENAI_API_KEY');

            if (!$apiKey) {
                throw new \Exception('OPENAI_API_KEY is not set in the .env file.');
            }

            return OpenAI::client($apiKey);
        });
    }
}

