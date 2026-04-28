<?php

use App\Http\Controllers\Admin\ContactSubmissionsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewslettersController;
use App\Http\Controllers\Admin\SubscribersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('subscribers', [SubscribersController::class, 'index'])->name('subscribers.index');
    Route::patch('subscribers/{subscriber}', [SubscribersController::class, 'update'])->name('subscribers.update');
    Route::delete('subscribers/{subscriber}', [SubscribersController::class, 'destroy'])->name('subscribers.destroy');

    Route::get('newsletters', [NewslettersController::class, 'index'])->name('newsletters.index');
    Route::get('newsletters/create', [NewslettersController::class, 'create'])->name('newsletters.create');
    Route::post('newsletters', [NewslettersController::class, 'store'])->name('newsletters.store');
    Route::get('newsletters/{newsletter}', [NewslettersController::class, 'show'])->name('newsletters.show');
    Route::get('newsletters/{newsletter}/edit', [NewslettersController::class, 'edit'])->name('newsletters.edit');
    Route::patch('newsletters/{newsletter}', [NewslettersController::class, 'update'])->name('newsletters.update');
    Route::delete('newsletters/{newsletter}', [NewslettersController::class, 'destroy'])->name('newsletters.destroy');
    Route::post('newsletters/{newsletter}/test-send', [NewslettersController::class, 'testSend'])->name('newsletters.test-send');
    Route::post('newsletters/{newsletter}/send', [NewslettersController::class, 'send'])->name('newsletters.send');

    Route::get('contact-submissions', [ContactSubmissionsController::class, 'index'])->name('contact-submissions.index');
    Route::get('contact-submissions/{contactSubmission}', [ContactSubmissionsController::class, 'show'])->name('contact-submissions.show');
});
