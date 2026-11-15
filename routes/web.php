<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalProductController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TransparencyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/clear-cache-all', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    dd('Cache Clear All');
});

Route::get('/buat_storage', function () {
    Artisan::call('storage:link');
    dd('Storage Berhasil Di Buat');
});

Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/page-history', [WebController::class, 'profile']);
Route::get('/page-vision-mission', [WebController::class, 'profile']);
Route::get('/page-structure', [WebController::class, 'profile']);
Route::get('/page-main-tasks', [WebController::class, 'profile']);
Route::get('/page-promotion', [WebController::class, 'service']);
Route::get('/page-retirement', [WebController::class, 'service']);
Route::get('/page-leave', [WebController::class, 'service']);
Route::get('/page-transfer', [WebController::class, 'service']);
Route::get('/page-discipline', [WebController::class, 'service']);
Route::get('/page-announcement', [WebController::class, 'announcement']);
Route::get('/page-legal-product', [WebController::class, 'legal_product']);
Route::get('/legal_product/{legalProduct}/download', [WebController::class, 'download_legal_product'])->name('legal_product.download');
Route::get('/page-faq', [WebController::class, 'faq']);
Route::get('/page-lakip', [WebController::class, 'accountability'])->defaults('category', 'lakip')->name('page.transparansi-lakip');
Route::get('/page-renstra', [WebController::class, 'accountability'])->defaults('category', 'renstra')->name('page.transparansi-renstra');
Route::get('/page-ziwbk', [WebController::class, 'accountability'])->defaults('category', 'zona_integritas')->name('page.transparansi-ziwbk');
Route::get('/transparansi-lakip', [WebController::class, 'accountability'])->defaults('category', 'lakip');
Route::get('/transparansi-renstra', [WebController::class, 'accountability'])->defaults('category', 'renstra');
Route::get('/transparansi-ziwbk', [WebController::class, 'accountability'])->defaults('category', 'zona_integritas');
Route::get('/transparansi/{category}/{transparency}/download', [TransparencyController::class, 'download'])->name('transparency.download');
Route::view('/kontak', 'pages.contact')->name('page.kontak');

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate']);

Route::middleware(['role:Administrator,Operator'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index']);
    Route::post('/logout', [LoginController::class, 'logout']);

    // # Slider
    Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
    Route::get('/slider/list', [SliderController::class, 'get_slider_index'])->name('slider.list');
    Route::post('/slider/store', [SliderController::class, 'store']);
    Route::post('/slider/validate/{action}', [SliderController::class, 'validate']);
    Route::get('/slider/edit/{slider}', [SliderController::class, 'edit']);
    Route::put('/slider/edit/{slider}', [SliderController::class, 'update']);
    Route::get('/slider/delete/{slider}', [SliderController::class, 'delete']);

    // # Profiles
    Route::get('/opening_speech', [ProfileController::class, 'index']);
    Route::get('/history', [ProfileController::class, 'index']);
    Route::get('/vision_mission', [ProfileController::class, 'index']);
    Route::get('/main_tasks', [ProfileController::class, 'index']);
    Route::get('/structure', [ProfileController::class, 'index']);
    Route::post('/profile/validate', [ProfileController::class, 'validation']);
    Route::put('/profile/edit/{profile}', [ProfileController::class, 'update']);

    // # Services
    Route::get('/service/{menu}', [ServiceController::class, 'index'])->name('service.index');
    Route::post('/service/validate', [ServiceController::class, 'validation']);
    Route::put('/service/edit/{service}', [ServiceController::class, 'update']);

    // # News
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/list', [NewsController::class, 'get_news_index'])->name('news.list');
    Route::post('/news/upload_image', [NewsController::class, 'upload_image'])->name('upload_news');
    Route::post('/news/store', [NewsController::class, 'store']);
    Route::post('/news/validate/{action}', [NewsController::class, 'validate']);
    Route::get('/news/edit/{news}', [NewsController::class, 'edit']);
    Route::put('/news/edit/{news}', [NewsController::class, 'update']);
    Route::get('/news/delete/{news}', [NewsController::class, 'delete']);

    // # News
    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/announcement/list', [AnnouncementController::class, 'get_announcement_index'])->name('announcement.list');
    Route::post('/announcement/upload_image', [AnnouncementController::class, 'upload_image'])->name('upload_announcement');
    Route::post('/announcement/store', [AnnouncementController::class, 'store']);
    Route::post('/announcement/validate/{action}', [AnnouncementController::class, 'validate']);
    Route::get('/announcement/edit/{announcement}', [AnnouncementController::class, 'edit']);
    Route::put('/announcement/edit/{announcement}', [AnnouncementController::class, 'update']);
    Route::get('/announcement/delete/{announcement}', [AnnouncementController::class, 'delete']);

    // # FAQs
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/faq/list', [FaqController::class, 'get_faq_index'])->name('faq.list');
    Route::post('/faq/store', [FaqController::class, 'store']);
    Route::post('/faq/validate/{action}', [FaqController::class, 'validate']);
    Route::get('/faq/edit/{id}', [FaqController::class, 'edit']);
    Route::put('/faq/edit/{faq}', [FaqController::class, 'update']);
    Route::get('/faq/delete/{faq}', [FaqController::class, 'delete']);

    // # Legal Products
    Route::get('/legal_product', [LegalProductController::class, 'index'])->name('legal_product.index');
    Route::get('/legal_product/list', [LegalProductController::class, 'get_legal_product_index'])->name('legal_product.list');
    Route::post('/legal_product/upload_image', [LegalProductController::class, 'upload_image'])->name('upload_legal_product');
    Route::post('/legal_product/store', [LegalProductController::class, 'store']);
    Route::post('/legal_product/validate/{action}', [LegalProductController::class, 'validate']);
    Route::get('/legal_product/edit/{id}', [LegalProductController::class, 'edit']);
    Route::put('/legal_product/edit/{legalProduct}', [LegalProductController::class, 'update']);
    Route::get('/legal_product/delete/{legalProduct}', [LegalProductController::class, 'delete']);

    // # Transparency
    Route::get('/transparency/{category}', [TransparencyController::class, 'index'])->name('transparency.index');
    Route::get('/transparency/{category}/list', [TransparencyController::class, 'get_transparency_index'])->name('transparency.list');
    Route::post('/transparency/{category}/store', [TransparencyController::class, 'store'])->name('transparency.store');
    Route::post('/transparency/{category}/validate/{action}', [TransparencyController::class, 'validate'])->name('transparency.validate');
    Route::get('/transparency/{category}/edit/{id}', [TransparencyController::class, 'edit'])->name('transparency.edit');
    Route::put('/transparency/{category}/edit/{transparency}', [TransparencyController::class, 'update'])->name('transparency.update');
    Route::get('/transparency/{category}/delete/{transparency}', [TransparencyController::class, 'delete'])->name('transparency.delete');

    // # Information
    Route::get('/information/', [InformationController::class, 'index'])->name('information.index');
    Route::get('/information/list/', [InformationController::class, 'get_information_index'])->name('information.list');
    Route::post('/information/upload_image', [InformationController::class, 'upload_image'])->name('upload_information');
    Route::post('/information/store', [InformationController::class, 'store']);
    Route::post('/information/validate/{action}', [InformationController::class, 'validate']);
    Route::get('/information/edit/{information}', [InformationController::class, 'edit']);
    Route::put('/information/edit/{information}', [InformationController::class, 'update']);
    Route::get('/information/delete/{information}', [InformationController::class, 'delete']);

    // # Album
    Route::get('/album', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/album/list', [AlbumController::class, 'get_album_index'])->name('album.list');
    Route::post('/album/store', [AlbumController::class, 'store']);
    Route::post('/album/validate/{action}', [AlbumController::class, 'validate']);
    Route::get('/album/edit/{album}', [AlbumController::class, 'edit']);
    Route::put('/album/edit/{album}', [AlbumController::class, 'update']);
    Route::get('/album/delete/{album}', [AlbumController::class, 'delete']);

    // # Photo
    Route::get('/photo/{album}', [PhotoController::class, 'index'])->name('photos.index');
    Route::get('/photo/list/{album}', [PhotoController::class, 'get_photo_index'])->name('photos.list');
    Route::post('/photo/store', [PhotoController::class, 'store']);
    Route::post('/photo/validate/{action}', [PhotoController::class, 'validate']);
    Route::get('/photo/edit/{photo}', [PhotoController::class, 'edit']);
    Route::put('/photo/edit/{photo}', [PhotoController::class, 'update']);
    Route::get('/photo/delete/{photo}', [PhotoController::class, 'delete']);

    // #  Edit Profile
    Route::get('/edit_profil/{user}', [UserController::class, 'edit_profil']);
    Route::post('/edit_profil/validate/{action}', [UserController::class, 'validate_profile']);
    Route::put('/edit_profil/{user}', [UserController::class, 'update_profil']);
});

Route::middleware(['role:Administrator'])->group(function () {

    // # User
    Route::get('/user', [UserController::class, 'index'])->name('users.index');
    Route::get('/user/list', [UserController::class, 'get_user_index'])->name('users.list');
    Route::post('/user/store', [UserController::class, 'store']);
    Route::post('/user/validate/{action}', [UserController::class, 'validate']);
    Route::get('/user/edit/{user}', [UserController::class, 'edit']);
    Route::put('/user/edit/{user}', [UserController::class, 'update']);
    Route::get('/user/delete/{user}', [UserController::class, 'delete']);

    // # Log
    Route::get('/log', [LogController::class, 'index'])->name('logs.index');
    Route::get('/log/list', [LogController::class, 'get_log_index'])->name('logs.list');
    Route::get('/log/detail/{user}', [LogController::class, 'detail']);

    // # Setting
    Route::get('/setting', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/setting/validate', [SettingController::class, 'validate']);
    Route::put('/setting/edit/{setting}', [SettingController::class, 'update']);

});
