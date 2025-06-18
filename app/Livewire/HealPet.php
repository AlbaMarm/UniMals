<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HealPet extends Component
{
    public bool $openModal = false;
    public bool $hasHealed   = false;

    public function curar()
    {
        if ($this->hasHealed) {
            return;
        }

        $pet = Auth::user()->pet;
        if ($pet && $pet->status) {
            $pet->status->update([
                'hunger' => 100,
                'thirst' => 100,
                'sleepiness' => 100,
                'cleanliness' => 100,
            ]);
        }

        $this->hasHealed = true;
        $this->dispatch('refreshComponent');
        $this->cerrar();
    }

    public function cerrar()
    {
        $this->openModal = false;
    }

    public function render()
    {
        return view('livewire.heal-pet');
    }
}
