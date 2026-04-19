<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostResource\Pages;
use App\Models\Cost;
use App\Models\Branch;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class CostResource extends Resource
{
    protected static ?string $model = Cost::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Clinic Management');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Costs & Pricing');
    }

    public static function getPluralLabel(): string
    {
        return __('Costs & Pricing');
    }

    public static function getLabel(): string
    {
        return __('Price');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Pricing Details'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Price Category'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->label(__('Amount'))
                            ->numeric()
                            ->prefix(__('EGP'))
                            ->required(),
                        Select::make('type')
                            ->label(__('Type'))
                            ->options([
                                'assessment' => __('Assessment'),
                                'monthly' => __('Monthly'),
                            ])
                            ->required(),
                        Select::make('branch_id')
                            ->label(__('Branch'))
                            ->relationship('branch', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.name')
                    ->label(__('Branch'))
                    ->badge()
                    ->color('primary'),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'assessment' => 'info',
                        'monthly' => 'success',
                    }),
                TextColumn::make('name')
                    ->label(__('Category'))
                    ->searchable(),
                TextColumn::make('price')
                    ->label(__('Amount'))
                    ->money('EGP', divideBy: 1),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('branch_id')
                    ->label(__('Branch'))
                    ->relationship('branch', 'name'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCosts::route('/'),
            'create' => Pages\CreateCost::route('/create'),
            'edit' => Pages\EditCost::route('/{record}/edit'),
        ];
    }
}
