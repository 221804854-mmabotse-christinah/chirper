<?php

namespace App\Providers;

use App\Models\Chirp;
use App\Policies\ChirpPolicy;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Chirp::class => ChirpPolicy::class,
        Comment::class => CommentPolicy::class,
    ];
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
    
}
