<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum Titles: string implements HasLabel
{
    case NESSUNO = "";
    case ENTE_PUBBLICO = "ente_pubblico";
    case GUARDIA_FINANZA = "guardia_finanza";
    case CONCESSIONARIO = "concessionario";
    case DIPENDENTE = "dipendente";
    case ASSOCIAZIONE = "associazione";
    case PROGRAMMATORE = "programmatore";
    case FORNITORE = "fornitore";
    case CONSORZIO = "consorzio";
    case TRIBUTARIA_PROVINCIALE = "tributaria_provinciale";
    case TRIBUTARIA_REGIONALE = "tributaria_regionale";
    case STUDIO_NOTARILE = "studio_notarile";
    case BANCA = "banca";
    case COLLABORATORE = "collaboratore";
    case COMMERCIALISTA = "commercialista";
    case CONSULENTE_LAVORO = "consulente_lavoro";
    case TRIBUNALE = "tribunale";
    case GIUDICE_PACE = "giudice_pace";
    case SEGRETARIO_COMUNALE = "segretario_comunale";
    case ASSICURAZIONE = "assicurazione";
    case NOLEGGIO = "noleggio";
    case AMICI = "amici";
    case UFFICIALE_RISCOSSIONE = "ufficiale_riscossione";
    case COMUNE = "comune";
    case AFFISSATORE = "affissatore";
    case STUDIO_LEGALE = "studio_legale";
    case GEOMETRA = "geometra";

    public function getLabel(): string
    {
        return match($this) {
            self::NESSUNO => '',
            self::ENTE_PUBBLICO => 'Ente Pubblico',
            self::GUARDIA_FINANZA => 'Guardia di Finanza',
            self::CONCESSIONARIO => 'Concessionario',
            self::DIPENDENTE => 'Dipendente',
            self::ASSOCIAZIONE => 'Associazione',
            self::PROGRAMMATORE => 'Programmatore',
            self::FORNITORE => 'Fornitore',
            self::CONSORZIO => 'Consorzio',
            self::TRIBUTARIA_PROVINCIALE => 'Commissione Tributaria Provinciale',
            self::TRIBUTARIA_REGIONALE => 'Commissione Tributarie Regionale',
            self::STUDIO_NOTARILE => 'Studio Notarile',
            self::BANCA => 'Banca',
            self::COLLABORATORE => 'Collaboratore',
            self::COMMERCIALISTA => 'Studio Commercialista',
            self::CONSULENTE_LAVORO => 'Studio Consulente Lavoro',
            self::TRIBUNALE => 'Tribunale',
            self::GIUDICE_PACE => 'Giudice di Pace',
            self::SEGRETARIO_COMUNALE => 'Segretario Comunale',
            self::ASSICURAZIONE => 'Assicurazione',
            self::NOLEGGIO => 'Noleggio',
            self::AMICI => 'Amici',
            self::UFFICIALE_RISCOSSIONE => 'Ufficiale della riscossione',
            self::COMUNE => 'Comune',
            self::AFFISSATORE => 'Affissatore',
            self::STUDIO_LEGALE => 'Studio Legale',
            self::GEOMETRA => 'Geometra',
        };
    }

    public function getAcronym(): string
    {
        return match($this) {
            self::NESSUNO => '',
            self::ENTE_PUBBLICO => 'E.P.',
            self::GUARDIA_FINANZA => 'GdF',
            self::CONCESSIONARIO => 'Conc.',
            self::DIPENDENTE => 'Dip.',
            self::ASSOCIAZIONE => 'Ass.',
            self::PROGRAMMATORE => 'Prog.',
            self::FORNITORE => 'Forn.',
            self::CONSORZIO => 'Cons.',
            self::TRIBUTARIA_PROVINCIALE => 'CTP',
            self::TRIBUTARIA_REGIONALE => 'CTR',
            self::STUDIO_NOTARILE => 'S.N.',
            self::BANCA => 'Banca',
            self::COLLABORATORE => 'Coll.',
            self::COMMERCIALISTA => 'S.C.',
            self::CONSULENTE_LAVORO => 'S.C.L.',
            self::TRIBUNALE => 'Trib.',
            self::GIUDICE_PACE => 'GDP',
            self::SEGRETARIO_COMUNALE => 'SC',
            self::ASSICURAZIONE => 'Assic.',
            self::NOLEGGIO => 'Nol.',
            self::AMICI => 'AM',
            self::UFFICIALE_RISCOSSIONE => 'UF',
            self::COMUNE => 'COM',
            self::AFFISSATORE => 'AF',
            self::STUDIO_LEGALE => 'S.L.',
            self::GEOMETRA => 'Geom.',
        };
    }

    public function getId(): string
    {
        return match($this) {
            self::NESSUNO => 1,
            self::ENTE_PUBBLICO => 2,
            self::CONCESSIONARIO => 3,
            self::ASSOCIAZIONE => 5,
            self::DIPENDENTE => 6,
            self::PROGRAMMATORE => 7,
            self::CONSORZIO => 9,
            self::TRIBUTARIA_PROVINCIALE => 10,
            self::TRIBUTARIA_REGIONALE => 11,
            self::FORNITORE => 12,
            self::STUDIO_NOTARILE => 13,
            self::BANCA => 14,
            self::COLLABORATORE => 15,
            self::COMMERCIALISTA => 16,
            self::CONSULENTE_LAVORO => 17,
            self::TRIBUNALE => 18,
            self::GIUDICE_PACE => 19,
            self::SEGRETARIO_COMUNALE => 20,
            self::ASSICURAZIONE => 21,
            self::NOLEGGIO => 22,
            self::AMICI => 23,
            self::COMUNE => 25,
            self::UFFICIALE_RISCOSSIONE => 26,
            self::AFFISSATORE => 27,
            self::GUARDIA_FINANZA => 28,
            self::STUDIO_LEGALE => 29,
            self::GEOMETRA => '0',
        };
    }
}
