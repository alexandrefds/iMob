<?php

namespace App\Enums;

enum AnnouncementTypeEnum: string
{
    case HOUSE = 'house';
    case APARTMENT = 'apartment';
    case FARM = 'farm';
    case LAND = 'land';

    public function label(): string
    {
        return match($this) {
            self::HOUSE => 'Casa',
            self::APARTMENT => 'Apartamento',
            self::FARM => 'Fazenda',
            self::LAND => 'Terreno',
        };
    }

    public static function toArray(): array
    {
        return [
            self::HOUSE->value => self::HOUSE->label(),
            self::APARTMENT->value => self::APARTMENT->label(),
            self::FARM->value => self::FARM->label(),
            self::LAND->value => self::LAND->label(),
        ];
    }
}
