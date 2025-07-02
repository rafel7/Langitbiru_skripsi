<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminExportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CrosswordController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\WordSearchController;
use App\Http\Controllers\TekaTekiSilangController;
use App\Http\Controllers\FillTheBlankController;
use App\Http\Controllers\PretestController;
use App\Http\Controllers\Pembelajaran1Controller;
use App\Http\Controllers\SidebarController;
use App\Http\Controllers\PosttestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\NilaiGame1Controller;
use App\Http\Controllers\pdfcobaController;


Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::get('/admin/export', [AdminExportController::class, 'export'])->name('admin.export');

Route::get('/sidebar', [SidebarController::class, 'index'])->name('sidebar.index');

Route::get('/pdfcoba', [pdfcobaController::class, 'index']);

//  Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/home', function () {
    return redirect('/dashboard');
});
//  Static pages
Route::view('/about', 'about');
Route::view('/contact', 'contact');

// video
Route::get('/pembelajaran/video1', function () {
    return view('pembelajaran.video1');
})->name('video1');

Route::get('/pembelajaran/video2', function () {
    return view('pembelajaran.video2');
});




// postretst
Route::get('/posttest', function () {
    return view('posttest.form');
})->name('posttest');

//  Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

//  Laravel Auth scaffolding (register, forgot password, dll)
Auth::routes();

//  Dashboard (protected)
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //Sertifikat
    Route::get('/sertifikat/download', [SertifikatController::class, 'download'])->name('sertifikat.download');

    //Profil
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');

    //video
    Route::post('/simpan-waktu-video', [VideoController::class, 'simpanWaktuVideo'])->name('simpan.waktu.video');


    // Crossword
    Route::get('/crossword', [CrosswordController::class, 'index'])->name('crossword.index');
    Route::post('/crossword/check', [CrosswordController::class, 'check'])->name('crossword.check');

    // Word Search
    //Route::get('/wordsearch', [WordSearchController::class, 'index'])->name('wordsearch.index');
    //Route::post('/wordsearch/check', [WordSearchController::class, 'checkWord'])->name('wordsearch.check');

    //game1
    Route::get('/game/wordsearch', [NilaiGame1Controller::class, 'index'])->name('game.wordsearch');
    Route::post('/game/wordsearch/submit', [NilaiGame1Controller::class, 'store'])->name('game.wordsearch.submit');

    //game2
    Route::get('/game/teka-teki-silang', [TekaTekiSilangController::class, 'index'])->name('game.teka-teki-silang');
    Route::post('/game/teka-teki-silang/submit', [TekaTekiSilangController::class, 'submit'])->name('game.teka-teki-silang.submit');
    Route::post('/game/teka-teki-silang/submit2', [TekaTekiSilangController::class, 'submit2'])->name('game.teka-teki-silang.submit2');


    // Fill the Blank
    Route::get('/filltheblank', [FillTheBlankController::class, 'index'])->name('filltheblank.index');
    Route::post('/filltheblank/check', [FillTheBlankController::class, 'checkAnswers'])->name('filltheblank.check');

    // Pretest
    Route::get('/pretest', [PretestController::class, 'showForm'])->name('pretest.form');
    Route::post('/pretest', [PretestController::class, 'submitForm'])->name('pretest.submit');

    // Postetest
    Route::get('/posttest', [PosttestController::class, 'showForm'])->name('posttest.form');
    Route::post('/posttest', [PosttestController::class, 'submitForm'])->name('posttest.submit');

    // Nilai
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');

    // video
    Route::get('/video1', [Pembelajaran1Controller::class, 'index'])->name('pembelajaran1.index');

    //Slide PPT
    Route::get('/slides/{filename}', [SlideController::class, 'show']);
    Route::post('/slides/selesai', [SlideController::class, 'selesai'])->name('slides.selesai');
});
