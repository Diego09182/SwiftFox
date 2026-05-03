<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Article;
use App\Models\Club;
use App\Models\Comment;
use App\Models\File;
use App\Models\Note;
use App\Models\Opinion;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Video;
use App\Models\Work;

use App\Policies\ActivityPolicy;
use App\Policies\ArticlePolicy;
use App\Policies\ClubPolicy;
use App\Policies\CommentPolicy;
use App\Policies\FilePolicy;
use App\Policies\NotePolicy;
use App\Policies\OpinionPolicy;
use App\Policies\PhotoPolicy;
use App\Policies\PostPolicy;
use App\Policies\VideoPolicy;
use App\Policies\WorkPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Activity::class => ActivityPolicy::class,
        Article::class => ArticlePolicy::class,
        Club::class => ClubPolicy::class,
        Comment::class => CommentPolicy::class,
        Note::class => NotePolicy::class,
        Opinion::class => OpinionPolicy::class,
        Video::class => VideoPolicy::class,
        Work::class => WorkPolicy::class,
        Photo::class => PhotoPolicy::class,
        File::class => FilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
