<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    
    public function render()
    {
        $user = Auth::user();
        $pet = $user->pet;
        $coins = $user->coins->balance ?? 0;
        $status = $pet->status ?? null;

        $statsList = [
            ['icon'=>'hunger.png', 'label'=>'Hunger', 'value'=>$status->hunger, 'color'=>'#5b3b0b'],
            ['icon'=>'thirst.png', 'label'=>'Thirst', 'value'=>$status->thirst, 'color'=>'#3b82f6'],
            ['icon'=>'sleep.png', 'label'=>'Sleepiness','value'=>$status->sleepiness,'color'=>'#1e3a8a'],
            ['icon'=>'clean.png', 'label'=>'Cleanliness','value'=>$status->cleanliness,'color'=>'#16a34a'],
        ];
        return view('livewire.home', compact('pet', 'coins', 'statsList'))
        ->layout('layouts.app');
    }
}
