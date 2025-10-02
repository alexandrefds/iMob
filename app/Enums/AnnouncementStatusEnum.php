<?php

namespace App\Enums;

enum AnnouncementStatusEnum: string
{
    case DRAFT = 'draft';
    case INFORMATION = 'information';
    case LOCATION = 'location';
    case PRICES = 'prices';
    case IMAGES = 'images';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Rascunho',
            self::INFORMATION => 'Informações',
            self::LOCATION => 'Localização',
            self::PRICES => 'Preços',
            self::IMAGES => 'Imagens',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::DRAFT => 'Anúncio em fase inicial de criação',
            self::INFORMATION => 'Preenchendo informações básicas do anúncio',
            self::LOCATION => 'Definindo localização e endereço',
            self::PRICES => 'Configurando preços e condições',
            self::IMAGES => 'Adicionando imagens e mídias',
        };
    }

    public static function toArray(): array
    {
        return [
            self::DRAFT->value => self::DRAFT->label(),
            self::INFORMATION->value => self::INFORMATION->label(),
            self::LOCATION->value => self::LOCATION->label(),
            self::PRICES->value => self::PRICES->label(),
            self::IMAGES->value => self::IMAGES->label(),
        ];
    }
}
