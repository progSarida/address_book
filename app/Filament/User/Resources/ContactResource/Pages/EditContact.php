<?php

namespace App\Filament\User\Resources\ContactResource\Pages;

use App\Filament\User\Resources\ContactResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Blade;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Conferma eliminazione contatto')
                ->modalDescription('Sei sicuro di voler eliminare questo contatto? Questa azione non può essere annullata.')
                ->modalSubmitActionLabel('Elimina')
                ->modalCancelActionLabel('Annulla')
                ,
            Actions\Action::make('stampa')
                ->icon('heroicon-o-printer')
                ->label('Stampa')
                ->tooltip('Stampa contatto')
                ->color('primary')
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
                ,
            // Action::make('generaPdf')
            //     ->url(fn () => route('print.contact', ['id' => $this->record->id]))
            //     ->openUrlInNewTab()
            //     ,
        ];
    }
}
