<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Bathroom extends Component
{
    public $pet;
    public $coins;
    public $status;
    public $statsList = [];
    public $isSad = false;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $user = Auth::user()->load('coins', 'pet.status');
        $this->pet = $user->pet;
        $this->coins = DB::table('coins')->where('user_id', Auth::id())->value('balance') ?? 0;
        $this->status = $this->pet->status ?? null;
        if ($this->status) {
            $this->isSad =
                $this->status->hunger < 30 ||
                $this->status->thirst < 30 ||
                $this->status->sleepiness < 30 ||
                $this->status->cleanliness < 30;
        }

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
        return view('livewire.bathroom', [
            'isSad' => $this->isSad,
        ])
        ->layout('layouts.app');
    }
}
