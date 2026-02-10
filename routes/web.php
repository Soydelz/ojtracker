<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DtrController;
use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Redirect to dashboard if authenticated
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('landing');
});

// Email Verification Routes
Route::post('/send-verification', [EmailVerificationController::class, 'sendVerificationCode'])->name('send.verification');
Route::post('/verify-code', [EmailVerificationController::class, 'verifyCode'])->name('verify.code');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// DTR Routes
Route::middleware('auth')->group(function () {
    Route::get('/dtr', [DtrController::class, 'index'])->name('dtr.index');
    Route::post('/dtr/store', [DtrController::class, 'store'])->name('dtr.store');
    Route::post('/dtr/timein', [DtrController::class, 'timeIn'])->name('dtr.timein');
    Route::post('/dtr/timeout', [DtrController::class, 'timeOut'])->name('dtr.timeout');
    Route::put('/dtr/{dtr}', [DtrController::class, 'update'])->name('dtr.update');
});

// Accomplishments Routes
Route::middleware('auth')->group(function () {
    Route::get('/accomplishments', [AccomplishmentController::class, 'index'])->name('accomplishments.index');
    Route::post('/accomplishments', [AccomplishmentController::class, 'store'])->name('accomplishments.store');
    Route::put('/accomplishments/{accomplishment}', [AccomplishmentController::class, 'update'])->name('accomplishments.update');
    Route::delete('/accomplishments/{accomplishment}', [AccomplishmentController::class, 'destroy'])->name('accomplishments.destroy');
});

// Reports Routes
Route::middleware('auth')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/upload-picture', [ProfileController::class, 'uploadProfilePicture'])->name('profile.upload-picture');
    Route::post('/profile/upload-cover', [ProfileController::class, 'uploadCoverPhoto'])->name('profile.upload-cover');
    Route::post('/profile/register-face', [ProfileController::class, 'registerFace'])->name('profile.register-face');
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

require __DIR__.'/auth.php';
