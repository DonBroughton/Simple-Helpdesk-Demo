<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'  =>  $this->faker->words(mt_rand(3, 7), true), // between 3 and 7 words, as string
            'user_id'  =>  1,
            'description'  =>  $this->faker->paragraph(12),
            'priority_id' => mt_rand(1, 4),
            'is_open' => mt_rand(0, 1),
        ];
    }
}
