<?php

use Illuminate\Support\Facades\Route;

Route::post('mollie/webhook', \App\Http\Controllers\Api\MollieWebhookController::class)->name('api.mollie.webhook');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'index'])->name('api.articles.index');
    Route::get('/articles/{id}', [\App\Http\Controllers\Api\ArticleController::class, 'show'])->name('api.articles.show');

    Route::post('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'store'])->name('api.articles.store');

    Route::get('/authors', [\App\Http\Controllers\Api\AuthorController::class, 'index'])->name('api.authors.index');
    Route::get('/authors/{id}', [\App\Http\Controllers\Api\AuthorController::class, 'show'])->name('api.authors.show');
});
