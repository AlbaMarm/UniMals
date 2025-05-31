<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetActionController extends Controller
{
    public function increaseHappiness()
    {
        $user = Auth::user();
        $pet = $user->pet;

        if ($pet) {
            $lastHappiness = $pet->getOriginal('happiness');
            $pet->happiness = min(1000, $pet->happiness + 1);

            $leveledUp = false;
            $oldLevel = $pet->level;
            $newLevel = floor($pet->happiness / 100) + 1;
            if ($newLevel > $oldLevel) {
                $pet->level = $newLevel;
                $leveledUp = true;
            }

            $pet->save();

            $coinsEarned = 0;

            if (floor($pet->happiness / 10) > floor($lastHappiness / 10)) {
                // actualizar o crear
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

            // balance actual
            $balance = DB::table('coins')->where('user_id', $user->id)->value('balance');

            return response()->json([
                'happiness' => $pet->happiness,
                'balance' => $balance,
                'earned' => $coinsEarned,
                'leveledUp' => $leveledUp,
                'level' => $pet->level,
            ]);
        }

        return response()->json(['error' => 'Pet not found'], 404);
    }

    public function rename(Request $request)
    {
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
    }

    public function sleep()
    {
        $user = Auth::user();
        $status = $user->pet->status;

        if ($status) {
            $status->sleepiness = min(100, $status->sleepiness + 40);
            $status->save();

            return response()->json([
                'success' => true,
                'sleepiness' => $status->sleepiness
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function eat()
    {
        $user = Auth::user();
        $status = $user->pet->status;

        if ($status) {
            $status->hunger = min(100, $status->hunger + 20);
            $status->save();

            return response()->json([
                'success' => true,
                'hunger' => $status->hunger
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function drink()
    {
        $user = Auth::user();
        $status = $user->pet->status;

        if ($status) {
            $status->thirst = min(100, $status->thirst + 20);
            $status->save();

            return response()->json([
                'success' => true,
                'thirst' => $status->thirst
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function bathe()
    {
        $user = Auth::user();
        $status = $user->pet->status;
        if ($status) {
            $status->cleanliness = min(100, $status->cleanliness + 40);
            $status->save();

            return response()->json([
                'success' => true,
                'cleanliness' => $status->cleanliness
            ]);
        }
        return response()->json(['success' => false], 404);
    }
}
