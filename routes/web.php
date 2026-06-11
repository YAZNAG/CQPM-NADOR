<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\FiliereController;
use App\Http\Controllers\Admin\FiliereRequiredDocumentController;
use App\Http\Controllers\Admin\MediaItemController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PageSectionController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FilierePublicController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController as PublicPageController;
use Illuminate\Support\Facades\Route;

// ─── Public routes ────────────────────────────────────────────────────────────

Route::get('/', [PublicPageController::class, 'home'])->name('home');

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// News & Events
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{article:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

// Media / Galerie
Route::get('/media', [MediaController::class, 'index'])->name('media.index');
Route::get('/media/{mediaItem:slug}', [MediaController::class, 'show'])->name('media.show');
Route::get('/galerie', [MediaController::class, 'index'])->name('gallery.index');
Route::get('/galerie/photos', [MediaController::class, 'photos'])->name('gallery.photos');
Route::get('/galerie/videos', [MediaController::class, 'videos'])->name('gallery.videos');
Route::get('/galerie/evenements', [MediaController::class, 'events'])->name('gallery.events');
Route::get('/galerie/visite-virtuelle', [MediaController::class, 'virtual'])->name('gallery.virtual');

// Formations & Filières
Route::get('/formations', [FilierePublicController::class, 'formations'])->name('formations.index');
Route::get('/formations/filieres', [FilierePublicController::class, 'filieres'])->name('formations.filieres');
Route::get('/formations/initiale', [PublicPageController::class, 'staticPage'])->defaults('slug', 'formations-initiale')->name('formations.initiale');
Route::get('/formations/qualification', [PublicPageController::class, 'staticPage'])->defaults('slug', 'formations-qualification')->name('formations.qualification');
Route::get('/formations/specialisation', [PublicPageController::class, 'staticPage'])->defaults('slug', 'formations-specialisation')->name('formations.specialisation');
Route::get('/formations/continue', [PublicPageController::class, 'staticPage'])->defaults('slug', 'formations-continue')->name('formations.continue');
Route::get('/formations/filiere/{filiere:slug}', [FilierePublicController::class, 'show'])->name('formations.filiere.show');

// Admission
Route::get('/admission', [PublicPageController::class, 'staticPage'])->defaults('slug', 'admission')->name('admission.index');
Route::get('/admission/conditions', [PublicPageController::class, 'staticPage'])->defaults('slug', 'admission-conditions')->name('admission.conditions');
Route::get('/admission/pieces', [PublicPageController::class, 'staticPage'])->defaults('slug', 'admission-pieces')->name('admission.pieces');
Route::get('/admission/calendrier', [PublicPageController::class, 'staticPage'])->defaults('slug', 'admission-calendrier')->name('admission.calendrier');
Route::get('/admission/faq', [PublicPageController::class, 'staticPage'])->defaults('slug', 'admission-faq')->name('admission.faq');

// Candidature
Route::get('/candidature', [ApplicationController::class, 'create'])->name('candidature.form');
Route::post('/candidature', [ApplicationController::class, 'store'])->name('candidature.store');
Route::get('/candidature/succes', [ApplicationController::class, 'success'])->name('candidature.success');

// Réclamations & Renseignements
Route::get('/reclamation',  [ComplaintController::class, 'create'])->name('reclamation.form');
Route::post('/reclamation', [ComplaintController::class, 'store'])->name('reclamation.store');
Route::get('/renseignement', [ComplaintController::class, 'create'])->name('renseignement.form');

// Documents
Route::get('/documents', [DocumentController::class, 'public'])->name('documents.index');
Route::get('/documents/avis', [DocumentController::class, 'public'])->name('documents.avis');
Route::get('/documents/resultats', [DocumentController::class, 'public'])->name('documents.resultats');
Route::get('/documents/admis', [DocumentController::class, 'public'])->name('documents.admis');
Route::get('/documents/communiques', [DocumentController::class, 'public'])->name('documents.communiques');
Route::get('/documents/telechargements', [DocumentController::class, 'public'])->name('documents.telechargements');

// Communiqués
Route::get('/communiques', [NewsController::class, 'index'])->name('communiques.index');

// Centre (CMS pages)
Route::get('/centre', [PublicPageController::class, 'staticPage'])->defaults('slug', 'centre')->name('centre.index');

// Contact
Route::get('/contact', [PublicPageController::class, 'staticPage'])->defaults('slug', 'contact')->name('contact.index');
Route::get('/contact/localisation', [PublicPageController::class, 'staticPage'])->defaults('slug', 'contact-localisation')->name('contact.localisation');

// Dynamic CMS page catch-all (must be LAST)
Route::get('/{page:slug}', [PublicPageController::class, 'show'])->name('pages.show');

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
    Route::patch('candidatures/{application}/observation', [AdminController::class, 'updateObservation'])->name('applications.observation');
    Route::delete('candidatures/{application}',       [AdminController::class, 'destroyApplication'])->name('applications.destroy');

    // Documents
    Route::get('documents',              [AdminController::class,  'documents'])->name('documents.index');
    Route::post('documents',             [DocumentController::class, 'store'])->name('documents.store');
    Route::delete('documents/{document}',[DocumentController::class, 'destroy'])->name('documents.destroy');

    // Application uploaded documents (view/download)
    Route::get('candidatures/{application}/documents/{document}/download', [AdminController::class, 'downloadDocument'])->name('applications.document.download');

    // Site settings
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::post('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::get('parametres', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::post('parametres', [SiteSettingController::class, 'update'])->name('settings.update');

    // Menus
    Route::patch('menus/order', [MenuController::class, 'updateOrder'])->name('menus.order');
    Route::patch('menus/{menu}/toggle', [MenuController::class, 'toggle'])->name('menus.toggle');
    Route::resource('menus', MenuController::class)->except('show');

    // CMS pages and sections
    Route::get('sections', [PageSectionController::class, 'all'])->name('sections.index');
    Route::patch('pages/{page}/sections/order', [PageSectionController::class, 'updateOrder'])->name('pages.sections.order');
    Route::patch('pages/{page}/sections/{section}/toggle', [PageSectionController::class, 'toggle'])->name('pages.sections.toggle');
    Route::resource('pages.sections', PageSectionController::class)->except('show');
    Route::resource('pages', AdminPageController::class)->except('show');

    // News, events and media gallery
    Route::resource('news', ArticleController::class)->parameters(['news' => 'article'])->names('news')->except('show');
    Route::resource('events', AdminEventController::class)->names('events')->except('show');
    Route::resource('media', MediaItemController::class)->parameters(['media' => 'mediaItem'])->names('media')->except('show');
    Route::resource('articles', ArticleController::class)->parameters(['articles' => 'article'])->except('show');

    // Filières de formation
    Route::get('filieres/{filiere}/documents', [FiliereRequiredDocumentController::class, 'index'])->name('filieres.documents.index');
    Route::post('filieres/{filiere}/documents', [FiliereRequiredDocumentController::class, 'store'])->name('filieres.documents.store');
    Route::delete('filieres/{filiere}/documents/{document}', [FiliereRequiredDocumentController::class, 'destroy'])->name('filieres.documents.destroy');
    Route::patch('filieres/{filiere}/documents/{document}', [FiliereRequiredDocumentController::class, 'update'])->name('filieres.documents.update');
    Route::get('filieres/{filiere}/show', [FiliereController::class, 'show'])->name('filieres.show');
    Route::resource('filieres', FiliereController::class)->except('show');

    // Réclamations (admin) — static routes must precede {complaint} wildcard
    Route::get('complaints',                             [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('complaints/archived',                    [ComplaintController::class, 'archived'])->name('complaints.archived');
    Route::get('complaints/{complaint}',                 [ComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('complaints/{complaint}/archive',       [ComplaintController::class, 'archive'])->name('complaints.archive');
    Route::patch('complaints/{complaint}/unarchive',     [ComplaintController::class, 'unarchive'])->name('complaints.unarchive');
});
