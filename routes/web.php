<?php

use App\Http\Controllers\RadioController;
use App\Http\Controllers\HutbeController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// ── Frontend ──────────────────────────────────────────────
Route::get('/', [RadioController::class, 'index'])->name('home');
Route::get('/now-playing', [RadioController::class, 'nowPlaying'])->name('now-playing');
Route::post('/istek', [RadioController::class, 'requestStore'])->name('request.store');

// Hutbeler
Route::prefix('hutbeler')->name('hutbe.')->group(function () {
    Route::get('/', [HutbeController::class, 'index'])->name('index');
    Route::get('/{hutbe}', [HutbeController::class, 'show'])->name('show');
    Route::get('/{hutbe}/indir/{type}', [HutbeController::class, 'download'])->name('download');
});

// Başkan & Duyurular (KKTC + Evkaf birleşik)
Route::prefix('duyurular')->name('announcements.')->group(function () {
    Route::get('/', [AnnouncementController::class, 'index'])->name('index');
    Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
});

// Editör
Route::prefix('editor')->name('editor.')->group(function () {
    Route::get('/', [EditorController::class, 'index'])->name('index');
    Route::get('/{editorPost}', [EditorController::class, 'show'])->name('show');
});

// Statik Sayfalar
Route::get('/sayfa/{slug}', [PageController::class, 'show'])->name('page.show');

// İletişim
Route::get('/iletisim', [ContactController::class, 'index'])->name('contact.index');
Route::post('/iletisim', [ContactController::class, 'send'])->name('contact.send');

// ── Admin Auth ────────────────────────────────────────────
Route::get('/admin/login', [Admin\AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [Admin\AuthController::class, 'logout'])->name('admin.logout');

// ── Admin Panel ───────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // İstekler
    Route::prefix('istekler')->name('requests.')->group(function () {
        Route::get('/', [Admin\RequestController::class, 'index'])->name('index');
        Route::patch('/{songRequest}/status/{status}', [Admin\RequestController::class, 'updateStatus'])->name('status');
        Route::delete('/{songRequest}', [Admin\RequestController::class, 'destroy'])->name('destroy');
    });

    // Parça Geçmişi
    Route::prefix('gecmis')->name('history.')->group(function () {
        Route::get('/', [Admin\HistoryController::class, 'index'])->name('index');
        Route::delete('/{songHistory}', [Admin\HistoryController::class, 'destroy'])->name('destroy');
    });

    // Hutbeler
    Route::prefix('hutbeler')->name('hutbe.')->group(function () {
        Route::get('/', [Admin\HutbeController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\HutbeController::class, 'create'])->name('create');
        Route::post('/', [Admin\HutbeController::class, 'store'])->name('store');
        Route::get('/{hutbe}/duzenle', [Admin\HutbeController::class, 'edit'])->name('edit');
        Route::put('/{hutbe}', [Admin\HutbeController::class, 'update'])->name('update');
        Route::delete('/{hutbe}', [Admin\HutbeController::class, 'destroy'])->name('destroy');
        Route::post('/cek', [Admin\HutbeController::class, 'scrape'])->name('scrape');
    });

    // Duyurular (KKTC + Evkaf + Manuel)
    Route::prefix('duyurular')->name('announcements.')->group(function () {
        Route::get('/', [Admin\AnnouncementController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\AnnouncementController::class, 'create'])->name('create');
        Route::post('/', [Admin\AnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}/duzenle', [Admin\AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/{announcement}', [Admin\AnnouncementController::class, 'update'])->name('update');
        Route::delete('/{announcement}', [Admin\AnnouncementController::class, 'destroy'])->name('destroy');
        Route::post('/cek-kktc', [Admin\AnnouncementController::class, 'scrapeKktc'])->name('scrape-kktc');
        Route::post('/cek-evkaf', [Admin\AnnouncementController::class, 'scrapeEvkaf'])->name('scrape-evkaf');
    });

    // Editör Yazıları
    Route::prefix('editor')->name('editor.')->group(function () {
        Route::get('/', [Admin\EditorPostController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\EditorPostController::class, 'create'])->name('create');
        Route::post('/', [Admin\EditorPostController::class, 'store'])->name('store');
        Route::get('/{editorPost}/duzenle', [Admin\EditorPostController::class, 'edit'])->name('edit');
        Route::put('/{editorPost}', [Admin\EditorPostController::class, 'update'])->name('update');
        Route::delete('/{editorPost}', [Admin\EditorPostController::class, 'destroy'])->name('destroy');
    });

    // Ezan Vakitleri
    Route::prefix('ezan-vakitleri')->name('prayer-times.')->group(function () {
        Route::get('/', [Admin\PrayerTimeController::class, 'index'])->name('index');
        Route::post('/manuel', [Admin\PrayerTimeController::class, 'storeManual'])->name('store');
        Route::get('/{prayerTime}/duzenle', [Admin\PrayerTimeController::class, 'edit'])->name('edit');
        Route::put('/{prayerTime}', [Admin\PrayerTimeController::class, 'update'])->name('update');
        Route::post('/api-cek', [Admin\PrayerTimeController::class, 'fetchToday'])->name('fetch');
        Route::delete('/{prayerTime}', [Admin\PrayerTimeController::class, 'destroy'])->name('destroy');
    });

    // Günlük İçerik
    Route::prefix('gunluk-icerik')->name('daily-content.')->group(function () {
        Route::get('/', [Admin\DailyContentController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\DailyContentController::class, 'create'])->name('create');
        Route::post('/', [Admin\DailyContentController::class, 'store'])->name('store');
        Route::get('/{dailyContent}/duzenle', [Admin\DailyContentController::class, 'edit'])->name('edit');
        Route::put('/{dailyContent}', [Admin\DailyContentController::class, 'update'])->name('update');
        Route::post('/{dailyContent}/yayinla', [Admin\DailyContentController::class, 'togglePublish'])->name('toggle');
        Route::post('/api-cek', [Admin\DailyContentController::class, 'fetchToday'])->name('fetch');
        Route::delete('/{dailyContent}', [Admin\DailyContentController::class, 'destroy'])->name('destroy');
    });

    // Menü Yönetimi
    Route::prefix('menu')->name('nav.')->group(function () {
        Route::get('/', [Admin\NavItemController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\NavItemController::class, 'create'])->name('create');
        Route::post('/', [Admin\NavItemController::class, 'store'])->name('store');
        Route::get('/{navItem}/duzenle', [Admin\NavItemController::class, 'edit'])->name('edit');
        Route::put('/{navItem}', [Admin\NavItemController::class, 'update'])->name('update');
        Route::delete('/{navItem}', [Admin\NavItemController::class, 'destroy'])->name('destroy');
    });

    // SEO Ayarları
    Route::prefix('seo')->name('seo.')->group(function () {
        Route::get('/', [Admin\PageSeoController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\PageSeoController::class, 'create'])->name('create');
        Route::post('/', [Admin\PageSeoController::class, 'store'])->name('store');
        Route::get('/{pageSeo}/duzenle', [Admin\PageSeoController::class, 'edit'])->name('edit');
        Route::put('/{pageSeo}', [Admin\PageSeoController::class, 'update'])->name('update');
        Route::delete('/{pageSeo}', [Admin\PageSeoController::class, 'destroy'])->name('destroy');
    });

    // Yöneticiler
    Route::prefix('yoneticiler')->name('users.')->group(function () {
        Route::get('/', [Admin\AdminUserController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\AdminUserController::class, 'create'])->name('create');
        Route::post('/', [Admin\AdminUserController::class, 'store'])->name('store');
        Route::get('/{adminUser}/duzenle', [Admin\AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{adminUser}', [Admin\AdminUserController::class, 'update'])->name('update');
        Route::delete('/{adminUser}', [Admin\AdminUserController::class, 'destroy'])->name('destroy');
    });

    // Sayfalar
    Route::prefix('sayfalar')->name('pages.')->group(function () {
        Route::get('/', [Admin\PageController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\PageController::class, 'create'])->name('create');
        Route::post('/', [Admin\PageController::class, 'store'])->name('store');
        Route::get('/{page}/duzenle', [Admin\PageController::class, 'edit'])->name('edit');
        Route::put('/{page}', [Admin\PageController::class, 'update'])->name('update');
        Route::delete('/{page}', [Admin\PageController::class, 'destroy'])->name('destroy');
    });

    // Bannerlar
    Route::prefix('bannerlar')->name('banners.')->group(function () {
        Route::get('/', [Admin\BannerController::class, 'index'])->name('index');
        Route::get('/ekle', [Admin\BannerController::class, 'create'])->name('create');
        Route::post('/', [Admin\BannerController::class, 'store'])->name('store');
        Route::get('/{banner}/duzenle', [Admin\BannerController::class, 'edit'])->name('edit');
        Route::put('/{banner}', [Admin\BannerController::class, 'update'])->name('update');
        Route::delete('/{banner}', [Admin\BannerController::class, 'destroy'])->name('destroy');
    });

    // Ayarlar
    Route::prefix('ayarlar')->name('settings.')->group(function () {
        Route::get('/', [Admin\SettingController::class, 'index'])->name('index');
        Route::post('/', [Admin\SettingController::class, 'update'])->name('update');
    });
});
