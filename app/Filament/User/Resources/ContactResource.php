<?php

namespace App\Filament\User\Resources;

use App\Enum\Titles;
use App\Enum\Toponyms;
use App\Filament\User\Resources\ContactResource\Pages;
use App\Filament\User\Resources\ContactResource\RelationManagers;
use App\Models\City;
use App\Models\Contact;
use App\Models\Province;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    public static ?string $pluralModelLabel = 'Elenco contatti';                             // titolo List

    protected static ?string $navigationLabel = 'Elenco contatti';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Contatto')
                ->columnSpan(5)
                ->schema([
                    Forms\Components\Grid::make(10)
                        ->schema([
                            Forms\Components\Select::make('title')
                                ->hiddenLabel()
                                ->placeholder('Seleziona titolo')
                                ->options(Titles::class)
                                ->columnSpan(3)
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('surname')
                                ->hiddenLabel()
                                ->placeholder('Cognome/Denominazione')
                                ->columnSpan(4)
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('name')
                                ->hiddenLabel()
                                ->placeholder('Nome')
                                ->columnSpan(3)
                                ->required()
                                ->maxLength(255),
                        ]),
                ]),
                Forms\Components\Fieldset::make('Indirizzo')
                ->columnSpan(5)
                ->schema([
                    Forms\Components\Grid::make(10)
                        ->schema([
                            Forms\Components\Select::make('title')
                                ->hiddenLabel()
                                ->placeholder('Seleziona toponimo')
                                ->options(Toponyms::class)
                                ->columnSpan(3)
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('addr')
                                ->hiddenLabel()
                                ->placeholder('Indirizzo')
                                ->columnSpan(5)
                                ->maxLength(255),
                            Forms\Components\TextInput::make('num')
                                ->hiddenLabel()
                                ->placeholder('Civico')
                                ->maxLength(4),
                            Forms\Components\TextInput::make('apart')
                                ->hiddenLabel()
                                ->placeholder('Interno')
                                ->maxLength(2),
                            Forms\Components\Placeholder::make('spacer')
                                ->hiddenLabel()
                                ->content('')
                                ->columnSpan(3),
                            Forms\Components\TextInput::make('cap')
                                ->hiddenLabel()
                                ->placeholder('Cap')
                                ->maxLength(5),
                            Forms\Components\Select::make('city')
                                ->hiddenLabel()
                                ->searchable()
                                ->placeholder('Città')
                                ->getSearchResultsUsing(function (string $search) {
                                    return City::query()
                                        ->where('name', 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck('name', 'id');
                                })
                                ->getOptionLabelUsing(function ($value) {
                                    return City::find($value)?->name;
                                })
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $city = City::find($state);
                                    if ($city) {
                                        $province = Province::find($city->province_id);
                                        $set('province', $province->code);
                                        $set('cap', $city->zip_code);
                                    } else {
                                        $set('province', null);
                                        $set('cap', null);
                                    }
                                })
                                ->columnSpan(5),
                            Forms\Components\TextInput::make('province')
                                ->hiddenLabel()
                                ->placeholder('Provincia')
                                ->maxLength(2),
                        ]),
                ]),
                Forms\Components\Fieldset::make('Contatti')
                ->columnSpan(5)
                ->schema([
                    Forms\Components\Grid::make(6)
                        ->schema([
                            Forms\Components\TextInput::make('phone_1')
                                ->hiddenLabel()
                                ->placeholder('Telefono 1')
                                ->columnSpan(2)
                                ->maxLength(255),
                            Forms\Components\TextInput::make('phone_2')
                                ->hiddenLabel()
                                ->placeholder('Telefono 2')
                                ->columnSpan(2)
                                ->maxLength(255),
                            Forms\Components\TextInput::make('fax')
                                ->hiddenLabel()
                                ->placeholder('Fax')
                                ->columnSpan(2)
                                ->maxLength(2),
                            Forms\Components\TextInput::make('smart_1')
                                ->hiddenLabel()
                                ->placeholder('Cellulare 1')
                                ->columnSpan(2)
                                ->maxLength(255),
                            Forms\Components\TextInput::make('smart_2')
                                ->hiddenLabel()
                                ->placeholder('Cellulare 2')
                                ->columnSpan(2)
                                ->maxLength(255),
                            Forms\Components\Placeholder::make('spacer')
                                ->hiddenLabel()
                                ->content('')
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('email_1')
                                ->hiddenLabel()
                                ->placeholder('Email 1')
                                ->columnSpan(2)
                                ->maxLength(255),
                            Forms\Components\TextInput::make('email_2')
                                ->hiddenLabel()
                                ->placeholder('Email 2')
                                ->columnSpan(2)
                                ->maxLength(255),
                            Forms\Components\Placeholder::make('spacer')
                                ->hiddenLabel()
                                ->content('')
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('site')
                                ->hiddenLabel()
                                ->placeholder('Sito')
                                ->columnSpan(4)
                                ->maxLength(255),
                            Forms\Components\Placeholder::make('spacer')
                                ->hiddenLabel()
                                ->content('')
                                ->columnSpan(2),
                            Forms\Components\Textarea::make('note')
                                ->hiddenLabel()
                                ->placeholder('Note')
                                ->rows(4)
                                ->columnSpan(6),
                        ]),
                ]),
            ])->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Denominazione')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        return $record->surname . ' ' . $record->name;
                    }),
                Tables\Columns\TextColumn::make('phone_1')
                    ->label('Telefono'),
                Tables\Columns\TextColumn::make('smart_1')
                    ->label('Cellulare'),
                Tables\Columns\TextColumn::make('email_1')
                    ->label('Email'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
