<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TransactionController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/products/{product}/like', [LikeController::class, 'toggle'])->name('products.like');
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('products.comments.store');

    Route::post('/products/{product}/checkout', [TransactionController::class, 'checkout'])->name('products.checkout');
    Route::get('/products/{product}/purchase/complete', [TransactionController::class, 'complete'])
        ->name('products.purchase.complete');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile.show');
});

Route::get('/products/{product}/purchase', [TransactionController::class, 'create'])->name('products.purchase');

Route::post('/register', [RegisterController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/profile/edit-temp', [ProfileController::class, 'editTemp'])->name('profile.edit_temp');
Route::post('/profile/update-temp', [ProfileController::class, 'updateTemp'])->name('profile.update_temp');