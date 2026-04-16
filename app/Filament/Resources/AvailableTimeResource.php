<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailableTimeResource\Pages;
use App\Models\AvailableTime;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;

class AvailableTimeResource extends Resource
{
    protected static ?string $model = AvailableTime::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static string|\UnitEnum|null $navigationGroup = 'Booking Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Time Slot Details')
                    ->schema([
                        Select::make('day_id')
                            ->relationship('day', 'name_en')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Day of Week'),
                        TimePicker::make('start_time')
                            ->required(),
                        TimePicker::make('end_time')
                            ->required(),
                        TextInput::make('limit')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->label('Max Bookings per Slot'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('day.name_en')
                    ->label('Day')
                    ->sortable(),
                TextColumn::make('start_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('end_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('limit')
                    ->numeric()
                    ->label('Limit'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListAvailableTimes::route('/'),
            'create' => Pages\CreateAvailableTime::route('/create'),
            'view' => Pages\ViewAvailableTime::route('/{record}'),
            'edit' => Pages\EditAvailableTime::route('/{record}/edit'),
        ];
    }
}
