<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\ProjectObserver;
use App\Observers\TaskObserver;
use App\Models\Project;
use App\Models\Task;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Project::observe(ProjectObserver::class);
        Task::observe(TaskObserver::class);
    }
}
