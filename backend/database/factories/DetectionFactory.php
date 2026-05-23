<?php

namespace Database\Factories;

use App\Enums\Severity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Detection>
 */
class DetectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'disease_name' => fake()->randomElement([
                'Dermatitis', 'Eksim', 'Psoriasis', 'Kurap', 'Jerawat', 'Biduran',
            ]),
            'severity' => fake()->randomElement(Severity::cases())->value,
            'confidence' => fake()->numberBetween(70, 98),
            'detected_area' => fake()->randomElement(['kulit', 'telinga', 'tangan', 'wajah']),
            'notes' => null,
            'detected_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
