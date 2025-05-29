<?php

use App\Http\Controllers\PersonalityTestController;
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

    Route::middleware('hasTest')->group(function () {
        Route::get('/dashboard', Home::class)->name('dashboard');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/bathroom', Bathroom::class)->name('bathroom');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/kitchen', Kitchen::class)->name('kitchen');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/room', Room::class)->name('room');
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/shop', Shop::class)->name('shop');
    });

    Route::post('/pet/happiness', function (Request $request) {
        $user = Auth::user();
        $pet = $user->pet;

        if ($pet) {
            $lastHappiness = $pet->getOriginal('happiness');
            $pet->happiness = min(1000, $pet->happiness + 1);
            $pet->save();

            $coinsEarned = 0;

            if (floor($pet->happiness / 10) > floor($lastHappiness / 10)) {
                // Este bloque asegura que actualizas o creas la fila (sin duplicar)
                $existing = DB::table('coins')->where('user_id', $user->id)->first();

                if ($existing) {
                    DB::table('coins')->where('user_id', $user->id)->increment('balance');
                } else {
                    DB::table('coins')->insert([
                        'user_id' => $user->id,
                        'balance' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $coinsEarned = 1;
            }

            // Vuelve a consultar el balance actual
            $balance = DB::table('coins')->where('user_id', $user->id)->value('balance');

            return response()->json([
                'happiness' => $pet->happiness,
                'balance' => $balance,
                'earned' => $coinsEarned,
            ]);
        }

        return response()->json(['error' => 'Pet not found'], 404);
    })->name('pet.happiness');

    Route::post('/pet/rename', function (Illuminate\Http\Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $pet = Auth::user()->pet;
        if ($pet) {
            $pet->name = $request->name;
            $pet->save();
            return redirect()->back()->with('message', 'Pet name updated successfully!');
        }

        return redirect()->back()->with('error', 'No pet found.');
    })->name('pet.rename');
});
