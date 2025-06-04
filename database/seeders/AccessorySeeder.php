<?php

namespace Database\Seeders;

use App\Models\Accessory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccessorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Accessory::create([
            'name' => 'Basketball',
            'type' => 'toy',
            'price' => 3.00,
            'happiness_effect' => 10,
            'description' => 'A cool ball to play with.',
            'image' => 'basketball.png',
        ]);

        Accessory::create([
            'name' => 'Flower',
            'type' => 'decoration',
            'price' => 2.00,
            'happiness_effect' => 5,
            'description' => 'Brightens up any room.',
            'image' => 'flower.png',
        ]);

        Accessory::create([
            'name' => 'Teddy Bear',
            'type' => 'toy',
            'price' => 8.00,
            'happiness_effect' => 15,
            'description' => 'Cuddly and soft!',
            'image' => 'teddybear.png',
        ]);
    }
}
