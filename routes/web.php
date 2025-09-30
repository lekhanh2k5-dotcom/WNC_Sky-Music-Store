<?php

use Illuminate\Support\Facades\Route;


Route::group([], function () {
    Route::get('/', fn () => view('page.home.index'))->name('home');

    // Community routes
    Route::prefix('community')->name('community.')->group(function () {
        Route::get('/', fn () => view('page.community.index'))->name('index');
        Route::get('/post/{id}', fn ($id) => view('page.community.post-detail'))->name('post-detail');
    });
    // Shop routes
    Route::prefix('shop')->name('shop.')->group(function () {
        Route::get('/', fn () => view('page.shop.index'))->name('index');
        Route::get('/cart', fn () => view('page.shop.cart'))->name('cart');
    });
    Route::get('/support', fn () => view('page.support.index'))->name('support.index');
});

    // Auth routes
Route::group([], function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
        Route::post('/login', function () {
            // Xử lý đăng nhập ở đây (placeholder)
            return redirect()->route('home');
        })->name('login.submit');
        Route::get('/register', fn () => view('auth.register'))->name('register');
        Route::post('/register', function () {
            // Xử lý đăng ký ở đây (placeholder)
            return redirect()->route('home');
        })->name('register.submit');
        Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('forgot-password');
        Route::post('/forgot-password', function () {
            // Xử lý gửi email quên mật khẩu ở đây (placeholder)
            return redirect()->route('login');
        })->name('password.email');
        Route::get('/reset-password', fn () => view('auth.reset-password'))->name('reset-password');
    });

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});



Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('admin.dashboard');

    Route::get('/products', function () {
        return view('admin.products.products');
    })->name('admin.products');

    // Route trang sửa sheet nhạc
    Route::get('/products/edit/{id}', function ($id) {
        // Trong thực tế sẽ lấy dữ liệu theo $id
        return view('admin.products.edit');
    })->name('admin.products.edit');

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
    
    Route::post('/logout', function () {

        return redirect()->route('login');
    })->name('logout');
});

// Account section
Route::prefix('account')->group(function () {
    Route::get('/', function () {
        return view('account.index');
    })->name('account.index');
    Route::get('/profile', function () {
        return view('account.profile');
    })->name('account.profile');
    Route::get('/sheets', function () {
        return view('account.sheets');
    })->name('account.sheets');
    Route::get('/posts', function () {
        return view('account.posts');
    })->name('account.posts');
    Route::get('/activity', function () {
        return view('account.activity');
    })->name('account.activity');
    Route::get('/settings', function () {
        return view('account.settings');
    })->name('account.settings');
    // Nạp coin (Deposit) page
    Route::get('/deposit', function () {
        return view('account.deposit');
    })->name('account.deposit');
    // Rút coin (Withdraw) page
    Route::get('/withdraw', function () {
        return view('account.withdraw');
    })->name('account.withdraw');
});
