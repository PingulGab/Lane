<?php

use App\Http\Controllers\AffiliatesPageController;
use App\Http\Controllers\DashboardPageController;
use App\Http\Controllers\DocumentsPageController;
use App\Http\Controllers\EndorsementFormController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PartnershipsPageController;
use App\Http\Controllers\ProposalFormController;
use App\Http\Controllers\SettingsPageController;
use App\Http\Controllers\StatisticsPageController;
use App\Http\Controllers\MemorandumController;
use Illuminate\Support\Facades\Route;

/* Routes for Common Navigation */

Route::get('/login', [LandingPageController::class, 'landing'])->name('landing');
Route::get('/dashboard', [DashboardPageController::class, 'dashboard'])->name('dashboard');
Route::get('/partnerships', [PartnershipsPageController::class, 'partnerships'])->name('partnerships');
Route::get('/documents', [DocumentsPageController::class, 'documents'])->name('documents');
Route::get('/statistics', [StatisticsPageController::class, 'statistics'])->name('statistics');
Route::get('/affiliates', [AffiliatesPageController::class, 'affiliates'])->name('affiliates');
Route::get('/settings', [SettingsPageController::class, 'settings'])->name('settings');

/* Routes for Proposal Form Creation */
Route::get('/proposal-form/create', [ProposalFormController::class, 'create'])->name('createProposal');
Route::post('/proposal-form/generate', [ProposalFormController::class, 'generate'])->name('generateProposal');
Route::get('/proposal-form/{id}/view', [ProposalFormController::class, 'viewDocument'])->name('viewProposal');
Route::get('/proposal-form/{id}/download/{format}', [ProposalFormController::class, 'downloadDocument'])->name('downloadProposal');
Route::get('/proposal-form/{id}/edit', [ProposalFormController::class, 'editDocument'])->name('editProposal');
Route::post('/proposal-form/{id}/update', [ProposalFormController::class, 'updateDocument'])->name('updateProposal');

/* Routes for MOA Creation */
Route::get('/memorandum/create', [MemorandumController::class, 'create'])->name('createMemorandum');
Route::post('/memorandum/generate', [MemorandumController::class, 'generate'])->name('generateMemorandum');
Route::get('/memorandum/{id}/view', [MemorandumController::class, 'viewDocument'])->name('viewMemorandum');
Route::get('/memorandum/{id}/download/{format}', [MemorandumController::class, 'downloadDocument'])->name('downloadMemorandum');
Route::get('/memorandum/{id}/edit', [MemorandumController::class, 'editDocument'])->name('editMemorandum');
Route::post('/memorandum/{id}/update', [MemorandumController::class, 'updateDocument'])->name('updateMemorandum');

/* Routes for Endorsement Form Creation */
Route::get('/endorsement-form/create', [EndorsementFormController::class, 'create'])->name('createEndorsement');
Route::post('/endorsement-form/generate', [EndorsementFormController::class, 'generate'])->name('generateEndorsement');
Route::get('/endorsement-form/{id}/view', [EndorsementFormController::class, 'viewDocument'])->name('viewEndorsement');
Route::get('/endorsement-form/{id}/download/{format}', [EndorsementFormController::class, 'downloadDocument'])->name('downloadEndorsement');
Route::get('/endorsement-form/{id}/edit', [EndorsementFormController::class, 'editDocument'])->name('editEndorsement');
Route::post('/endorsement-form/{id}/update', [EndorsementFormController::class, 'updateDocument'])->name('updateEndorsement');

//Ensures that the '/' goes to the appropriate link.
Route::get('/', function () {
    return redirect('/login');
});

//Post
Route::post('/login', [LandingPageController::class, 'authenticateUser'])->name('authenticateUser');