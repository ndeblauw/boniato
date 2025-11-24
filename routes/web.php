<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\WelcomeController::class);

Route::get('articles', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{id}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::post('/articles/add-comment', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');


Route::resource('categories', \App\Http\Controllers\CategoryController::class)->only(['index', 'show']);
Route::resource('authors', \App\Http\Controllers\AuthorController::class)->only(['index', 'show']);




Route::get('/dashboard', function () {
    return view('userzone.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('admin/categories', \App\Http\Controllers\AdminCategoryController::class)
    ->middleware('is_admin');

    Route::resource('admin/articles', \App\Http\Controllers\AdminArticleController::class);
    Route::get('admin/articles/{article}/toggle-is-published', \App\Http\Controllers\AdminArticleToggleIsPublishedController::class)->name('articles.publish');;

    Route::get('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
