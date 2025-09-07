<?php

namespace App\Enums\Vacations;

enum VacationStatus: String
{
    case PENDING = "pending";
    case APPROVED = "approved";
    case REJECTED = "rejected";


    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::APPROVED => 'approved',
            self::REJECTED => 'rejected',
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

    public function badgeColor(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::REJECTED => 'danger',
            self::APPROVED => 'success',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::REJECTED => 'heroicon-o-x-circle',
            self::APPROVED => 'heroicon-o-check-circle',
        };
    }
}
