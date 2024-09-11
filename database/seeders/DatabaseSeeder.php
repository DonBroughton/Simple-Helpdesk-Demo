<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding is only required in a local environment as it contains weak user passwords
        if (App::environment('local') || App::environment('testing')) {
            $this->call([
                UserSeeder::class,
                TicketPrioritySeeder::class,
                TicketSeeder::class,
                TicketReplySeeder::class,
            ]);
        } else {
            $this->command->info('App is not marked as `local`, Skipping Seeding.');
        }
    }
}
