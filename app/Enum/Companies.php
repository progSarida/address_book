<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Companies: string implements HasLabel
{
    case SARIDA = "sarida";
    case STC = "stc";

    public function getLabel(): string
    {
        return match($this) {
            self::SARIDA => 'Sarida',
            self::STC => 'STC'
        };
    }
}
