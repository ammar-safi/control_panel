<?php

namespace App\Enums;

enum DocumentType: string
{
    case REPORT = 'report';
    case CERTIFICATE = 'certificate';
    case CONTRACT = 'contract';

    public function label(): string
    {
        return match ($this) {
            self::REPORT => 'report',
            self::CERTIFICATE => 'certificate on it',
            self::CONTRACT => 'contract',
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
            self::REPORT => 'gray',
            self::CERTIFICATE => 'warning',
            self::CERTIFICATE => 'info',
            self::CONTRACT => 'success',
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
