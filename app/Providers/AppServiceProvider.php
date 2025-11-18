<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Team;
use App\Models\Organisation;
use App\Models\Ministry;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define admin gate
        Gate::define('manage-admin', function ($user) {
            return $user->hasRole([1]);
        });

        // Share common models globally in all views
        View::composer('*', function ($view) {
            $team = null;
            $organisation = null;
            $ministry = null;



            if (auth()->check()) {
                $team = Team::where('user_id', auth()->id())->first();

                if ($team) {
                    $organisation = Organisation::find($team->organisation_id);
                    $ministry     = Ministry::find($team->ministry_id);

                }
            }

            $view->with([
                'team'         => $team,
                'organisation' => $organisation,
                'ministry'     => $ministry,



            ]);
        });
    }
}
