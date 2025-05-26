<?php

use App\Http\Controllers\PersonalityTestController;
use App\Livewire\Bathroom;
use App\Livewire\Home;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::route('login');
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
        Route::get('/dashboard', Home::class)->name('dashboard');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/bathroom', Bathroom::class)->name('bathroom');
    });


    Route::post('/pet/happiness', function (Request $request) {
        $pet = Auth::user()->pet;

        if ($pet) {
            $pet->happiness = min(100, $pet->happiness + 1);
            $pet->save();

            return response()->json(['happiness' => $pet->happiness]);
        }

        return response()->json(['error' => 'Pet not found'], 404);
    })->name('pet.happiness');
});
