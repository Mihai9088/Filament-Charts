<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory(1000)->create();

         $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
         $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

         \App\Models\User::factory()->create([
             'name' => 'Useruls',
             'email' => 'mocsha@example.com',
         ]);
    }
}
