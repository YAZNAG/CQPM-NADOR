<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\FiliereController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NewsController;
use App\Models\Article;
use App\Models\Document;
use App\Models\Filiere;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

// ─── Public routes ────────────────────────────────────────────────────────────

Route::get('/', function () {
    $documents = Document::latest()->get();
    $settings  = SiteSetting::all_settings();
    $articles  = Article::latest()->take(6)->get();
    $filieres  = Filiere::all();
    return view('home', compact('documents', 'settings', 'articles', 'filieres'));
})->name('home');

Route::get('/news/{article}', [NewsController::class, 'show'])->name('news.show');

Route::get('/candidature', [ApplicationController::class, 'create'])->name('candidature.form');
Route::post('/candidature', [ApplicationController::class, 'store'])->name('candidature.store');
Route::get('/candidature/succes', [ApplicationController::class, 'success'])->name('candidature.success');

// Réclamations & Renseignements
Route::get('/reclamation',  [ComplaintController::class, 'create'])->name('reclamation.form');
Route::post('/reclamation', [ComplaintController::class, 'store'])->name('reclamation.store');

// ─── Admin auth routes ────────────────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('logout',[AdminAuthController::class, 'logout'])->name('logout');
});

// ─── Admin protected routes ───────────────────────────────────────────────────

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Applications
    Route::get('candidatures',                        [AdminController::class, 'applications'])->name('applications.index');
    Route::get('candidatures/liste-admis',            [AdminController::class, 'exportAdmisPdf'])->name('applications.pdf');
    Route::get('candidatures/{application}',          [AdminController::class, 'showApplication'])->name('applications.show');
    Route::patch('candidatures/{application}/status', [AdminController::class, 'updateStatus'])->name('applications.status');
    Route::delete('candidatures/{application}',       [AdminController::class, 'destroyApplication'])->name('applications.destroy');

    // Documents
    Route::get('documents',              [AdminController::class,  'documents'])->name('documents.index');
    Route::post('documents',             [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('documents/{document}',[DocumentController::class, 'destroy'])->name('documents.destroy');

    // Site settings
    Route::get('parametres',  [AdminController::class, 'settings'])->name('settings.index');
    Route::post('parametres', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Articles
    Route::resource('articles', ArticleController::class);

    // Filières de formation
    Route::resource('filieres', FiliereController::class);

    // Réclamations (admin) — static routes must precede {complaint} wildcard
    Route::get('complaints',                             [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('complaints/archived',                    [ComplaintController::class, 'archived'])->name('complaints.archived');
    Route::get('complaints/{complaint}',                 [ComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('complaints/{complaint}/archive',       [ComplaintController::class, 'archive'])->name('complaints.archive');
    Route::patch('complaints/{complaint}/unarchive',     [ComplaintController::class, 'unarchive'])->name('complaints.unarchive');
});
