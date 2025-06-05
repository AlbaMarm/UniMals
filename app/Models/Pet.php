<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'test_result',
        'happiness',
        'level',
        'pet_type_id',
        'user_id'
    ];

    // Relaciones

    // Con user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Con pet_type
    public function petType(): BelongsTo
    {
        return $this->belongsTo(PetType::class);
    }

    // Con pet_status
    public function status(): HasOne
    {
        return $this->hasOne(PetStatus::class);
    }



}
