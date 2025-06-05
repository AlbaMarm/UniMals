<?php

namespace App\Livewire;

use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Home extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];
    public $pet;
    public $lastAccessory;
    public $accessorySummary = [];
    public $isSad = false;

    public function mount()
    {
        $user = Auth::user()->load('pet.status');
        $this->pet = $user->pet;

        $this->lastAccessory = Purchase::with('accessory')
            ->where('user_id', Auth::id())
            ->latest()
            ->first()?->accessory;

        $this->accessorySummary = Purchase::with('accessory')
            ->where('user_id', Auth::id())
            ->get()
            ->groupBy(fn($p) => $p->accessory->name)
            ->map(fn($group) => $group->count());
    }


    public function render()
    {
        $user = Auth::user()->load('coins', 'pet.status');
        $pet = $user->pet;
        $coins = DB::table('coins')->where('user_id', Auth::id())->value('balance') ?? 0;
        $status = $pet->status ?? null;
        if ($status) {
            $this->isSad =
                $status->hunger < 30 ||
                $status->thirst < 30 ||
                $status->sleepiness < 30 ||
                $status->cleanliness < 30;
        }


        $statsList = [
            ['icon' => 'hunger.png', 'label' => 'Hunger', 'value' => $status->hunger ?? 0, 'color' => '#5b3b0b'],
            ['icon' => 'thirst.png', 'label' => 'Thirst', 'value' => $status->thirst ?? 0, 'color' => '#3b82f6'],
            ['icon' => 'sleep.png', 'label' => 'Sleepiness', 'value' => $status->sleepiness ?? 0, 'color' => '#1e3a8a'],
            ['icon' => 'clean.png', 'label' => 'Cleanliness', 'value' => $status->cleanliness ?? 0, 'color' => '#16a34a'],
        ];

        return view('livewire.home', [
            'pet' => $pet,
            'coins' => $coins,
            'statsList' => $statsList,
            'lastAccessory' => $this->lastAccessory,
            'accessorySummary' => $this->accessorySummary,
            'isSad' => $this->isSad,
        ])->layout('layouts.app');
    }
}
