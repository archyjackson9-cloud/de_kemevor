<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EConsultationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ConsultationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ReminderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──────────────────────────────────────────────────────────
Route::get('/',        [HomeController::class,     'index'])->name('home');
Route::get('/services',[ServicesController::class, 'index'])->name('services');
Route::get('/services/{service:slug}', [ServicesController::class, 'show'])->name('services.show');
Route::get('/about',   [AboutController::class,    'index'])->name('about');
Route::get('/contact', [ContactController::class,  'index'])->name('contact');
Route::post('/contact',[ContactController::class,  'send'])->name('contact.send');

// E-Consultation
Route::get('/e-consultation',  [EConsultationController::class, 'index'])->name('econsultation');
Route::post('/e-consultation', [EConsultationController::class, 'store'])->name('econsultation.store');

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

// Forgot / Reset Password
Route::get('/admin/forgot-password',  [AuthController::class, 'forgotPasswordForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AuthController::class, 'sendResetCode'])     ->name('admin.password.email');
Route::get('/admin/reset-password',   [AuthController::class, 'resetPasswordForm']) ->name('admin.password.reset.form');
Route::post('/admin/reset-password',  [AuthController::class, 'resetPassword'])     ->name('admin.password.update');

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
    Route::post('/discounts/tiers',                 [DiscountController::class, 'updateTiers'])   ->name('admin.discounts.tiers.update');
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

    // Team Members
    Route::get('/team',                    [TeamMemberController::class, 'index'])       ->name('admin.team');
    Route::post('/team',                   [TeamMemberController::class, 'store'])       ->name('admin.team.store');
    Route::put('/team/{team}',             [TeamMemberController::class, 'update'])      ->name('admin.team.update');
    Route::delete('/team/{team}',          [TeamMemberController::class, 'destroy'])     ->name('admin.team.destroy');
    Route::post('/team/{team}/toggle',     [TeamMemberController::class, 'toggleActive'])->name('admin.team.toggle');

    // Partners
    Route::get('/partners',                   [PartnerController::class, 'index'])       ->name('admin.partners');
    Route::post('/partners',                  [PartnerController::class, 'store'])       ->name('admin.partners.store');
    Route::put('/partners/{partner}',         [PartnerController::class, 'update'])      ->name('admin.partners.update');
    Route::delete('/partners/{partner}',      [PartnerController::class, 'destroy'])     ->name('admin.partners.destroy');
    Route::post('/partners/{partner}/toggle', [PartnerController::class, 'toggleActive'])->name('admin.partners.toggle');

    // Hero Slides
    Route::get('/hero-slides',                    [HeroSlideController::class, 'index'])       ->name('admin.hero-slides');
    Route::post('/hero-slides',                   [HeroSlideController::class, 'store'])       ->name('admin.hero-slides.store');
    Route::put('/hero-slides/{heroSlide}',         [HeroSlideController::class, 'update'])      ->name('admin.hero-slides.update');
    Route::delete('/hero-slides/{heroSlide}',      [HeroSlideController::class, 'destroy'])     ->name('admin.hero-slides.destroy');
    Route::post('/hero-slides/{heroSlide}/toggle', [HeroSlideController::class, 'toggleActive'])->name('admin.hero-slides.toggle');

    // Pages — Home
    Route::get('/pages/home',   [PageController::class, 'home'])      ->name('admin.pages.home');
    Route::post('/pages/home',  [PageController::class, 'updateHome'])->name('admin.pages.home.update');
    Route::post('/pages/home/values',                    [PageController::class, 'storeHomeValue'])  ->name('admin.pages.home.values.store');
    Route::put('/pages/home/values/{homeValue}',         [PageController::class, 'updateHomeValue']) ->name('admin.pages.home.values.update');
    Route::delete('/pages/home/values/{homeValue}',      [PageController::class, 'destroyHomeValue'])->name('admin.pages.home.values.destroy');
    Route::post('/pages/home/values/{homeValue}/toggle', [PageController::class, 'toggleHomeValue']) ->name('admin.pages.home.values.toggle');
    Route::post('/pages/home/testimonials',                        [PageController::class, 'storeTestimonial'])  ->name('admin.pages.home.testimonials.store');
    Route::put('/pages/home/testimonials/{testimonial}',           [PageController::class, 'updateTestimonial']) ->name('admin.pages.home.testimonials.update');
    Route::delete('/pages/home/testimonials/{testimonial}',        [PageController::class, 'destroyTestimonial'])->name('admin.pages.home.testimonials.destroy');
    Route::post('/pages/home/testimonials/{testimonial}/toggle',   [PageController::class, 'toggleTestimonial']) ->name('admin.pages.home.testimonials.toggle');

    // Pages — About
    Route::get('/pages/about',    [PageController::class, 'about'])      ->name('admin.pages.about');
    Route::post('/pages/about',   [PageController::class, 'updateAbout'])->name('admin.pages.about.update');
    Route::post('/pages/about/values',                    [PageController::class, 'storeValue'])  ->name('admin.pages.about.values.store');
    Route::put('/pages/about/values/{aboutValue}',        [PageController::class, 'updateValue']) ->name('admin.pages.about.values.update');
    Route::delete('/pages/about/values/{aboutValue}',     [PageController::class, 'destroyValue'])->name('admin.pages.about.values.destroy');
    Route::post('/pages/about/values/{aboutValue}/toggle',[PageController::class, 'toggleValue']) ->name('admin.pages.about.values.toggle');
    Route::post('/pages/about/certs',                         [PageController::class, 'storeCert'])  ->name('admin.pages.about.certs.store');
    Route::put('/pages/about/certs/{aboutCertification}',     [PageController::class, 'updateCert']) ->name('admin.pages.about.certs.update');
    Route::delete('/pages/about/certs/{aboutCertification}',  [PageController::class, 'destroyCert'])->name('admin.pages.about.certs.destroy');
    Route::post('/pages/about/certs/{aboutCertification}/toggle',[PageController::class,'toggleCert'])->name('admin.pages.about.certs.toggle');

    // Pages — Contact
    Route::get('/pages/contact',  [PageController::class, 'contact'])       ->name('admin.pages.contact');
    Route::post('/pages/contact', [PageController::class, 'updateContact']) ->name('admin.pages.contact.update');

    // Settings — Branding
    Route::get('/settings',  [SettingsController::class, 'index']) ->name('admin.settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Admin Users
    Route::get('/users',           [UserController::class, 'index'])  ->name('admin.users');
    Route::post('/users',          [UserController::class, 'store'])  ->name('admin.users.store');
    Route::put('/users/{user}',    [UserController::class, 'update']) ->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // E-Consultations
    Route::get('/consultations',                 [ConsultationController::class, 'index'])  ->name('admin.consultations');
    Route::get('/consultations/{consultation}',  [ConsultationController::class, 'show'])   ->name('admin.consultations.show');
    Route::post('/consultations/{consultation}/respond', [ConsultationController::class, 'respond'])->name('admin.consultations.respond');
    Route::delete('/consultations/{consultation}', [ConsultationController::class, 'destroy'])->name('admin.consultations.destroy');
});
