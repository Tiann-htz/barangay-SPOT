<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Announcement;
use App\Models\ChatMessage;
use App\Policies\PostPolicy;
use App\Policies\CommentPolicy;
use App\Policies\AnnouncementPolicy;
use App\Policies\ChatMessagePolicy;
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
        // Register policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
        Gate::policy(Announcement::class, AnnouncementPolicy::class);
        Gate::policy(ChatMessage::class, ChatMessagePolicy::class);
        
        // Define the admin-access gate
        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin';
        });
    }
}