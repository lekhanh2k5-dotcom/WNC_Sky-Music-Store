<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


Route::group([], function () {
    Route::get('/', fn() => view('page.home.index'))->name('home');

    Route::prefix('community')->name('community.')->group(function () {
        Route::get('/', fn() => view('page.community.index'))->name('index');
    });
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/', function () {
            $products = \App\Models\Product::where('is_active', 1)->orderBy('created_at', 'desc')->paginate(12);
            return view('page.shop.index', compact('products'));
        })->name('index');
        Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    });

    // Cart routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::post('/add', [App\Http\Controllers\CartController::class, 'add'])->name('add');
        Route::post('/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('remove');
        Route::post('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
    });
    Route::get('/support', fn() => view('page.support.index'))->name('support.index');
});

Route::group([], function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    // Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});



Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/products/preview', [ProductController::class, 'previewFile'])->name('admin.products.preview');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');



    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders');
    Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
    Route::post('/users/{id}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/settings', function () {
        return view('admin.settings.settings');
    })->name('admin.settings');

    // Admin logout 
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AccountController::class, 'sheets'])->name('account.sheets');
    Route::get('/profile', function () {
        return view('account.profile');
    })->name('account.profile');
    Route::get('/posts', function () {
        return view('account.posts');
    })->name('account.posts');
    Route::get('/activity', [App\Http\Controllers\AccountController::class, 'activity'])->name('account.activity');
    Route::get('/settings', function () {
        return view('account.settings');
    })->name('account.settings');
    Route::get('/deposit', function () {
        return view('account.deposit');
    })->name('account.deposit');
    Route::get('/withdraw', function () {
        return view('account.withdraw');
    })->name('account.withdraw');
    Route::get('/download/{purchaseId}', [App\Http\Controllers\AccountController::class, 'downloadSheet'])->name('account.download');
});
