<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Thread;
use App\Policies\CategoryPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        foreach ($this->policies() as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    public function policies()
    {
        return [
            Thread::class => ThreadPolicy::class,
            Comment::class => CommentPolicy::class,
            Category::class => CategoryPolicy::class,
        ];
    }
}
