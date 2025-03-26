<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CertificateController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Certificates
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/create', [CertificateController::class, 'create'])->name('certificates.create');
    Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('/certificates/{certificate}/edit', [CertificateController::class, 'edit'])->name('certificates.edit');
    Route::put('/certificates/{certificate}', [CertificateController::class, 'update'])->name('certificates.update');
    Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

    // Enrollments
    Route::post('/certificates/{certificate}/enroll', [CertificateController::class, 'enroll'])->name('certificates.enroll');
    Route::get('/my-certificates', [CertificateController::class, 'myCertificates'])->name('certificates.my');
    Route::delete('/certificates/{certificate}/unsubscribe', [CertificateController::class, 'deleteSubscription'])
        ->name('certificates.unsubscribe')
        ->middleware('auth');
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
