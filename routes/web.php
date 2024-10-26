<?php

use App\Http\Controllers\AffiliatesPageController;
use App\Http\Controllers\DashboardPageController;
use App\Http\Controllers\DocumentsPageController;
use App\Http\Controllers\EndorsementFormController;
use App\Http\Controllers\GenerateLinkController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PartnershipsPageController;
use App\Http\Controllers\ProposalFormController;
use App\Http\Controllers\ProspectivePartnerResultController;
use App\Http\Controllers\SettingsPageController;
use App\Http\Controllers\StatisticsPageController;
use App\Http\Controllers\MemorandumController;
use App\Http\Controllers\ProspectivePartnerFormController;
use App\Http\Middleware\CheckLinkAccess;
use Illuminate\Support\Facades\Route;

/* Routes for Common Navigation */
Route::get('/login', [LandingPageController::class, 'landing'])->name('landing');
Route::get('/dashboard', [DashboardPageController::class, 'dashboard'])->name('dashboard');
Route::get('/partnerships', [PartnershipsPageController::class, 'partnerships'])->name('partnerships');
Route::get('/documents', [DocumentsPageController::class, 'documents'])->name('documents');
Route::get('/statistics', [StatisticsPageController::class, 'statistics'])->name('statistics');
Route::get('/affiliates', [AffiliatesPageController::class, 'affiliates'])->name('affiliates');
Route::get('/settings', [SettingsPageController::class, 'settings'])->name('settings');

/* Affiliates */
Route::get('/affiliates', [AffiliatesPageController::class, 'index'])->name('affiliatesIndex');
Route::get('/affiliates/create', [AffiliatesPageController::class, 'create'])->name('affiliatesCreate');
Route::post('/affiliates', [AffiliatesPageController::class, 'store'])->name('affiliatesStore');
Route::post('/affiliates/{affiliates}/reset-password', [AffiliatesPageController::class, 'resetPassword'])->name('affiliatesResetPassword');

/* Links */
Route::get('/generate-link', [GenerateLinkController::class, 'viewGenerate'])->name('generate-link');
Route::post('/generateLinkMethod', [GenerateLinkController::class, 'generateLink'])->name('generateLinkMethod');
Route::get('/link/{link}', [GenerateLinkController::class, 'showLink'])->name('show-link');
Route::post('/link/{link}', [GenerateLinkController::class, 'validatePassword'])->name('validate-link-password');
Route::delete('/link/{id}', [GenerateLinkController::class, 'deleteLink'])->name('delete-link');

/* Prospetice Partner Forms and Result Link */
// Route for displaying and submitting the form (requires checkLinkAccess middleware)
Route::post('/form/{link}', [ProspectivePartnerFormController::class, 'submitForm'])->name('submitForm');

// Route for viewing the result (requires authentication middleware)
Route::get('/result/{link}', [ProspectivePartnerResultController::class, 'showResult'])->name('DeparmentResults');

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