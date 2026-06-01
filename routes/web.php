<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ReminderController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──────────────────────────────────────────────────────────
Route::get('/',        [HomeController::class,     'index'])->name('home');
Route::get('/services',[ServicesController::class, 'index'])->name('services');
Route::get('/about',   [AboutController::class,    'index'])->name('about');
Route::get('/contact', [ContactController::class,  'index'])->name('contact');
Route::post('/contact',[ContactController::class,  'send'])->name('contact.send');

// Booking
Route::get('/book',             [BookingController::class, 'index'])  ->name('booking');
Route::post('/book',            [BookingController::class, 'store'])  ->name('booking.store');
Route::get('/book/success/{confirmation}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/book/slots',       [BookingController::class, 'getAvailableSlots'])->name('booking.slots');
Route::get('/book/promo',       [BookingController::class, 'checkPromo'])        ->name('booking.promo');

// ── Admin Auth ─────────────────────────────────────────────────────────────
Route::get('/admin/login',  [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])    ->name('admin.login.post');
Route::post('/admin/logout',[AuthController::class, 'logout'])   ->name('admin.logout');

// ── Admin Protected Routes ─────────────────────────────────────────────────
Route::middleware(\App\Http\Middleware\AdminAuthenticate::class)->prefix('admin')->group(function () {
    Route::get('/',          [DashboardController::class,  'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class,  'index'])->name('admin.dashboard.alt');

    // Bookings
    Route::get('/bookings',                    [AdminBookingController::class, 'index'])  ->name('admin.bookings');
    Route::post('/bookings',                   [AdminBookingController::class, 'store'])  ->name('admin.bookings.store');
    Route::get('/bookings/{booking}',          [AdminBookingController::class, 'show'])   ->name('admin.bookings.show');
    Route::put('/bookings/{booking}',          [AdminBookingController::class, 'update']) ->name('admin.bookings.update');
    Route::delete('/bookings/{booking}',       [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');

    // Customers
    Route::get('/customers',            [CustomerController::class, 'index']) ->name('admin.customers');
    Route::post('/customers',           [CustomerController::class, 'store']) ->name('admin.customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])  ->name('admin.customers.show');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');

    // Services
    Route::get('/services',                    [ServiceController::class, 'index'])       ->name('admin.services');
    Route::post('/services',                   [ServiceController::class, 'store'])       ->name('admin.services.store');
    Route::put('/services/{service}',          [ServiceController::class, 'update'])      ->name('admin.services.update');
    Route::delete('/services/{service}',       [ServiceController::class, 'destroy'])     ->name('admin.services.destroy');
    Route::post('/services/{service}/toggle',  [ServiceController::class, 'toggleActive'])->name('admin.services.toggle');

    // Discounts
    Route::get('/discounts',                        [DiscountController::class, 'index'])         ->name('admin.discounts');
    Route::post('/discounts/promo',                 [DiscountController::class, 'storePromo'])     ->name('admin.discounts.promo.store');
    Route::post('/discounts/promo/{promoCode}/toggle', [DiscountController::class, 'togglePromo'])->name('admin.discounts.promo.toggle');
    Route::delete('/discounts/promo/{promoCode}',   [DiscountController::class, 'destroyPromo'])  ->name('admin.discounts.promo.destroy');
    Route::post('/discounts/assign',                [DiscountController::class, 'assignDiscount'])->name('admin.discounts.assign');
    Route::delete('/discounts/{customerDiscount}',  [DiscountController::class, 'revokeDiscount'])->name('admin.discounts.revoke');

    // Reminders
    Route::get('/reminders',       [ReminderController::class, 'index'])      ->name('admin.reminders');
    Route::post('/reminders/send',   [ReminderController::class, 'send'])       ->name('admin.reminders.send');
    Route::post('/reminders/auto',   [ReminderController::class, 'autoProcess'])->name('admin.reminders.auto');
    Route::post('/reminders/toggle', [ReminderController::class, 'toggle'])    ->name('admin.reminders.toggle');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
});
