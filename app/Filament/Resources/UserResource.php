<?php

namespace App\Filament\Resources;

use App\Enum\Companies;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    public static ?string $pluralModelLabel = 'Elenco utenti';
    public static ?string $modelLabel = 'Utente';
    protected static ?string $navigationIcon = 'fas-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Username')
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(fn ($state) => filled($state))
                    ->placeholder(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? '' : 'Inserisci username')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(fn ($state) => filled($state))
                    ->placeholder(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? '' : 'Inserisci email')
                    ->maxLength(255),
                Forms\Components\Select::make('company')
                    ->label('Tipo')
                    ->label('Azienda')
                    ->options(Companies::options())
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(fn ($state) => filled($state)) // Only save if filled
                    ->placeholder(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? '' : 'Seleziona azienda')
                    ->searchable(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->dehydrated(fn ($state) => filled($state))
                    ->mutateDehydratedStateUsing(fn ($state) => Hash::make($state))
                    ->placeholder(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? '' : 'Inserisci password')
                    ->maxLength(255),
                // Forms\Components\Toggle::make('is_admin')
                //     ->label('Amministratore')
                //     ->dehydrated(fn ($state) => filled($state)) // Only save if filled
                //     ->helperText(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\EditRecord ? '' : ''),
                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    // ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_admin')
                    ->label('Admin')
                    ->onIcon('heroicon-s-shield-check')
                    ->offIcon('heroicon-s-shield-exclamation')
                    ->onColor('success')
                    ->offColor('danger'),
                Tables\Columns\SelectColumn::make('company')
                    ->label('Azienda')
                    ->options(Companies::options())
                    ->searchable()
                    ->sortable()
                    ->extraAttributes(['style' => 'max-width: 150px; white-space: nowrap;']),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->tooltip('Modifica utente')
                // ->iconButton()
                ,
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Elimina utente')
                    // ->iconButton()
                    ->requiresConfirmation()
                    ->modalHeading('Conferma eliminazione utente')
                    ->modalDescription('Sei sicuro di voler eliminare questo utente? Questa azione non può essere annullata.')
                    ->modalSubmitActionLabel('Elimina')
                    ->modalCancelActionLabel('Annulla'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
