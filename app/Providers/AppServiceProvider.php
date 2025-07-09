<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Thread;
use App\Policies\CommentPolicy;
use App\Policies\ThreadPolicy;
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
        //
    }

    protected $policies = [
        Thread::class => ThreadPolicy::class,
        Comment::class => CommentPolicy::class,
    ];
}
