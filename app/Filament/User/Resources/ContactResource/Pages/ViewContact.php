<?php

namespace App\Filament\User\Resources\ContactResource\Pages;

use App\Filament\User\Resources\ContactResource;
use App\Models\Contact;
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
        $currentContact = $this->record;
        // Precedente per surname: cognome precedente O stesso cognome con nome precedente O stesso cognome e nome con ID minore
        $previousAContact = Contact::where(function ($query) use ($currentContact) {
                $query->where('surname', '<', $currentContact->surname)
                    ->orWhere(function ($q) use ($currentContact) {
                        $q->where('surname', '=', $currentContact->surname)
                        ->where(function ($subQ) use ($currentContact) {
                            $subQ->where('name', '<', $currentContact->name)
                                ->orWhere(function ($nameQ) use ($currentContact) {
                                    $nameQ->where('name', '=', $currentContact->name)
                                            ->where('id', '<', $currentContact->id);
                                });
                        });
                    });
            })
            ->orderBy('surname', 'desc')->orderBy('name', 'desc')->orderBy('id', 'desc')->first();
        // Successivo per surname: cognome successivo O stesso cognome con nome successivo O stesso cognome e nome con ID maggiore
        $nextAContact = Contact::where(function ($query) use ($currentContact) {
                $query->where('surname', '>', $currentContact->surname)
                    ->orWhere(function ($q) use ($currentContact) {
                        $q->where('surname', '=', $currentContact->surname)
                        ->where(function ($subQ) use ($currentContact) {
                            $subQ->where('name', '>', $currentContact->name)
                                ->orWhere(function ($nameQ) use ($currentContact) {
                                    $nameQ->where('name', '=', $currentContact->name)
                                            ->where('id', '>', $currentContact->id);
                                });
                        });
                    });
            })
            ->orderBy('surname', 'asc')->orderBy('name', 'asc')->orderBy('id', 'asc')->first();
        // Precedente per ID: semplicemente ID minore
        $previousIContact = Contact::where('id', '<', $currentContact->id)->orderBy('id', 'desc')->first();
        // Successivo per ID: semplicemente ID maggiore
        $nextIContact = Contact::where('id', '>', $currentContact->id)->orderBy('id', 'asc')->first();
        return [
            Actions\Action::make('back')
                ->label('Indietro')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray'),
            // Scorrimento alfabetico
            Actions\Action::make('previous_a_contact')
                ->label('Alfabetico prec.')
                ->color('info')
                ->icon('heroicon-o-arrow-left-circle')
                ->visible(function () use ($previousAContact) { return $previousAContact;})
                ->action(function () use ($previousAContact) {
                    $this->redirect(ContactResource::getUrl('view', ['record' => $previousAContact->id]));
                }),
            Actions\Action::make('next_a_contact')
                ->label('Alfabetico succ.')
                ->color('info')
                ->icon('heroicon-o-arrow-right-circle')
                ->visible(function () use ($nextAContact) { return $nextAContact;})
                ->action(function () use ($nextAContact) {
                    $this->redirect(ContactResource::getUrl('view', ['record' => $nextAContact->id]));
                }),
            // Scorrimento id
            Actions\Action::make('previous_i_contact')
                ->label('Id prec.')
                ->color('gray')
                ->icon('heroicon-o-arrow-left-circle')
                ->visible(function () use ($previousIContact) { return $previousIContact;})
                ->action(function () use ($previousIContact) {
                    $this->redirect(ContactResource::getUrl('view', ['record' => $previousIContact->id]));
                }),
            Actions\Action::make('next_i_contact')
                ->label('Id succ.')
                ->color('gray')
                ->icon('heroicon-o-arrow-right-circle')
                ->visible(function () use ($nextIContact) { return $nextIContact;})
                ->action(function () use ($nextIContact) {
                    $this->redirect(ContactResource::getUrl('view', ['record' => $nextIContact->id]));
                }),
            Actions\EditAction::make()
                ->icon('heroicon-o-pencil'),
            Actions\Action::make('stampa')
                ->icon('heroicon-o-printer')
                ->label('Stampa')
                ->tooltip('Stampa contatto')
                ->color(Color::rgb('rgb(255, 0, 0)'))
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
