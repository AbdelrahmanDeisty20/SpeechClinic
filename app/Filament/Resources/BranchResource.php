<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    protected static string|\UnitEnum|null $navigationGroup = 'Main Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Branch Identifiers')
                    ->description('Localized names for the branch.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Name (Arabic)'),
                                TextInput::make('name_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Name (English)'),
                            ]),
                    ]),

                Section::make('Geographical Location')
                    ->description('Coordinates and map link.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('lat')
                                    ->label('Latitude')
                                    ->numeric(),
                                TextInput::make('lng')
                                    ->label('Longitude')
                                    ->numeric(),
                                TextInput::make('address_link')
                                    ->label('Google Maps Link')
                                    ->url()
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_ar')
                    ->label('Name (AR)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lat')
                    ->label('Latitude'),
                TextColumn::make('lng')
                    ->label('Longitude'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
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
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
