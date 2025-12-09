<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Stampa Contatto</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            margin: 0;
        }

        .section-title {
            background-color: #d3d3d3;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            border: 1px solid #000;
        }

        .frame {
            border: 1px solid #000;
            padding: 20px;
            margin-bottom: 30px;
        }

        .linea {
            margin-bottom: 6px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .campo {
            display: inline-block;
            padding-left: 4px;
            padding-right: 4px;
        }

        .campo .label {
            font-weight: bold;
            white-space: nowrap;
            display: inline-block;
        }

        .campo .value {
            white-space: nowrap;
            display: inline-block;
        }

        .note p {
            margin: 0;
        }

        .referent-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
            box-sizing: border-box;
            display: block;
        }

        .note {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        .note-text {
            break-inside: avoid !important;
            page-break-inside: avoid !important;
        }

        @media print {
            @page {
                margin: 2cm;
            }
            body {
                margin: 0;
            }
            .frame {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }
            .referent-box {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    {{-- Intestazione --}}
    <div class="section-title">
        {{ \App\Enum\Titles::tryFrom($contact->title)?->getLabel() ?? '' }} - {{ $contact->name ?? '' }} {{ $contact->surname ?? '' }}
    </div>

    {{-- Dati contatto --}}
    <div class="frame">
        {{-- Riga 1: titolo-cognome-nome --}}
        <div class="linea">
            <div class="campo" style="width: 175px;">
                <span class="label">Titolo:</span>
                <span class="value">{{ \App\Enum\Titles::tryFrom($contact->title)?->getLabel() ?? '' }}</span>
            </div>
            <div class="campo" style="width: 200px;">
                <span class="label">Cognome:</span>
                <span class="value">{{ $contact->surname ?? '' }}</span>
            </div>
            <div class="campo" style="width: 175px;">
                <span class="label">Nome:</span>
                <span class="value">{{ $contact->name ?? '' }}</span>
            </div>
        </div>

        {{-- Riga 2: indirizzo-cap-città-prov --}}
        <div class="linea">
            <div class="campo" style="width: 280px;">
                <span class="label">Indirizzo:</span>
                <span class="value">{{ \App\Enum\Toponyms::tryFrom($contact->toponym)?->getLabel() ?? '' }} {{ $contact->addr }} {{ $contact->num }}</span>
            </div>
            <div class="campo" style="width: 60px;">
                <span class="label">CAP:</span>
                <span class="value">{{ $contact->cap ?? '' }}</span>
            </div>
            <div class="campo" style="width: 155px;">
                <span class="label">Città:</span>
                <span class="value">{{ $contact->city ?? '' }}</span>
            </div>
            <div class="campo" style="width: 60px;">
                <span class="label">Prov.:</span>
                <span class="value">{{ $contact->province ?? '' }}</span>
            </div>
        </div>

        {{-- Riga 3: tel1-tel2-fax --}}
        <div class="linea">
            <div class="campo" style="width: 180px;">
                <span class="label">Tel. 1:</span>
                <span class="value">{{ $contact->phone_1 ?? '' }}</span>
            </div>
            <div class="campo" style="width: 180px;">
                <span class="label">Tel. 2:</span>
                <span class="value">{{ $contact->phone_2 ?? '' }}</span>
            </div>
            <div class="campo" style="width: 180px;">
                <span class="label">Fax:</span>
                <span class="value">{{ $contact->fax ?? '' }}</span>
            </div>
        </div>

        {{-- Riga 4: cell1-cell2 --}}
        <div class="linea">
            <div class="campo" style="width: 280px;">
                <span class="label">Cell. 1:</span>
                <span class="value">{{ $contact->smart_1 ?? '' }}</span>
            </div>
            <div class="campo" style="width: 280px;">
                <span class="label">Cell. 2:</span>
                <span class="value">{{ $contact->smart_2 ?? '' }}</span>
            </div>
        </div>

        {{-- Riga 5: email1-email2 --}}
        <div class="linea">
            <div class="campo" style="width: 280px;">
                <span class="label">Email 1:</span>
                <span class="value">{{ $contact->email_1 ?? '' }}</span>
            </div>
            <div class="campo" style="width: 280px;">
                <span class="label">Email 2:</span>
                <span class="value">{{ $contact->email_2 ?? '' }}</span>
            </div>
        </div>

        {{-- Riga 6: homepage --}}
        <div class="linea">
            <div class="campo" style="width: 550px;">
                <span class="label">Homepage:</span>
                <span class="value">{{ $contact->site ?? '' }}</span>
            </div>
        </div>

        {{-- Note --}}
        @if(!empty($contact->note))
            <div class="linea"><strong>Note:</strong></div>
            <div class="note">
                {!! Purify::clean(html_entity_decode($contact->note)) !!}
            </div>
        @endif
    </div>

    {{-- Referenti --}}
    @foreach($referents as $index => $referent)
        @if($index > 0 && $index % 5 === 0)
            <div style="page-break-before: always;"></div>
        @endif
        <div class="referent-box">
            <div class="linea">
                <div class="campo" style="width: 550px;">
                    <span class="label">Nome:</span>
                    <span class="value">{{ $referent?->surname ?? '' }} {{ $referent?->name ?? '' }}</span>
                </div>
            </div>
            <div class="linea">
                <div class="campo" style="width: 550px;">
                    <span class="label">Titolo:</span>
                    <span class="value">{{ $referent?->title ?? '' }}</span>
                </div>
            </div>
            <div class="linea">
                <div class="campo" style="width: 180px;">
                    <span class="label">Telefono:</span>
                    <span class="value">{{ $referent?->phone ?? '' }}</span>
                </div>
                <div class="campo" style="width: 180px;">
                    <span class="label">Fax:</span>
                    <span class="value">{{ $referent?->fax ?? '' }}</span>
                </div>
                <div class="campo" style="width: 180px;">
                    <span class="label">Cellulare:</span>
                    <span class="value">{{ $referent?->smart ?? '' }}</span>
                </div>
            </div>
            <div class="linea">
                <div class="campo" style="width: 550px;">
                    <span class="label">Email:</span>
                    <span class="value">{{ $referent?->email ?? '' }}</span>
                </div>
            </div>
            @if(!empty($referent?->note))
                <div class="linea"><strong>Note:</strong></div>
                <div class="note-text">
                    {!! Purify::clean(html_entity_decode($referent->note)) !!}
                </div>
            @endif
        </div>
    @endforeach
</body>
</html>
