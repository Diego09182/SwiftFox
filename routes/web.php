<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Laravel版本
Route::get('/', function () {
    return view('welcome');
});

// 註冊與登入頁面
Route::get('/registration', function () {
    return view('swiftfox.registration');
})->name('welcome')->middleware('check.login');

// 歡迎頁面
Route::get('/welcome', function () {
    return view('swiftfox.welcome');
})->name('introduction')->middleware('check.login');

// 登入
Route::post('/login', [AuthController::class, 'login'])->name('login');
// 註冊
Route::post('/register', [AuthController::class, 'register'])->name('register');

    // 身分驗證
    Route::middleware(['auth', 'user.data'])->group(function () {

        // 登出
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        // 首頁
        Route::get('/main', [MainController::class, 'index'])->name('main');

        // 管理後臺
        Route::get('/management', [ManagementController::class, 'index'])->name('management.index');
        // 公布更新
        Route::post('/management/bulletin', [BulletinController::class, 'store'])->name('bulletin.store');
        // 刪除檢舉
        Route::delete('/management/reports/{report}', [ReportController::class, 'destroy'])->name('report.destroy');
        // 使用者權限更新
        Route::put('/management/users/{user}', [ManagementController::class, 'update'])->name('management.update');
        // 使用者管理
        Route::get('/management/users', [ManagementController::class, 'user'])->name('management.users');
        // 貼文管理
        Route::get('/management/posts', [ManagementController::class, 'posts'])->name('management.posts');
        // 文章管理
        Route::get('/management/articles', [ManagementController::class, 'articles'])->name('management.articles');
        // 檢舉管理
        Route::get('/management/reports', [ManagementController::class, 'reports'])->name('management.reports');
        // 作品管理
        Route::get('/management/works', [ManagementController::class, 'works'])->name('management.works');
        // 社團管理
        Route::get('/management/clubs', [ManagementController::class, 'clubs'])->name('management.clubs');
        // 投票管理
        Route::get('/management/opinions', [ManagementController::class, 'opinions'])->name('management.opinions');
        // 影片管理
        Route::get('/management/videos', [ManagementController::class, 'videos'])->name('management.videos');
        // 檔案管理
        Route::get('/management/files', [ManagementController::class, 'files'])->name('management.files');

        // 論壇系統
        //搜尋貼文
        Route::get('/forum/search', [PostController::class, 'search'])->name('forum.search');
        //篩選貼文
        Route::get('/forum/filter', [PostController::class, 'filter'])->name('forum.filter');
        // 認同貼文
        Route::post('/forum/posts/{post}/like', [PostController::class, 'like'])->name('forum.like');
        // 不認同貼文
        Route::post('/forum/posts/{post}/dislike', [PostController::class, 'dislike'])->name('forum.dislike');
        // 顯示所有貼文
        Route::get('/forum', [PostController::class, 'index'])->name('forum.index');
        // 顯示單個貼文
        Route::get('/forum/posts/{post}/comment', [PostController::class, 'show'])->name('forum.show');
        // 發布貼文頁面
        Route::get('/forum/post', [PostController::class, 'create'])->name('forum.create');
        // 發布貼文
        Route::post('/forum/post', [PostController::class, 'store'])->name('forum.store');
        // 刪除貼文
        Route::delete('/forum/posts/{post}', [PostController::class, 'destroy'])->name('forum.destroy');
        // 發布評論
        Route::post('/forum/posts/{post}/comments', [CommentController::class, 'store'])->name('comment.store');
        // 刪除評論
        Route::delete('/forum/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
        // 發布檢舉
        Route::post('/forum/posts/{post}/report', [ReportController::class, 'store'])->name('report.store');

        // 個人系統
        // 個人資訊
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        // 個人資訊更新
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // 顯示所有日記
        Route::get('/home', [NoteController::class, 'index'])->name('home.index');
        // 顯示單個日記
        Route::get('/home/notes/{note}', [NoteController::class, 'show'])->name('note.show');
        // 發布日記
        Route::post('/home/note', [NoteController::class, 'store'])->name('note.store');
        // 刪除日記
        Route::delete('/home/notes/{note}', [NoteController::class, 'destroy'])->name('note.destroy');

        // 投票系統
        // 認同投票
        Route::post('/opinions/{opinion}/agree', [OpinionController::class, 'agree'])->name('opinion.agree');
        // 不認同投票
        Route::post('/opinions/{opinion}/disagree', [OpinionController::class, 'disagree'])->name('opinion.disagree');
        // 顯示所有投票
        Route::get('/opinions', [OpinionController::class, 'index'])->name('opinion.index');
        // 發布投票頁面
        Route::get('/opinion', [OpinionController::class, 'create'])->name('opinion.create');
        // 顯示單個投票
        Route::get('/opinions/{opinion}', [OpinionController::class, 'show'])->name('opinion.show');
        // 發布投票
        Route::post('/opinion', [OpinionController::class, 'store'])->name('opinion.store');
        // 刪除投票
        Route::delete('/opinions/{opinion}', [OpinionController::class, 'destroy'])->name('opinion.destroy');

        // 文章系統
        //搜尋文章
        Route::get('/articles/search', [ArticleController::class, 'search'])->name('article.search');
        // 顯示所有文章
        Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
        // 顯示單個文章
        Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article.show');
        // 發布文章頁面
        Route::get('/article', [ArticleController::class, 'create'])->name('article.create');
        // 發布文章
        Route::post('/article', [ArticleController::class, 'store'])->name('article.store');
        // 刪除文章
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('article.destroy');

        // 社團系統
        // 顯示所有社團
        Route::get('/clubs', [ClubController::class, 'index'])->name('club.index');
        // 發布社團
        Route::post('/club', [ClubController::class, 'store'])->name('club.store');
        // 刪除社團
        Route::delete('/clubs/{club}', [ClubController::class, 'destroy'])->name('club.destroy');

        // 活動系統
        // 顯示所有活動
        Route::get('/activities', [ActivityController::class, 'index'])->name('activity.index');
        // 發布活動
        Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
        // 刪除活動
        Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activity.destroy');

        // 檔案系統
        // 顯示所有作品
        Route::get('/works', [WorkController::class, 'index'])->name('work.index');
        // 顯示單個作品
        Route::get('/works/{work}/photo', [WorkController::class, 'show'])->name('work.show');
        // 發布作品
        Route::post('/work', [WorkController::class, 'store'])->name('work.store');
        // 發布作品頁面
        Route::get('/work', [WorkController::class, 'create'])->name('work.create');
        // 刪除作品
        Route::delete('/works/{work}', [WorkController::class, 'destroy'])->name('work.destroy');
        // 發布相片頁面
        Route::get('/works/{work}/photos', [PhotoController::class, 'create'])->name('photo.create');
        // 發布相片
        Route::post('/works/{work}/photo', [PhotoController::class, 'store'])->name('photo.store');
        // 顯示單個照片
        Route::get('/works/{work}/photo/{photo}', [PhotoController::class, 'show'])->name('photo.show');
        // 刪除相片
        Route::delete('/works/{work}/photo/{photo}', [PhotoController::class, 'destroy'])->name('photo.destroy');

        // 顯示所有影片
        Route::get('/videos', [VideoController::class, 'index'])->name('video.index');
        // 顯示單個影片
        Route::get('/videos/{video}', [VideoController::class, 'show'])->name('video.show');
        // 發布影片
        Route::post('/video', [VideoController::class, 'store'])->name('video.store');
        // 發布影片頁面
        Route::get('/video', [VideoController::class, 'create'])->name('video.create');
        // 刪除影片
        Route::delete('/videos/{video}', [VideoController::class, 'destroy'])->name('video.destroy');

        // 顯示所有檔案
        Route::get('/files', [FileController::class, 'index'])->name('file.index');
        // 顯示單個檔案
        Route::get('/files/{file}', [FileController::class, 'show'])->name('file.show');
        // 發布檔案
        Route::post('/file', [FileController::class, 'store'])->name('file.store');
        // 發布檔案頁面
        Route::get('/file', [FileController::class, 'create'])->name('file.create');
        // 刪除檔案
        Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('file.destroy');
        // 認同檔案
        Route::post('/files/{file}/like', [FileController::class, 'like'])->name('file.like');
        // 不認同檔案
        Route::post('/files/{file}/dislike', [FileController::class, 'dislike'])->name('file.dislike');

    });
