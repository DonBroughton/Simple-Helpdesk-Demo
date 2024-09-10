<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            [
                'user_id'  =>  '1',
                'title'  =>  'First Support Ticket',
                'description' => 'I think I have discovered a bug. It happens when I click the menu on the home page',
                'priority_id' => 2, // high
                'is_open'  =>  false, // this ticket is closed
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'user_id'  =>  '1',
                'title'  =>  'Second Support Ticket',
                'description' => 'I have lost all my work!',
                'priority_id' => 1, // critical
                'is_open'  =>  true, // this ticket is open
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'user_id'  =>  '1',
                'title'  =>  'Third Support Ticket',
                'description' => 'I have a suggestion for a new feature',
                'priority_id' => 4, // low
                'is_open'  =>  true, // this ticket is open
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id'  =>  '3',
                'title'  =>  'This ticket was created by a secondary user',
                'description' => 'This is a sample body content for a ticket issue.',
                'priority_id' => 1, // low
                'is_open'  =>  true, // this ticket is open
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach($tickets as $ticket){
            Ticket::create($ticket);
        }
    }
}
