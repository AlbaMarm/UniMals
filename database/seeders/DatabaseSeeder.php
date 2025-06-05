<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'User',
            'email' => 'alba@gmail.com',
            'is_admin' => true,
            // do php artisan migrate:fresh --seed
        ]);

        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);

        User::factory()->create([
            'name' => 'PRUEBA',
            'email' => 'cdelvalle@example.org',
            'is_admin' => true,
        ]);

        $this->call([PetTypeSeeder::class]);
        $this->call([AccessorySeeder::class]);
    }
}
