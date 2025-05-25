<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetType extends Model
{
    protected $fillable = [
        'name',
        'sprite_idle',
        'sprite_sleeping',
        'sprite_eating',
        'sprite_drinking',
        'sprite_happy',
        'sprite_sad',
        'description'
    ];

    // Relaciones

    // Con pets
    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }
}
