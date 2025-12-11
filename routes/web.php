<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerRegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

// Home - Redirect to catalog
Route::get('/', function () {
    return redirect()->route('catalog.index');
});

// Public Catalog Routes
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/produk/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/toko/{id}', [CatalogController::class, 'seller'])->name('catalog.seller');
Route::get('/produk/{product}/ulasan', [RatingController::class, 'productRatings'])->name('catalog.ratings');
Route::post('/produk/{product}/ulasan', [RatingController::class, 'store'])->name('rating.store');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Seller Registration Routes
Route::get('/daftar-penjual', [SellerRegistrationController::class, 'showForm'])->name('seller.register');
Route::post('/daftar-penjual', [SellerRegistrationController::class, 'register']);
Route::get('/daftar-penjual/sukses', [SellerRegistrationController::class, 'success'])->name('seller.register.success');
Route::get('/aktivasi/{token}', [SellerRegistrationController::class, 'activate'])->name('seller.activate');

// API for cities and villages
Route::get('/api/cities', [SellerRegistrationController::class, 'getCities'])->name('api.cities');
Route::get('/api/villages', [SellerRegistrationController::class, 'getVillages'])->name('api.villages');

// Platform Admin Routes
Route::prefix('platform')->middleware(['auth', 'platform'])->group(function () {
    Route::get('/dashboard', [PlatformController::class, 'dashboard'])->name('platform.dashboard');
    Route::get('/penjual-pending', [PlatformController::class, 'pendingSellers'])->name('platform.pending-sellers');
    Route::get('/penjual/{seller}', [PlatformController::class, 'showSeller'])->name('platform.seller.show');
    Route::post('/penjual/{seller}/approve', [PlatformController::class, 'approveSeller'])->name('platform.seller.approve');
    Route::post('/penjual/{seller}/reject', [PlatformController::class, 'rejectSeller'])->name('platform.seller.reject');
    Route::get('/semua-penjual', [PlatformController::class, 'allSellers'])->name('platform.all-sellers');
    
    // Platform Reports (SRS-09, 10, 11)
    Route::get('/laporan', [ReportController::class, 'index'])->name('platform.reports');
    Route::get('/laporan/penjual-aktif-tidak-aktif', [ReportController::class, 'sellersActiveInactive'])->name('report.sellers-active-inactive');
    Route::get('/laporan/penjual-per-provinsi', [ReportController::class, 'sellersByProvince'])->name('report.sellers-by-province');
    Route::get('/laporan/produk-rating-tertinggi', [ReportController::class, 'productsByRating'])->name('report.products-by-rating');
});

// Seller Routes
Route::prefix('seller')->middleware(['auth', 'seller'])->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'dashboard'])->name('seller.dashboard');
    
    // Products CRUD
    Route::get('/produk', [ProductController::class, 'index'])->name('seller.products.index');
    Route::get('/produk/tambah', [ProductController::class, 'create'])->name('seller.products.create');
    Route::post('/produk', [ProductController::class, 'store'])->name('seller.products.store');
    Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('/produk/{product}', [ProductController::class, 'update'])->name('seller.products.update');
    Route::delete('/produk/{product}', [ProductController::class, 'destroy'])->name('seller.products.destroy');
    
    // Seller Reports (SRS-12, 13, 14)
    Route::get('/laporan', [ReportController::class, 'sellerReportsIndex'])->name('seller.reports');
    Route::get('/laporan/stok-tertinggi', [ReportController::class, 'sellerProductsByStock'])->name('seller.report.products-by-stock');
    Route::get('/laporan/stok-berdasarkan-rating', [ReportController::class, 'sellerProductsByRating'])->name('seller.report.products-by-rating');
    Route::get('/laporan/produk-restock', [ReportController::class, 'sellerProductsNeedRestock'])->name('seller.report.products-need-restock');
});


Route::get('/test-email', function () {
    Mail::raw('Hello, this is a test email from Laravel using Mailtrap.', function ($message) {
        $message->to('test@example.com')
                ->subject('Mailtrap Laravel Test');
    });

    return 'Email sent! Check Mailtrap.';
});