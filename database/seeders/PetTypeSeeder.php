<?php

namespace Database\Seeders;

use App\Models\PetType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PetType::insert([
            [
                'name' => 'hamster',
                'description' => 'A sleepy hamster that loves to eat and drink.',
                'sprite_idle' => 'hamsterKoko_idle.png',
                'sprite_sleeping' => 'hamsterKoko_sleeping.png',
                'sprite_eating' => 'hamsterKoko_eating.png',
                'sprite_drinking' => 'hamsterKoko_drinking.png',
                'sprite_happy' => 'hamsterKoko_happy.png',
                'sprite_sad' => 'hamsterKoko_sad.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'fox',
                'description' => 'A calm fox that enjoys attention and pets.',
                'sprite_idle' => 'foxGarnel_idle.png',
                'sprite_sleeping' => 'foxGarnel_sleeping.png',
                'sprite_eating' => 'foxGarnel_eating.png',
                'sprite_drinking' => 'foxGarnel_drinking.png',
                'sprite_happy' => 'foxGarnel_happy.png',
                'sprite_sad' => 'foxGarnel_sad.png',
                'created_at' => now(),
                'updated_at' => now(),

            ], 
            [
                'name' => 'seal',
                'description' => 'A playful seal that loves to sleep and be cherised.',
                'sprite_idle' => 'sealLoope_idle.png',
                'sprite_sleeping' => 'sealLoope_sleeping.png',
                'sprite_eating' => 'sealLoope_eating.png',
                'sprite_drinking' => 'sealLoope_drinking.png',
                'sprite_happy' => 'sealLoope_happy.png',
                'sprite_sad' => 'ºsealLoope_sad.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],



        ]);
    }
}
