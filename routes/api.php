<?php

use App\Http\Controllers\ShortenUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/shorten', [ShortenUrlController::class, 'shortenLink'])
    ->name('url.shorten');

Route::get('/{code}', [ShortenUrlController::class, 'redirectLink'])
    ->name('shortened.url');
