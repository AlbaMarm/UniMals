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
                'sprite_idle' => 'images/sprites/hamster/hamsterKoko_idle.png',
                'sprite_sleeping' => 'images/sprites/hamster/hamsterKoko_sleeping.png',
                'sprite_eating' => 'images/sprites/hamster/hamsterKoko_eating.png',
                'sprite_drinking' => 'images/sprites/hamster/hamsterKoko_drinking.png',
                'sprite_happy' => 'images/sprites/hamster/hamsterKoko_happy.png',
                'sprite_sad' => 'images/sprites/hamster/hamsterKoko_sad.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'fox',
                'description' => 'A calm fox that enjoys attention and pets.',
                'sprite_idle' => 'images/sprites/fox/foxGarnel_idle.png',
                'sprite_sleeping' => 'images/sprites/fox/foxGarnel_sleeping.png',
                'sprite_eating' => 'images/sprites/fox/foxGarnel_eating.png',
                'sprite_drinking' => 'images/sprites/fox/foxGarnel_drinking.png',
                'sprite_happy' => 'images/sprites/fox/foxGarnel_happy.png',
                'sprite_sad' => 'images/sprites/fox/foxGarnel_sad.png',
                'created_at' => now(),
                'updated_at' => now(),

            ], 
            [
                'name' => 'seal',
                'description' => 'A playful seal that loves to sleep and be cherised.',
                'sprite_idle' => 'images/sprites/seal/sealLoope_idle.png',
                'sprite_sleeping' => 'images/sprites/seal/sealLoope_sleeping.png',
                'sprite_eating' => 'images/sprites/seal/sealLoope_eating.png',
                'sprite_drinking' => 'images/sprites/seal/sealLoope_drinking.png',
                'sprite_happy' => 'images/sprites/seal/sealLoope_happy.png',
                'sprite_sad' => 'images/sprites/seal/sealLoope_sad.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],



        ]);
    }
}
