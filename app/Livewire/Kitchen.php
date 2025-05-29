<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Kitchen extends Component
{
    public $pet;
    public $coins;
    public $status;
    public $statsList = [];

    public function mount()
    {
        $user = Auth::user()->load('coins', 'pet.status');
        $this->pet = $user->pet;
        $this->coins = $user->coins->balance ?? 0;
        $this->status = $this->pet->status ?? null;

        if ($this->status) {
            $this->statsList = [
                ['icon'=>'hunger.png', 'label'=>'Hunger', 'value'=>$this->status->hunger, 'color'=>'#5b3b0b'],
                ['icon'=>'thirst.png', 'label'=>'Thirst', 'value'=>$this->status->thirst, 'color'=>'#3b82f6'],
                ['icon'=>'sleep.png', 'label'=>'Sleepiness', 'value'=>$this->status->sleepiness, 'color'=>'#1e3a8a'],
                ['icon'=>'clean.png', 'label'=>'Cleanliness', 'value'=>$this->status->cleanliness, 'color'=>'#16a34a'],
            ];
        }
    }

    public function render()
    {
        return view('livewire.kitchen')
        ->layout('layouts.app');
    }
}
