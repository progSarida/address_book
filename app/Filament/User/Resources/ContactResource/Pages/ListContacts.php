<?php

namespace App\Filament\User\Resources\ContactResource\Pages;

use App\Filament\User\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus-circle')                // scelgo l'icona
                ->label('Nuovo')                                // niente testo
                ->tooltip('Nuovo contatto')                     // tooltip al passaggio
                ->iconButton()                                  // mostro solo icona
                ->color('success')
                ,
            Actions\Action::make('stampa')
                ->icon('heroicon-o-printer')
                ->label('Stampa')
                ->tooltip('Stampa elenco contatti')             // tooltip al passaggio
                ->iconButton()                                  // mostro solo icona
                ->color('danger')
                ->action(function () {
                    Notification::make()
                        ->title('Stampa')
                        ->success()
                        ->send();
                })
                ,
        ];
    }
}
