<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentDate = Carbon::now();
       

        // Data de acum o lună
        $oneMonthAgo = $currentDate->copy()->subMonth();

        // Generare utilizatori pentru seed
        User::factory()->count(100) // Schimbă numărul 10 cu câți utilizatori dorești
            ->create([
                'created_at' => $oneMonthAgo,
                'name' => 'Useruvfdls',
                'email' => 'mocshdssa@example.com', // Setează data de creare a utilizatorilor la acum o lună
            ]);
    }
}
