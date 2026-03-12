<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/ticket/{code}', [TicketController::class, 'show'])->name('ticket.show');

// Admin Panel Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Ticket Verification
        Route::get('/verify', [TicketController::class, 'verifyPage'])->name('admin.verify');
        Route::post('/verify', [TicketController::class, 'verifyTicket'])->name('admin.verify.post');

        // Event Management
        Route::get('/event/edit', [AdminController::class, 'editEvent'])->name('admin.event.edit');
        Route::post('/event/update', [AdminController::class, 'updateEvent'])->name('admin.event.update');

        // Coupon Management
        Route::get('/coupons', [AdminController::class, 'couponsIndex'])->name('admin.coupons.index');
        Route::post('/coupons', [AdminController::class, 'couponStore'])->name('admin.coupons.store');
        Route::delete('/coupons/{id}', [AdminController::class, 'couponDelete'])->name('admin.coupons.delete');

        // Manual Registration
        Route::get('/manual-register', [AdminController::class, 'manualRegister'])->name('admin.manual.register');
        Route::post('/manual-register', [AdminController::class, 'manualStore'])->name('admin.manual.store');

        // Email Test
        Route::get('/test-email', [AdminController::class, 'testEmail'])->name('admin.email.test');
    });
});
