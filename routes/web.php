<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\PrizeRedemptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

// 首頁
Route::get('/', fn () => view('welcome'));

// 登入/註冊頁面
Route::middleware('check.login')->group(function () {
    Route::view('/registration', 'swiftfox.registration')->name('welcome');
    Route::view('/welcome', 'swiftfox.welcome')->name('introduction');
});

// 登入/註冊
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// 身分驗證的路由群組
Route::middleware(['auth', 'user.data'])->group(function () {

    // 登出、首頁
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/main', [MainController::class, 'index'])->name('main');

    // 通知系統
    Route::controller(NotificationController::class)
        ->prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/read', 'readAll')->name('readAll');
        });

    // 管理後台
    Route::controller(ManagementController::class)
        ->prefix('management')->name('management.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/users', 'users')->name('users');
            Route::put('/users/{user}', 'update')->name('update');
            Route::get('/posts', 'posts')->name('posts');
            Route::get('/articles', 'articles')->name('articles');
            Route::get('/reports', 'reports')->name('reports');
            Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('report.destroy');
            Route::get('/works', 'works')->name('works');
            Route::get('/clubs', 'clubs')->name('clubs');
            Route::get('/opinions', 'opinions')->name('opinions');
            Route::get('/videos', 'videos')->name('videos');
            Route::get('/files', 'files')->name('files');
            Route::get('/prizes', 'prizes')->name('prizes');
            Route::get('/prizeRedemptions', 'prizeRedemptions')->name('prizeRedemptions');
        });

    // 公告
    Route::post('/management/bulletin', [BulletinController::class, 'store'])->name('bulletin.store');

    // 論壇系統
    Route::controller(PostController::class)
        ->prefix('forum')->name('forum.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/search', 'search')->name('search');
            Route::get('/filter', 'filter')->name('filter');
            Route::get('/posts/{post}/comment', 'show')->name('show');
            Route::get('/post', 'create')->name('create');
            Route::post('/post', 'store')->name('store');
            Route::delete('/posts/{post}', 'destroy')->name('destroy');
            Route::post('/posts/{post}/like', 'like')->name('like');
            Route::post('/posts/{post}/dislike', 'dislike')->name('dislike');
        });

    Route::controller(CommentController::class)->group(function () {
        Route::post('/forum/posts/{post}/comments', 'store')->name('comment.store');
        Route::delete('/forum/posts/{post}/comments/{comment}', 'destroy')->name('comment.destroy');
    });
    Route::controller(ReportController::class)->group(function () {
        Route::post('/forum/posts/{post}/report', 'store')->name('report.store');
    });

    // 個人資訊系統
    Route::controller(ProfileController::class)
        ->prefix('profile')->name('profile.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/redemptions', 'redemptions')->name('redemptions');
            Route::put('/', 'update')->name('update');
        });

    // 日記系統
    Route::controller(NoteController::class)->group(function () {
        Route::get('/home', 'index')->name('home.index');
        Route::get('/home/notes/{note}', 'show')->name('note.show');
        Route::get('/home/notes', 'create')->name('note.create');
        Route::post('/home/note', 'store')->name('note.store');
        Route::delete('/home/notes/{note}', 'destroy')->name('note.destroy');
    });

    Route::controller(HomeController::class)
        ->prefix('home')->name('home.')->group(function () {
            Route::get('/posts', 'posts')->name('posts');
            Route::get('/articles', 'articles')->name('articles');
            Route::get('/works', 'works')->name('works');
            Route::get('/opinions', 'opinions')->name('opinions');
            Route::get('/videos', 'videos')->name('videos');
            Route::get('/files', 'files')->name('files');
        });

    // 投票系統
    Route::controller(OpinionController::class)
        ->prefix('opinions')->name('opinion.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{opinion}', 'show')->name('show');
            Route::post('/{opinion}/agree', 'agree')->name('agree');
            Route::post('/{opinion}/disagree', 'disagree')->name('disagree');
        });
    Route::controller(OpinionController::class)->group(function () {
        Route::get('/opinion', 'create')->name('opinion.create');
        Route::post('/opinion', 'store')->name('opinion.store');
        Route::delete('/opinions/{opinion}', 'destroy')->name('opinion.destroy');
    });

    // 文章系統
    Route::controller(ArticleController::class)
        ->prefix('articles')->name('article.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/search', 'search')->name('search');
            Route::get('/{article}', 'show')->name('show');
        });
    Route::controller(ArticleController::class)->group(function () {
        Route::get('/article', 'create')->name('article.create');
        Route::post('/article', 'store')->name('article.store');
        Route::delete('/articles/{article}', 'destroy')->name('article.destroy');
    });

    // 社團系統
    Route::controller(ClubController::class)
        ->prefix('clubs')->name('club.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/{club}', 'destroy')->name('destroy');
        });

    // 活動系統
    Route::controller(ActivityController::class)
        ->prefix('activities')->name('activity.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::delete('/{activity}', 'destroy')->name('destroy');
        });

    // 作品系統
    Route::controller(WorkController::class)
        ->prefix('works')->name('work.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{work}/photo', 'show')->name('show');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::delete('/{work}', 'destroy')->name('destroy');
        });
    Route::controller(PhotoController::class)
        ->prefix('works/{work}/photos')->name('photo.')->group(function () {
            Route::get('/', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{photo}', 'show')->name('show');
            Route::delete('/{photo}', 'destroy')->name('destroy');
        });

    // 影片系統
    Route::controller(VideoController::class)
        ->prefix('videos')->name('video.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{video}', 'show')->name('show');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::delete('/{video}', 'destroy')->name('destroy');
        });

    // 檔案系統
    Route::controller(FileController::class)
        ->prefix('files')->name('file.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{file}', 'show')->name('show');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::delete('/{file}', 'destroy')->name('destroy');
            Route::post('/{file}/like', 'like')->name('like');
            Route::post('/{file}/dislike', 'dislike')->name('dislike');
        });

    // 獎品兌換系統
    Route::controller(PrizeRedemptionController::class)
        ->prefix('prize-redemptions')->name('redemptions.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{redemption}', 'update')->name('update');
            Route::delete('/{redemption}', 'destroy')->name('destroy');
            Route::patch('/{redemption}/status', 'updateStatus')->name('updateStatus');
        });

    // 獎品系統
    Route::controller(PrizeController::class)
        ->prefix('prizes')->name('prize.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::put('/{prize}', 'update')->name('update');
            Route::delete('/{prize}', 'destroy')->name('destroy');
            Route::post('/{prize}/redeem', [PrizeRedemptionController::class, 'redeem'])->name('redeem');
        });
});
