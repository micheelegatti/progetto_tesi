<?php

namespace App\Enum;

enum TipoInvio: string
{
    case Test = 'Test';
    case Ordinario = 'Ordinario';

    public function label(): string
    {
        return match($this) {
            self::Test => 'Test',
            self::Ordinario => 'Ordinario',
        };
    }
}