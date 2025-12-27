<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\ShorterUrlController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',[AuthController::class,'loginPage'])->name('login');
Route::post('/login-store',[AuthController::class,'loginStore'])->name('store.login');
Route::get('invite/{token}',[AuthController::class,'invitePage'])->name('invite.page');
Route::Post('registration',[AuthController::class,'registration'])->name('registration');
Route::get('s/{short_code}',[ShorterUrlController::class,'redirectShortUrl'])->name('redirect.short.url');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[DashBoardController::class,'DashBoard'])->name('dashboard');
    Route::get('/shorter-url-list',[ShorterUrlController::class,'shorterUrlList'])->name('shorter.url.list');
    Route::get('/shorter-url-list-download/{param?}',[ShorterUrlController::class,'shorterUrlListDownload'])->name('shorter.url.list.download');
    Route::middleware('can:isSuperAdmin')->group(function(){
        Route::get('/create-company-page',[CompanyController::class,'createCompanyPage'])->name('create.company.page');
        Route::post('/create-company-store',[CompanyController::class,'storeNewCompany'])->name('create.company.store');
        Route::get('/company-list',[CompanyController::class,'companyList'])->name('company.list');
    });

    Route::get('logout',[AuthController::class,'logout'])->name('logout');
    Route::middleware('can:admin-or-member')->group(function () {
        Route::get('invite-member-page',[InviteController::class,'inviteMemberPage'])->name('invite.member.page');
        Route::get('member-list',[InviteController::class,'memberList'])->name('member.list');
        Route::post('invite-member-page',[InviteController::class,'inviteMemberSend'])->name('invite.member.send');
        Route::get('shorter-url-page',[ShorterUrlController::class,'shorterUrlPage'])->name('shorter.url.page');
        Route::post('shorter-url-page',[ShorterUrlController::class,'shorterUrlStore'])->name('shorter.url.store');
    });
});




    