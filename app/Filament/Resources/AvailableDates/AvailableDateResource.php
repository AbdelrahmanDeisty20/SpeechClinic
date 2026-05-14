<?php

namespace App\Filament\Resources\AvailableDates;

use App\Filament\Resources\AvailableDates\Pages\CreateAvailableDate;
use App\Filament\Resources\AvailableDates\Pages\EditAvailableDate;
use App\Filament\Resources\AvailableDates\Pages\ListAvailableDates;
use App\Filament\Resources\AvailableDates\Pages\ViewAvailableDate;
use App\Filament\Resources\AvailableDates\Schemas\AvailableDateForm;
use App\Filament\Resources\AvailableDates\Schemas\AvailableDateInfolist;
use App\Filament\Resources\AvailableDates\Tables\AvailableDatesTable;
use App\Models\AvailableDate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AvailableDateResource extends Resource
{
    protected static ?string $model = AvailableDate::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $recordTitleAttribute = 'date';

    public static function getNavigationGroup(): ?string
    {
        return __('Appointment Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Available Dates');
    }

    public static function getPluralLabel(): string
    {
        return __('Available Dates');
    }

    public static function getLabel(): string
    {
        return __('Available Date');
    }

    public static function form(Schema $schema): Schema
    {
        return AvailableDateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AvailableDateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AvailableDatesTable::configure($table);
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
            'index' => ListAvailableDates::route('/'),
            'create' => CreateAvailableDate::route('/create'),
            'view' => ViewAvailableDate::route('/{record}'),
            'edit' => EditAvailableDate::route('/{record}/edit'),
        ];
    }
}
