<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class petController extends Controller
{
    public function increaseHappiness()
    {
        $pet = Auth::user()->pet;

        if ($pet) {
            $pet->happiness = min(100, $pet->happiness + 1);
            $pet->save();

            return response()->json(['happiness' => $pet->happiness]);
        }

        return response()->json(['error' => 'Pet not found'], 404);
    }

    public function stats()
    {

        $pet = auth()->user()->pet;
        if (!$pet || !$pet->status) {
            return response()->json([
                'hunger' => 0,
                'thirst' => 0,
                'cleanliness' => 0,
                'sleepiness' => 0,
            ]);
        }

        $status = $pet->status;

        return response()->json([
            'hunger' => $status->hunger,
            'thirst' => $status->thirst,
            'cleanliness' => $status->cleanliness,
            'sleepiness' => $status->sleepiness,
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = Auth::user();

        if ($user->pet) {
            $user->pet->status()->delete();
            $user->pet->delete();
            $user->test()->delete();
        }

        Auth::logout();

        return redirect()->route('login')->with('message', 'Your pet has been deleted. Start again!');
    }
}
