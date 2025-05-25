<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PetStatus extends Model
{
    protected $fillable = [
        'pet_id',
        'hunger',
        'thirst',
        'cleanliness',
        'sleepiness'
    ];

    // Relaciones

    // Con pet
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
