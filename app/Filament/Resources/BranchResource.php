<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Main Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Branch Identifiers')
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
