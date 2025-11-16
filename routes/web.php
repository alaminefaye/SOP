<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Procedures Routes
    Route::resource('procedures', \App\Http\Controllers\ProcedureController::class);
    Route::post('/procedures/{procedure}/approve', [\App\Http\Controllers\ProcedureController::class, 'approve'])
        ->name('procedures.approve');
    Route::get('/procedures/{procedure}/versions', [\App\Http\Controllers\ProcedureController::class, 'versions'])
        ->name('procedures.versions');
    Route::get('/procedures/{procedure}/compare/{version1}/{version2}', [\App\Http\Controllers\ProcedureController::class, 'compareVersions'])
        ->name('procedures.compare');
    Route::delete('/procedures/{procedure}/attachments/{attachment}', [\App\Http\Controllers\ProcedureController::class, 'deleteAttachment'])
        ->name('procedures.attachments.destroy');
    Route::get('/procedures/{procedure}/export', [\App\Http\Controllers\ProcedureController::class, 'export'])
        ->name('procedures.export');

    // Categories Routes
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);

    // Compliance Routes
    Route::get('/compliance', [\App\Http\Controllers\ComplianceController::class, 'index'])->name('compliance.index');
    Route::get('/procedures/{procedure}/compliance', [\App\Http\Controllers\ComplianceController::class, 'show'])->name('compliance.show');
    Route::post('/procedures/{procedure}/compliance', [\App\Http\Controllers\ComplianceController::class, 'store'])->name('compliance.store');

    // Reports Routes
    Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/procedures', [\App\Http\Controllers\ReportController::class, 'procedures'])->name('reports.procedures');
    Route::get('/reports/compliance', [\App\Http\Controllers\ReportController::class, 'compliance'])->name('reports.compliance');
    Route::get('/reports/activity', [\App\Http\Controllers\ReportController::class, 'activity'])->name('reports.activity');

    // Notifications Routes
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
});
