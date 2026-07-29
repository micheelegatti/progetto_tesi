<?php

namespace App\Enum;

enum StatoCampagna: string
{
    case Bozza = 'Bozza';
    case InvioProgrammato = 'Invio programmato';
    case Inviata = 'inviata';

    public function label(): string
    {
        return match($this) {
            self::Bozza => 'Bozza',
            self::InvioProgrammato => 'Invio programmato',
            self::Inviata=>'Inviata'
        };
    }
}
