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
        User::factory()->create([
            'name' => 'mohammad',
            'email' => 'mohammad@gmail.com',
            'password' => bcrypt('12341234')
        ]);

        $this->call(TicketSeeder::class);
    }
}
