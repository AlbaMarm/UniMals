<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $fillable = [
        'user_id', 
        'accessory_id', 
        'quantity', 
        'total'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accessory(): BelongsTo
    {
        return $this->belongsTo(Accessory::class);
    }
}
