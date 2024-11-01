<?php

use App\Http\Controllers\AffiliatesLoginController;
use App\Http\Controllers\AffiliatesPageController;
use App\Http\Controllers\DashboardPageController;
use App\Http\Controllers\DocumentsPageController;
use App\Http\Controllers\EndorsementFormController;
use App\Http\Controllers\InstitutionalUnitController;
use App\Http\Controllers\InstitutionalUnitLogin;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PartnershipsPageController;
use App\Http\Controllers\ProposalFormController;
use App\Http\Controllers\ProspectivePartnerResultController;
use App\Http\Controllers\SettingsPageController;
use App\Http\Controllers\StatisticsPageController;
use App\Http\Controllers\MemorandumController;
use App\Http\Controllers\ProspectivePartnerFormController;
use Illuminate\Support\Facades\Route;

//! Redirects the user to "/login" when the "/" is entered.
Route::get('/', function () {
    return redirect('/login');
});

//! Register, Login, and Logout Routes
// TODO: Remove the REGISTER route, methods, and pages after testing.
Route::get('/register', [LandingPageController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LandingPageController::class, 'register']);

Route::get('/login', [LandingPageController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LandingPageController::class, 'login']);
Route::post('/logout', [LandingPageController::class, 'logout'])->name('logout');

//! Route for BOTH Superadmin and Employee
Route::middleware(['auth', 'role:Superadmin,Employee'])->group(function () {
    
    //! Common Navigation Routes (Sidebar Routes)
    Route::get('/dashboard', [DashboardPageController::class, 'dashboard'])->name('dashboard');
    Route::get('/partnerships', [PartnershipsPageController::class, 'partnerships'])->name('partnerships');
    Route::get('/documents', [DocumentsPageController::class, 'documents'])->name('documents');
    Route::get('/statistics', [StatisticsPageController::class, 'statistics'])->name('statistics');
    Route::get('/settings', [SettingsPageController::class, 'settings'])->name('settings');
    Route::get('/affiliates', [AffiliatesPageController::class, 'affiliates'])->name('affiliates');

    //! NEW AFFILIATE
    Route::get('/affiliates/new',[AffiliatesPageController::class, 'showNewAffiliateForm'])->name('showNewAffiliateForm');
    Route::post('/affiliates/new', [AffiliatesPageController::class, 'storeNewAffiliate'])->name('storeNewAffiliate');

    //! NEW Institutional Unit
    Route::get('/affiliate/institutional-unit/new',[InstitutionalUnitController::class, 'showNewInstitutionalUnitForm'])->name('showNewInstitutionalUnitForm');
    Route::post('/affiliates/institutional-unit/new', [InstitutionalUnitController::class, 'storeNewInstitutionalUnit'])->name('storeNewInstitutionalUnit');

    //! Generate Link and Methods (Located in Sidebar)
    Route::get('/links', [LinkController::class, 'viewLink'])->name('viewLink');
    Route::post('/links/new', [LinkController::class, 'storeNewLink'])->name('storeNewLink');
    Route::delete('/links/delete/{id}', [LinkController::class, 'deleteLink'])->name('delete-link');

    //! Route for OGR Approving the 3 Documents
    Route::get('/documents/{id}/{name}/view', [DocumentsPageController::class, 'showDocument'])->name('showDocument');
    Route::post('/documents/{id}/{name}/view', [DocumentsPageController::class, 'approveDocument'])->name('approveDocument');
});

//TODO Compare Version
Route::get('/memorandum/{id}/compare/{version}', [MemorandumController::class, 'compareVersion'])->name('compareVersion');
Route::get('/memorandum/{id}/compare/{version}/view', [MemorandumController::class, 'displayMemorandumComparison'])->name('displayMemorandumComparison');

//! Route for: Affiliates' Approval Process
Route::get('/documents/application/{id}/{name}/approval', [DocumentsPageController::class, 'affiliateShowDocument'])->name('affiliateShowDocument')->middleware('checkAffiliateAccess');
Route::post('/documents/application/{id}/{name}/approval', [DocumentsPageController::class, 'affiliateApproveDocument'])->name('affiliateApproveDocument');

Route::get('/documents/application/{id}/{name}/login', [AffiliatesLoginController::class, 'showAffiliateLoginDocument'])->name('showAffiliateLoginDocument');
Route::post('/documents/application/{id}/{name}/login', [AffiliatesLoginController::class, 'affiliateLoginDocument'])->name('affiliateLoginDocument');

Route::get('/documents/application/{id}/{name}/change-password', [AffiliatesLoginController::class, 'showAffiliateChangePasswordDocument'])->name('showAffiliateChangePasswordDocument');
Route::post('/documents/application/{id}/{name}/change-password', [AffiliatesLoginController::class, 'affiliateChangePassword'])->name('affiliateChangePassword');

//! Routes for: Prospective Partner's
// View of Password and Form + Login
Route::get('/partner/application/{link}', [ProspectivePartnerFormController::class, 'prospectPartnerViewLink'])->name('prospectPartnerViewLink');
Route::post('/partner/application/{link}', [ProspectivePartnerFormController::class, 'validateProspectPartnerPassword'])->name('validateProspectPartnerPassword');

// Submission of Form
Route::post('/partner/application/{link}/submitted', [ProspectivePartnerFormController::class, 'submitProspectPartnerForm'])->name('submitProspectPartnerForm');

// View of Submitted Information
Route::get('/partner/application/{link}/view', [ProspectivePartnerFormController::class, 'prospectPartnerViewSubmittedForm'])->name('prospectPartnerViewSubmittedForm');
Route::post('/partner/application/{link}/view', [ProspectivePartnerFormController::class, 'validatePasswordSubmittedForm'])->name('validatePasswordSubmittedForm');

//! Route for: Institutional Unit's
// View of Submitted Information (From Prospective Partner)
Route::get('/partner/result/{link}/review', [ProspectivePartnerResultController::class, 'resultProspectivePartnerForm'])->name('resultProspectivePartnerForm')->middleware(['checkInstitutionalUnitAccess']);

// Login
Route::get('/partner/result/{link}/login', [ProspectivePartnerResultController::class, 'showResultLoginPage'])->name('showResultLoginPage');
Route::post('/partner/result/{link}/login', [InstitutionalUnitLogin::class, 'resultLogin'])->name('resultLogin');

// Change Password
Route::get('partner/result/{link}/change-password', [InstitutionalUnitLogin::class, 'showInstitutionalUnitChangePassword'])->name('showInstitutionalUnitChangePassword');
Route::post('partner/result/{link}/change-password', [InstitutionalUnitLogin::class, 'institutionalUnitChangePassword'])->name('institutionalUnitChangePassword');

// Creation of Endorsement Form
Route::post('/partner/result/{link}/review', [EndorsementFormController::class, 'generateEndorsement'])->name('generateEndorsement');

// View of Submitted Endorsement Form + Prospective Partner's Submitted Information
Route::get('/partner/result/{link}/view', [EndorsementFormController::class, 'viewEndorsement'])->name('viewEndorsement');

// View of Sign Pending
Route::get('/documents/application/{id}/{name}/sign', [InstitutionalUnitController::class, 'showSignPendingView'])->name('showSignPendingView')->middleware(['checkApprovalStatusandInstitutionalUnitAccess']);
Route::get('/documents/application/{id}/{name}/sign/login', [InstitutionalUnitLogin::class, 'showSignPendingLogin'])->name('showSignPendingLogin');
Route::post('/documents/application/{id}/{name}/sign/login', [InstitutionalUnitLogin::class, 'signPendingLogin'])->name('signPendingLogin');
Route::get('/documents/application/{id}/{name}/sign/download/{file}', [MemorandumController::class, 'actualDownload'])->name('actualDownload');
Route::post('/documents/application/{id}/{name}/sign/upload', [MemorandumController::class, 'appendDocument'])->name('appendDocument');

// ? Routes for Endorsement Form Creation
Route::get('/endorsement-form/create', [EndorsementFormController::class, 'create'])->name('createEndorsement');
//Route::post('/endorsement-form/generate', [EndorsementFormController::class, 'generate'])->name('generateEndorsement');
Route::get('/endorsement-form/{id}/download/{format}', [EndorsementFormController::class, 'downloadDocument'])->name('downloadEndorsement');
Route::get('/endorsement-form/{id}/edit', [EndorsementFormController::class, 'editDocument'])->name('editEndorsement');
Route::post('/endorsement-form/{id}/update', [EndorsementFormController::class, 'updateDocument'])->name('updateEndorsement');

// ? Routes for Proposal Form Creation (TEMPORARY)
Route::get('/proposal-form/create', [ProposalFormController::class, 'create'])->name('createProposal');
Route::post('/proposal-form/generate', [ProposalFormController::class, 'generate'])->name('generateProposal');
Route::get('/proposal-form/{id}/view', [ProposalFormController::class, 'viewDocument'])->name('viewProposal');
Route::get('/proposal-form/{id}/download/{format}', [ProposalFormController::class, 'downloadDocument'])->name('downloadProposal');
Route::get('/proposal-form/{id}/edit', [ProposalFormController::class, 'editDocument'])->name('editProposal');
Route::post('/proposal-form/{id}/update', [ProposalFormController::class, 'updateDocument'])->name('updateProposal');

// ? Routes for Memorandum Generation (TEMPORARY)
Route::get('/memorandum/create', [MemorandumController::class, 'create'])->name('createMemorandum');
Route::post('/memorandum/generate', [MemorandumController::class, 'generate'])->name('generateMemorandum');
Route::get('/memorandum/{id}/view', [MemorandumController::class, 'viewDocument'])->name('viewMemorandum');
Route::get('/memorandum/{id}/download/{format}', [MemorandumController::class, 'downloadDocument'])->name('downloadMemorandum');
Route::get('/memorandum/{id}/edit', [MemorandumController::class, 'editDocument'])->name('editMemorandum');
Route::post('/memorandum/{id}/update', [MemorandumController::class, 'updateDocument'])->name('updateMemorandum');

