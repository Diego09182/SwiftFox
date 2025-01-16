<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Club;
use App\Models\Comment;
use App\Models\Note;
use App\Models\Opinion;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Video;
use App\Models\Work;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('delete-post', function ($user, Post $post) {
            return $user->id === $post->user_id || $user->administration == 5;
        });

        Gate::define('delete-activity', function ($user, Activity $activity) {
            return $activity->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-article', function ($user, Article $article) {
            return $article->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-club', function ($user, Club $club) {
            return $club->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-comment', function ($user, Comment $comment) {
            return $comment->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-note', function ($user, Note $note) {
            return $note->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-opinion', function ($user, Opinion $opinion) {
            return $opinion->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-video', function ($user, Video $video) {
            return $video->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-work', function ($user, Work $work) {
            return $work->user_id == $user->id || $user->administration == 5;
        });

        Gate::define('delete-photo', function ($user, Photo $photo) {
            return $photo->user_id == $user->id || $user->administration == 5;
        });
    }
}
