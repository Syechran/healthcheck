<?php

namespace App\Enums;

/**
 * Severity of a detected illness. Backed values are stored in the DB;
 * label() returns the Indonesian text the frontend displays (e.g. "Ringan").
 */
enum Severity: string
{
    case Mild = 'mild';
    case Moderate = 'moderate';
    case Severe = 'severe';

    public function label(): string
    {
        return match ($this) {
            self::Mild => 'Ringan',
            self::Moderate => 'Sedang',
            self::Severe => 'Berat',
        };
    }
}
