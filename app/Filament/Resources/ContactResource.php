<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static string|\UnitEnum|null $navigationGroup = 'Systems Config';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Sender Particulars')
                    ->description('Personal details of the sender.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Message Insight')
                    ->description('Details of the received inquiry.')
                    ->schema([
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
