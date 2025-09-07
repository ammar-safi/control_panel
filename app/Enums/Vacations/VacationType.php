<?php

namespace App\Enums\Vacations;

enum VacationType: string
{
    case ANNUAL = "annual";
    case EMERGENCY = "emergency";
    case MATERNITY = "maternity";
    case PATERNITY = "paternity";
    case UNPAID = "unpaid";

    public function label(): string
    {
        return match ($this) {
            self::ANNUAL => 'annual',
            self::EMERGENCY => 'emergency',
            self::MATERNITY => 'maternity',
            self::PATERNITY => 'paternity',
            self::UNPAID => 'unpaid',
        };
    }
    public static function asSelectArray(): array
    {
        return array_reduce(
            self::cases(),
            fn($carry, $case) => $carry + [$case->value => $case->label()],
            []
        );
    }


}
