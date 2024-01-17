<?php
// database/seeders/EventsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Faker\Factory as Faker;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) { // Adjust the number of events you want to create
            Event::create([
                'name' => $faker->sentence,
                'location' => $faker->city,
                'description' => $faker->paragraph,
                'date' => $faker->date,
                'time' => $faker->time,
                'standart_ticket_id' => random_int(1, 5), // Assuming there are tickets with IDs 1 to 5
                'premium_ticket_id' => random_int(1, 5),
                'vip_ticket_id' => random_int(1, 5),
            ]);
        }
    }
}

