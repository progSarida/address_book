<?php

namespace App\Filament\User\Resources\ContactResource\Pages;

use App\Filament\User\Resources\ContactResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Blade;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Indietro')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray'),
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil'),
            Actions\Action::make('stampa')
                ->icon('heroicon-o-printer')
                ->label('Stampa')
                ->tooltip('Stampa contatto')
                ->color(Color::rgb('rgb(128, 128, 128)'))
                ->action(function () {
                    // Recupera il contatto corrente
                    $contact = $this->record;
                    $referents = $contact->referents ?? collect([]);
                    // Aggiungi referenti vuoti se necessario (come nel codice TCPDF)
                    while ($referents->count() < 3) {
                        $referents->push(new \App\Models\Referent());
                    }

                    return response()
                        ->streamDownload(function () use ($contact, $referents) {
                            echo Pdf::loadHTML(
                                Blade::render('pdf.contact', [
                                    'headerText' => 'Dettagli Contatto #' . $contact->id,
                                    'contact' => $contact,
                                    'referents' => $referents,
                                ])
                            )
                                ->stream();
                        }, 'Contatto.pdf');

                })
        ];
    }
}
