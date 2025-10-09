<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


Route::group([], function () {
    Route::get('/', fn() => view('page.home.index'))->name('home');

    Route::prefix('community')->name('community.')->group(function () {
        Route::get('/', fn() => view('page.community.index'))->name('index');
        Route::get('/post/{id}', fn($id) => view('page.community.post-detail'))->name('post-detail');
    });
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/', function () {
            $products = \App\Models\Product::where('is_active', 1)->orderBy('created_at', 'desc')->get();
            return view('page.shop.index', compact('products'));
        })->name('index');
        Route::get('/cart', fn() => view('page.shop.cart'))->name('cart');
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
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});



Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('admin.dashboard');

    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/products/preview', [ProductController::class, 'previewFile'])->name('admin.products.preview');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');



    Route::get('/orders', function () {
        return view('admin.orders.orders');
    })->name('admin.orders');

    Route::get('/users', function () {
        return view('admin.users.users');
    })->name('admin.users');

    Route::get('/analytics', function () {
        return view('admin.analytics.analytics');
    })->name('admin.analytics');

    Route::get('/settings', function () {
        return view('admin.settings.settings');
    })->name('admin.settings');

    Route::get('/posts', function () {
        return view('admin.posts.posts');
    })->name('admin.posts');

    Route::get('/posts/create', function () {
        return view('admin.posts.create');
    })->name('admin.posts.create');
    Route::post('/posts/create', function () {
        return redirect()->route('admin.posts');
    })->name('admin.posts.store');

    Route::get('/posts/edit/{id}', function ($id) {
        return view('admin.posts.edit');
    })->name('admin.posts.edit');

    // Admin logout 
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::prefix('account')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('account.sheets');
    })->name('account.sheets');
    Route::get('/profile', function () {
        return view('account.profile');
    })->name('account.profile');
    Route::get('/posts', function () {
        return view('account.posts');
    })->name('account.posts');
    Route::get('/activity', function () {
        return view('account.activity');
    })->name('account.activity');
    Route::get('/settings', function () {
        return view('account.settings');
    })->name('account.settings');
    Route::get('/deposit', function () {
        return view('account.deposit');
    })->name('account.deposit');
    Route::get('/withdraw', function () {
        return view('account.withdraw');
    })->name('account.withdraw');
});
