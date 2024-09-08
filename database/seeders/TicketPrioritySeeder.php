<?php

namespace Database\Seeders;

use App\Models\TicketPriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            [
                'name'  =>  'Critical',
            ],
            [
                'name'  =>  'High',
            ],
            [
                'name'  =>  'Medium',
            ],
            [
                'name'  =>  'Low',
            ],
        ];

        foreach ($priorities as $priority){
            TicketPriority::create($priority);
        }
    }
}
