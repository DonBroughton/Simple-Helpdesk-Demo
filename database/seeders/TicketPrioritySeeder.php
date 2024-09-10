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
                'color' => 'violet-800'
            ],
            [
                'name'  =>  'High',
                'color' => 'red-800'
            ],
            [
                'name'  =>  'Medium',
                'color' => 'orange-800'
            ],
            [
                'name'  =>  'Low',
                'color' => 'green-800'
            ],
        ];

        foreach ($priorities as $priority){
            TicketPriority::create($priority);
        }
    }
}
