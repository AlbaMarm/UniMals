<?php

use App\Http\Controllers\PersonalityTestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/test/{step?}', [PersonalityTestController::class, 'show'])
        ->name('personality.test');
    Route::post('/test/{step}', [PersonalityTestController::class, 'store']);

   Route::middleware('hasTest')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
});