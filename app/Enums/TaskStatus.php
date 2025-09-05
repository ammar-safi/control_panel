<?php

namespace App\Enums;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case WORKING_ON_IT = 'working_on_it';
    case COMPLETED = 'completed';
    case DONE = 'done';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::WORKING_ON_IT => 'working on it',
            self::COMPLETED => 'completed',
            self::DONE => 'done',
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
            self::WORKING_ON_IT => 'warning',
            self::COMPLETED => 'info',
            self::DONE => 'success',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-o-clock',
            self::WORKING_ON_IT => 'heroicon-o-clock',
            self::COMPLETED => 'heroicon-o-check-circle',
            self::DONE => 'heroicon-o-check-circle',
        };
    }
}
