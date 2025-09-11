<?php

namespace App\Filament\User\Resources;

use App\Enum\Titles;
use App\Enum\Toponyms;
use App\Filament\User\Resources\ContactResource\Pages;
use App\Filament\User\Resources\ContactResource\RelationManagers;
use App\Models\City;
use App\Models\Contact;
use App\Models\Province;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Components\Hidden;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;


class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    public static ?string $pluralModelLabel = 'Elenco contatti';                             // titolo List

    protected static ?string $navigationLabel = 'Elenco contatti';

    protected static ?string $navigationIcon = 'far-address-book';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Schede')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Contatto')
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
                                                    ->maxLength(255),
                                            ]),
                                    ]),
                                Forms\Components\Fieldset::make('Indirizzo')
                                    ->columnSpan(5)
                                    ->schema([
                                        Forms\Components\Grid::make(10)
                                            ->schema([
                                                Forms\Components\Select::make('toponym')
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
                                                    ->dehydrateStateUsing(function ($state) {
                                                        return City::find($state)?->name;
                                                    })
                                                    ->columnSpan(5),
                                                Forms\Components\TextInput::make('cap')
                                                    ->hiddenLabel()
                                                    ->placeholder('Cap')
                                                    ->maxLength(5),
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
                                                    ->columnSpan(2),
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
                                                    ->columnSpan(6)
                                                    ->dehydrateStateUsing(function ($state) {
                                                        if (empty($state)) {
                                                            return null; // Gestisce il caso in cui il campo è vuoto
                                                        }

                                                        // Verifica se contiene tag HTML
                                                        if (preg_match('/<[^>]+>/', $state)) {
                                                            // HTML: sanitizza con Purify
                                                            return Purify::clean(html_entity_decode($state));
                                                        }

                                                        // Testo normale: applica nl2br e sanitizza
                                                        return Purify::clean(nl2br($state));
                                                    })
                                                    ,
                                            ]),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Referenti')
                            ->schema([
                                Forms\Components\Repeater::make('referents')
                                    ->hiddenLabel()
                                    ->relationship('referents')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nome')
                                            ->required(),
                                        Forms\Components\TextInput::make('title')
                                            ->label('Qualifica')
                                            ->required(),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Telefono'),
                                        Forms\Components\TextInput::make('smart')
                                            ->label('Cellulare'),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Email')
                                            ->email(),
                                    ])
                                    ->columns(3)
                                    ->collapsible()
                                    ->collapsed()
                                    ->createItemButtonLabel('Aggiungi referente')
                                    ->defaultItems(0)
                                    ->grid(1)
                                    ->itemLabel(fn (array $state): ?string => $state['name'] . ' - ' . $state['title'] ?? null)
                                    ->deleteAction(
                                        fn ($action) => $action->requiresConfirmation()
                                            ->modalHeading('Conferma eliminazione')
                                            ->modalDescription('Sei sicuro di voler eliminare questo referente? Questa azione non può essere annullata.')
                                            ->modalSubmitActionLabel('Elimina')
                                            ->modalCancelActionLabel('Annulla')
                                    ),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(5);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return \App\Enum\Titles::tryFrom($state)?->getLabel() ?? $state;
                    }),
                Tables\Columns\TextColumn::make('denominazione')
                    ->label('Denominazione')
                    ->sortable(['surname', 'name'])
                    ->state(function ($record) {
                        return trim($record->surname . ' ' . $record->name);
                    }),
                Tables\Columns\TextColumn::make('phone_1')
                    ->label('Telefono'),
                Tables\Columns\TextColumn::make('smart_1')
                    ->label('Cellulare'),
                Tables\Columns\TextColumn::make('email_1')
                    ->label('Email'),
            ])
            ->filters([
                SelectFilter::make('title')
                    ->label('Tipo')
                    ->options(Titles::class)
                    ->searchable()
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->tooltip('Modifica contatto')
                    // ->iconButton()                                  // mostro solo icona
                    ,
                Tables\Actions\DeleteAction::make()
                    ->tooltip('Elimina contatto')
                    // ->iconButton()                                  // mostro solo icona
                    ->requiresConfirmation()
                    ->modalHeading('Conferma eliminazione contatto')
                    ->modalDescription('Sei sicuro di voler eliminare questo contatto? Questa azione non può essere annullata.')
                    ->modalSubmitActionLabel('Elimina')
                    ->modalCancelActionLabel('Annulla'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Conferma eliminazione contatti')
                        ->modalDescription('Sei sicuro di voler eliminare i contatti selezionati? Questa azione non può essere annullata.')
                        ->modalSubmitActionLabel('Elimina')
                        ->modalCancelActionLabel('Annulla'),
                    Tables\Actions\BulkAction::make('Stampa')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->openUrlInNewTab()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records, array $data, $livewire) {
                            $activeFilters = $livewire->tableFilters ?? [];
                            $searchTerm = $livewire->tableSearch ?? null;           // controllare
                            return response()->streamDownload(function () use ($records, $activeFilters) {
                                echo Pdf::loadHTML(
                                    Blade::render('pdf.contacts', [
                                        'contacts' => $records,
                                        'filters' => $activeFilters,
                                    ])
                                )
                                ->setPaper('A4', 'landscape')
                                ->stream();
                            }, 'Contatti.pdf');
                        }),
                ]),
            ])
            ->searchable()
            ->modifyQueryUsing(function (Builder $query) use ($table): Builder {
                $search = $table->getLivewire()->getTableSearch();
                if ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('surname', 'LIKE', "%{$search}%")
                            ->orWhere('name', 'LIKE', "%{$search}%");
                    });
                }
                return $query;
            });
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('company', auth()->user()->company);

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
