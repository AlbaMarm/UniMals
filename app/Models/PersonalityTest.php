<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalityTest extends Model
{
    protected $fillable = [
        'result',
        'user_id'
    ];

    // Relaciones

    // Con user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
