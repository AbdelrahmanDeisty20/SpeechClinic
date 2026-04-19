<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('App Configuration');
    }

    public static function getNavigationLabel(): string
    {
        return __('General Settings');
    }

    public static function getPluralLabel(): string
    {
        return __('General Settings');
    }

    public static function getLabel(): string
    {
        return __('Setting');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Setting Metadata'))
                    ->description(__('Define the localized key and type.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('key_ar')
                                    ->label(__('Key (Arabic)'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('key_en')
                                    ->label(__('Key (English)'))
                                    ->required()
                                    ->maxLength(255),
                                Select::make('type')
                                    ->label(__('Type'))
                                    ->options([
                                        'text' => __('Text'),
                                        'number' => __('Number'),
                                        'boolean' => __('Boolean'),
                                        'json' => __('JSON'),
                                    ])
                                    ->required()
                                    ->default('text'),
                            ]),
                    ]),

                Grid::make(2)
                    ->schema([
                        Section::make(__('Value (Arabic)'))
                            ->schema([
                                TextInput::make('value_ar')
                                    ->label(__('Value (Arabic)'))
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columnSpan(1),

                        Section::make(__('Value (English)'))
                            ->schema([
                                TextInput::make('value_en')
                                    ->label(__('Value (English)'))
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key_en')
                    ->label(__('Key (English)'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value_en')
                    ->label(__('Value (English)'))
                    ->searchable()
                    ->limit(50),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color('info'),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->emptyStateHeading(__('No settings found'))
            ->actions([
                Actions\EditAction::make()->label(__('Edit')),
                Actions\DeleteAction::make()->label(__('Delete')),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
