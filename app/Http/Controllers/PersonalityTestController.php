<?php

namespace App\Http\Controllers;

use App\Models\PersonalityTest;
use App\Models\Pet;
use App\Models\PetType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalityTestController extends Controller
{
    public function show(Request $request, $step = 1)
    {
        //english es el default
        $lang = $request->query('lang', 'en');
        return view("personality.test.step{$step}", compact('lang'));
    }

    public function store(Request $request, $step)
    {
        session(["question{$step}" => $request->input("question{$step}")]);

        if ($step < 3) {
            return redirect()->route('personality.test', ['step' => $step + 1]);
        }

        return $this->finishTest();
    }

    private function finishTest()
    {
        /** @var \App\Models\User $user */ //hay que poner esto para que no de error
        $user = Auth::user();

        if ($user->test || $user->pet) {
            return redirect()->route('dashboard');
        }

        $q1 = session('question1');
        $q2 = session('question2');
        $q3 = session('question3');

        $answers = [$q1, $q2, $q3];
        $counts = array_count_values($answers);
        arsort($counts);
        $result = array_key_first($counts);

        PersonalityTest::create([
            'user_id' => $user->id,
            'result' => $result,
        ]);

        $petType = PetType::where('name', $result)->first();
        if (!$petType) abort(500, "Pet type '$result' not found.");

        $pet = Pet::create([
            'user_id' => $user->id,
            'pet_type_id' => $petType->id,
            'name' => ucfirst($result),
            'test_result' => $result,
            'happiness' => 0,
            'level' => 1,
        ]);

        $pet->status()->create([
            'hunger' => 100,
            'thirst' => 100,
            'cleanliness' => 100,
            'sleepiness' => 100,
        ]);

        /* $user->coins()->create([
            'balance' => 0
        ]); */


        $user->refresh();

        session()->forget(['question1', 'question2', 'question3']);

        Auth::setUser($user->fresh());
        return redirect()
            ->route('dashboard')
            ->with('pet_result', $result);
    }
}
