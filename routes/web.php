<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\WelcomeController::class, 'index']);

Route::get('articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{id}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');

Route::get('categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
Route::post('categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');

Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::get('categories/{id}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');



Route::get('/dashboard', function () {
    return view('userzone.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
