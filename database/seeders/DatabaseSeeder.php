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
            // do php artisan migrate:fresh --seed
        ]);

        User::factory()->create([
            'name' => 'test',
            'email' => 'test@example.com'
        ]);

        User::factory()->create([
            'name' => 'PRUEBA',
            'email' => 'cdelvalle@example.org'
        ]);

        $this->call([PetTypeSeeder::class]);
    }
}
