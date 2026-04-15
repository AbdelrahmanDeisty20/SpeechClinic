<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|\UnitEnum|null $navigationGroup = 'Systems Config';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('System Key')
                    ->description('Define the localized key for this setting.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('key_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Key (Arabic)'),
                                TextInput::make('key_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Key (English)'),
                            ]),
                    ]),

                Section::make('Configuration Value')
                    ->description('Define the localized value and type.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('value_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Value (Arabic)'),
                                TextInput::make('value_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Value (English)'),
                                Select::make('type')
                                    ->options([
                                        'text' => 'Text',
                                        'number' => 'Number',
                                        'boolean' => 'Boolean',
                                        'json' => 'JSON',
                                    ])
                                    ->required()
                                    ->default('text'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key_en')
                    ->label('Key (EN)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value_en')
                    ->label('Value (EN)')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('type')
                    ->badge()
                    ->color('info'),
                TextColumn::make('updated_at')
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
