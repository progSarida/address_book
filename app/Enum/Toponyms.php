<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Toponyms: string implements HasLabel
{
    case NESSUNO = "";
    case VIA = "via";
    case VIALE = "viale";
    case CORSO = "corso";
    case PIAZZA = "piazza";
    case STRADA = "strada";
    case PRIVATA = "privata";
    case PIAZZALE = "piazzale";
    case VICO = "vico";
    case SALITA = "salita";
    case CALLA = "calla";
    case CAMPO = "campo";
    case LARGO = "largo";
    case CIRCONVALLAZIONE = "circonvallazione";
    case TANGENZIALE = "tangenziale";
    case PIAZZETTA = "piazzetta";
    case CAMPIELLO = "campiello";
    case VICOLO = "vicolo";
    case BORGO = "borgo";
    case LOCALITA = "localita";
    case AVENUE = "avenue";

    public function getLabel(): string
    {
        return match($this) {
            self::NESSUNO => '',
            self::VIA => 'Via',
            self::VIALE => 'Viale',
            self::CORSO => 'Corso',
            self::PIAZZA => 'Piazza',
            self::STRADA => 'Strada',
            self::PRIVATA => 'Via Privata',
            self::PIAZZALE => 'Piazzale',
            self::VICO => 'Vico',
            self::SALITA => 'Salita',
            self::CALLA => 'Calla',
            self::CAMPO => 'Campo',
            self::LARGO => 'Largo',
            self::CIRCONVALLAZIONE => 'Circinvallazione',
            self::TANGENZIALE => 'Tangenziale',
            self::PIAZZETTA => 'Piazzetta',
            self::CAMPIELLO => 'Campiello',
            self::VICOLO => 'Vicolo',
            self::BORGO => 'Borgo',
            self::LOCALITA => 'Localita',
            self::AVENUE => 'Avenue'
        };
    }

    public function getAcronym(): string
    {
        return match($this) {
            self::NESSUNO => '',
            self::VIA => 'V.',
            self::VIALE => 'V.le',
            self::CORSO => 'C.so',
            self::PIAZZA => 'P.za',
            self::STRADA => 'Str.',
            self::PRIVATA => 'V. Priv.',
            self::PIAZZALE => 'P.le',
            self::VICO => 'Vico',
            self::SALITA => 'Sal.',
            self::CALLA => 'Calla',
            self::CAMPO => 'Campo',
            self::LARGO => 'L.',
            self::CIRCONVALLAZIONE => 'Circ.',
            self::TANGENZIALE => 'Tang.',
            self::PIAZZETTA => 'P.ta',
            self::CAMPIELLO => 'Camp.',
            self::VICOLO => 'V.lo',
            self::BORGO => 'Borgo',
            self::LOCALITA => 'Loc.',
            self::AVENUE => 'Av.'
        };
    }
}
