<?php

namespace App\Enums;

enum LocationType: string
{
    case Building = 'building';
    case Floor = 'floor';
    case Room = 'room';
    case Stockroom = 'stockroom';
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
