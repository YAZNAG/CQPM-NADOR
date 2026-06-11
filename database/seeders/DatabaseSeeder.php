<?php

namespace Database\Seeders;
// CqpmAdmin@2024

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
        ]);

        $this->call([
            SiteSettingSeeder::class,
            MenuSeeder::class,
            PageSeeder::class,
            FiliereSeeder::class,
            NewsSeeder::class,
            EventSeeder::class,
            MediaSeeder::class,
            DocumentSeeder::class,
        ]);
    }
}
