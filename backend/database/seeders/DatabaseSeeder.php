<?php

namespace Database\Seeders;

use App\Enums\Severity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed a demo account ("Wowo", matching the frontend mockups) with a couple
     * of dummy detections in their history.
     */
    public function run(): void
    {
        $wowo = User::firstOrCreate(
            ['email' => 'wowo@example.com'],
            ['name' => 'Wowo', 'password' => 'password'],
        );

        if ($wowo->detections()->count() === 0) {
            $wowo->detections()->createMany([
                [
                    'disease_name' => 'Dermatitis',
                    'severity' => Severity::Mild->value,
                    'confidence' => 90,
                    'detected_area' => 'telinga',
                    'detected_at' => now(),
                ],
                [
                    'disease_name' => 'Jerawat',
                    'severity' => Severity::Moderate->value,
                    'confidence' => 78,
                    'detected_area' => 'wajah',
                    'detected_at' => now()->subDays(3),
                ],
            ]);
        }
    }
}
