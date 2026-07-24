<?php

namespace App\Enum;

enum StatoIscrizione: string
{
    case Iscritto = 'Iscritto';
    case Disiscritto = 'Disiscritto';

    public function label(): string
    {
        return match($this) {
            self::Iscritto => 'Iscritto',
            self::Disiscritto => 'Disiscritto',
        };
    }
}
