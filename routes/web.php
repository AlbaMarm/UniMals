<?php

use App\Http\Controllers\PersonalityTestController;
use App\Http\Controllers\PetActionController;
use App\Http\Controllers\petController;
use App\Http\Controllers\ShopController;
use App\Livewire\Bathroom;
use App\Livewire\Home;
use App\Livewire\Kitchen;
use App\Livewire\Room;
use App\Livewire\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

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

    Route::middleware(['auth', 'verified', 'hasTest'])->group(function () {
        Route::get('/dashboard', Home::class)->name('dashboard');
        Route::get('/bathroom', Bathroom::class)->name('bathroom');
        Route::get('/kitchen', Kitchen::class)->name('kitchen');
        Route::get('/room', Room::class)->name('room');
        Route::get('/shop', Shop::class)->name('shop');

        Route::post('/pet/happiness', [PetActionController::class, 'increaseHappiness'])->name('pet.happiness');

        Route::post('/pet/rename', [PetActionController::class, 'rename'])->name('pet.rename');

        /* Ruta Web dormir */
        Route::post('/pet/sleep', [PetActionController::class, 'sleep'])->name('pet.sleep');

        /* Ruta Web comer */
        Route::post('/pet/eat', [PetActionController::class, 'eat'])->name('pet.eat');

        /* Ruta Web beber */
        Route::post('/pet/drink', [PetActionController::class, 'drink'])->name('pet.drink');

        /* Ruta Web bañar */
        Route::post('/pet/bathe', [PetActionController::class, 'bathe'])->name('pet.bathe');

        Route::get('/pet/stats', [PetController::class, 'stats'])->name('pet.stats');

        Route::get('/shop', Shop::class)->name('shop');

        /* Ruta para matar mascota :c */
        Route::delete('/pet/delete', [PetController::class, 'destroy'])->name('pet.destroy');
    });
});
