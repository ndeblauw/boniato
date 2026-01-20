<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\WelcomeController::class);

Route::resource('articles', \App\Http\Controllers\ArticleController::class)->only(['index', 'show']);
Route::resource('categories', \App\Http\Controllers\CategoryController::class)->only(['index', 'show']);
Route::resource('authors', \App\Http\Controllers\AuthorController::class)->only(['index', 'show']);

Route::view('search', 'search.form')->name('search.form');

Route::get('dashboard', function () {
    return view('userzone.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Logged in user routes
Route::name('admin.')->prefix('admin')->middleware('auth')->group(function () {
    Route::resource('articles', \App\Http\Controllers\AdminArticleController::class);
    Route::get('articles/{article}/toggle-is-published', \App\Http\Controllers\AdminArticleToggleIsPublishedController::class)->name('articles.publish');;
});

// Admin routes
Route::name('admin.')->prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('categories', \App\Http\Controllers\AdminCategoryController::class);
    Route::get('get-subscriptions', \App\Http\Controllers\AdminSubscriptionExportController::class)->name('subscriptions.export');
});

Route::prefix('haha')->middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
