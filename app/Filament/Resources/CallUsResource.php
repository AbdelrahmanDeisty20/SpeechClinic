<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CallUsResource\Pages;
use App\Models\callUs;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class CallUsResource extends Resource
{
    protected static ?string $model = callUs::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-phone-arrow-up-right';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('App Configuration');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Call Requests');
    }

    public static function getPluralLabel(): string
    {
        return __('Call Requests');
    }

    public static function getLabel(): string
    {
        return __('Call Request');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Call Request Details'))
                    ->schema([
                        TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->required()
                            ->maxLength(255),
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
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branch.name_en')
                    ->label(__('Branch'))
                    ->getStateUsing(fn ($record) => $record->branch?->name)
                    ->badge()
                    ->color('info'),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->emptyStateHeading(__('No call requests found'))
            ->actions([
                Actions\ViewAction::make()->label(__('View')),
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
            'index' => Pages\ListCallUs::route('/'),
            'create' => Pages\CreateCallUs::route('/create'),
            'view' => Pages\ViewCallUs::route('/{record}'),
            'edit' => Pages\EditCallUs::route('/{record}/edit'),
        ];
    }
}
