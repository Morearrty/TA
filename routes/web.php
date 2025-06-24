<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Admin\{
    DistrictController,
    MemberController,
    ActivityProposalController,
    DashboardController as AdminDashboardController,
    PageContentController as AdminPageContentController
};
use App\Http\Controllers\Member\{
    DashboardController as MemberDashboardController,
    ProfileController as MemberProfileController
};
use App\Http\Controllers\DistrictAdmin\{
    DashboardController as DistrictAdminDashboardController,
    MemberController as DistrictAdminMemberController,
    ProposalController as DistrictAdminProposalController
};
use App\Http\Controllers\Auth\{
    AuthController,
    ForgotPasswordController
};
use App\Http\Controllers\WelcomeController;

// Public Routes
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Member Registration
    Route::get('/daftar', [AnggotaController::class, 'daftar'])->name('anggota.daftar');
    Route::post('/daftar', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/sukses/{id}', [AnggotaController::class, 'success'])->name('anggota.success');
    Route::get('/download-kta/{id}', [AnggotaController::class, 'downloadKta'])->name('anggota.download-kta');

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');

    // Password Reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/email-sent', [ForgotPasswordController::class, 'emailSent'])->name('password.email.sent');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Member Routes
Route::prefix('member')->name('member.')->middleware(['auth', 'member'])->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::prefix('profile')->group(function () {
        Route::get('/', [MemberProfileController::class, 'index'])->name('profile');
        Route::get('/edit', [MemberProfileController::class, 'edit'])->name('edit-profile');
        Route::put('/update', [MemberProfileController::class, 'update'])->name('update-profile');
        Route::post('/update-photo', [MemberProfileController::class, 'updatePhoto'])->name('update-photo');
        Route::get('/download-kta', [MemberProfileController::class, 'downloadKta'])->name('download-kta');
    });
});

//admin district
Route::prefix('district-admin')->name('district.admin.')->middleware(['auth', 'district_admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DistrictAdminDashboardController::class, 'index'])->name('dashboard');
    
    // Member Management
    Route::get('/members', [DistrictAdminMemberController::class, 'index'])->name('members.index');
    Route::get('/members/{member}', [DistrictAdminMemberController::class, 'show'])->name('members.show');
    
    // Proposal Management
    Route::resource('proposals', DistrictAdminProposalController::class)->except(['edit', 'update', 'destroy']);
    Route::put('/proposals/{proposal}/submit', [DistrictAdminProposalController::class, 'submit'])->name('proposals.submit');

    // Profile Management (LENGKAPI BAGIAN INI)
    Route::get('/profile', [DistrictAdminDashboardController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [DistrictAdminDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [DistrictAdminDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // District Management
    Route::resource('districts', DistrictController::class);
    
    // Member Management
    Route::resource('members', MemberController::class);
    Route::prefix('members')->group(function () {
        Route::get('pending/approval', [MemberController::class, 'pendingApproval'])->name('members.pending');
        Route::post('{member}/approve', [MemberController::class, 'approve'])->name('members.approve');
        Route::post('{member}/reject', [MemberController::class, 'reject'])->name('members.reject');
        Route::get('{member}/reset-password', [MemberController::class, 'showResetPasswordForm'])->name('members.reset-password');
        Route::put('{member}/reset-password', [MemberController::class, 'resetPassword'])->name('members.reset-password.update');
        Route::put('{member}/update-role', [MemberController::class, 'updateRole'])->name('members.update-role');
        Route::get('{member}/download-kta', [MemberController::class, 'downloadKta'])->name('members.download-kta');
    });
    
    // Proposal Management
    Route::prefix('proposals')->group(function () {
        Route::get('/', [ActivityProposalController::class, 'index'])->name('proposals.index');
        Route::get('/{proposal}', [ActivityProposalController::class, 'show'])->name('proposals.show');
        Route::post('/{proposal}/status', [ActivityProposalController::class, 'updateStatus'])->name('proposals.update-status');
    });
    
    
   
});

