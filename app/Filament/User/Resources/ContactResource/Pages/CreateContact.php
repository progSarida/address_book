<?php

namespace App\Filament\User\Resources\ContactResource\Pages;

use App\Filament\User\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    public function getHeading(): string
    {
        return 'Crea un nuovo contatto';
    }
}
