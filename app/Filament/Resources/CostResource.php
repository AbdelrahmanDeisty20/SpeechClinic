<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostResource\Pages;
use App\Models\Cost;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;

class CostResource extends Resource
{
    protected static ?string $model = Cost::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|\UnitEnum|null $navigationGroup = 'Systems Config';

    public static function getNavigationGroup(): ?string
    {
        return __('Systems Config');
    }

    public static function getNavigationLabel(): string
    {
        return __('Costs');
    }

    public static function getPluralLabel(): string
    {
        return __('Costs');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Pricing Details'))
                    ->columns(3)
                    ->schema([
                        TextInput::make('price')
                            ->label(__('Price'))
                            ->numeric()
                            ->required()
                            ->prefix(__('EGP')),
                        Select::make('type')
                            ->label(__('Type'))
                            ->options([
                                'assessment' => __('Assessment'),
                                'monthly' => __('Monthly'),
                            ])
                            ->required(),
                        Select::make('branch_id')
                            ->label(__('Branch'))
                            ->relationship('branch', 'name_en')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.name_en')
                    ->label(__('Branch'))
                    ->getStateUsing(fn ($record) => $record->branch?->name)
                    ->badge()
                    ->color('primary'),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'assessment' => 'info',
                        'monthly' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => __($state === 'assessment' ? 'Assessment' : 'Monthly')),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('EGP', locale: 'ar_EG')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'assessment' => __('Assessment'),
                        'monthly' => __('Monthly'),
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
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
            'index' => Pages\ListCosts::route('/'),
            'create' => Pages\CreateCost::route('/create'),
            'view' => Pages\ViewCost::route('/{record}'),
            'edit' => Pages\EditCost::route('/{record}/edit'),
        ];
    }
}
