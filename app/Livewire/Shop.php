<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Accessory;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Shop extends Component
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
                ['icon' => 'hunger.png', 'label' => 'Hunger', 'value' => $this->status->hunger, 'color' => '#5b3b0b'],
                ['icon' => 'thirst.png', 'label' => 'Thirst', 'value' => $this->status->thirst, 'color' => '#3b82f6'],
                ['icon' => 'sleep.png', 'label' => 'Sleepiness', 'value' => $this->status->sleepiness, 'color' => '#1e3a8a'],
                ['icon' => 'clean.png', 'label' => 'Cleanliness', 'value' => $this->status->cleanliness, 'color' => '#16a34a'],
            ];
        }
    }

    public function buy($accessoryId)
    {
        $user = Auth::user();
        $accessory = Accessory::findOrFail($accessoryId);
        $balance = DB::table('coins')->where('user_id', $user->id)->value('balance') ?? 0;

        if ($balance < $accessory->price) {
            return;
        }

        DB::table('coins')->where('user_id', $user->id)->decrement('balance', $accessory->price);

        Purchase::create([
            'user_id' => $user->id,
            'accessory_id' => $accessory->id,
            'quantity' => 1,
            'total' => $accessory->price,
        ]);

        $user->pet->increment('happiness', $accessory->happiness_effect);
        $this->coins = DB::table('coins')->where('user_id', $user->id)->value('balance');
        return redirect()->route('dashboard')->with('message', 'Has comprado ' . $accessory->name);
    }



    public function render()
    {
        $accessories = Accessory::all();
        return view('livewire.shop', [
            'accessories' => $accessories,
            'isSad' => $this->isSad,
        ])->layout('layouts.app');
    }
}
