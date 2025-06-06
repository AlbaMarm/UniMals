<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accessory extends Model
{
    protected $fillable = [
        'name', 
        'type', 
        'price', 
        'happiness_effect', 
        'description',
        'image',
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
