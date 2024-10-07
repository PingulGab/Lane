<?php

use App\Http\Controllers\AffiliatesPageController;
use App\Http\Controllers\DashboardPageController;
use App\Http\Controllers\DocumentsPageController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PartnershipsPageController;
use App\Http\Controllers\SettingsPageController;
use App\Http\Controllers\StatisticsPageController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LandingPageController::class, 'landing'])->name('landing');
Route::get('/dashboard', [DashboardPageController::class, 'dashboard'])->name('dashboard');
Route::get('/partnerships', [PartnershipsPageController::class, 'partnerships'])->name('partnerships');
Route::get('/documents', [DocumentsPageController::class, 'documents'])->name('documents');
Route::get('/statistics', [StatisticsPageController::class, 'statistics'])->name('statistics');
Route::get('/affiliates', [AffiliatesPageController::class, 'affiliates'])->name('affiliates');
Route::get('/settings', [SettingsPageController::class, 'settings'])->name('settings');

//Ensures that the '/' goes to the appropriate link.
Route::get('/', function () {
    return redirect('/login');
});

//Post
Route::post('/login', [LandingPageController::class, 'authenticateUser'])->name('authenticateUser');