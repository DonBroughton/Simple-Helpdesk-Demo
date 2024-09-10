<?php

namespace Database\Seeders;

use App\Models\TicketReply;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticketReplies = [
            [
                'user_id'  =>  2,
                'ticket_id'  =>  1,
                'body' => 'Thanks! That is a bug, we have fixed it, closing this ticket ticket.',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
            ],
            [
                'user_id'  =>  2,
                'ticket_id'  =>  2,
                'body' => 'Lost your work? Could you please tell me a little more about how that happened?',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'user_id'  =>  1,
                'ticket_id'  =>  2,
                'body' => 'Never mind. Thanks, I found all my work.',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ];

        foreach ($ticketReplies as $reply) {
            TicketReply::create($reply);
        }
    }
}
