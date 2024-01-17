<?php
// database/seeders/TicketsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Faker\Factory as Faker;

class TicketsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) { // Adjust the number of tickets you want to create
            Ticket::create([
                'quantity' => random_int(50, 200),
                'price' => $faker->randomFloat(2, 20, 100), // Random price between 20 and 100 with 2 decimal places
            ]);
        }
    }
}
