<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvailableTimeResource\Pages;
use App\Models\AvailableTime;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;

class AvailableTimeResource extends Resource
{
    protected static ?string $model = AvailableTime::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-clock';

    protected static string|\UnitEnum|null $navigationGroup = 'Booking Management';

    public static function getNavigationGroup(): ?string
    {
        return __('Booking Management');
    }
//ماشي اولا  عايزك تعمل  امر  تشيل  حقل bookin_numbe دا  من bookings تمام  وكمان 
    public static function getNavigationLabel(): string
    {
        return __('Available Times');
    }

    public static function getPluralLabel(): string
    {
        return __('Available Times');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Time Configuration'))
                    ->description(__('Define the day and service type.'))
                    ->columns(2)
                    ->schema([
                        Select::make('day_id')
                            ->label(__('Day of Week'))
                            ->relationship('day', 'name_en')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->branch?->name})")
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('type')
                            ->label(__('Type'))
                            ->options([
                                'assessment' => __('Assessment'),
                                'monthly' => __('Monthly'),
                            ])
                            ->default('assessment')
                            ->required(),
                    ]),

                Section::make(__('Timing & Capacity'))
                    ->description(__('Set the time window and max bookings.'))
                    ->columns(3)
                    ->schema([
                        TimePicker::make('start_time')
                            ->label(__('Start Time'))
                            ->required(),
                        TimePicker::make('end_time')
                            ->label(__('End Time'))
                            ->required(),
                        TextInput::make('limit')
                            ->label(__('Max Bookings per Period'))
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('day.branch.name_en')
                    ->label(__('Branch'))
                    ->getStateUsing(fn ($record) => $record->day?->branch?->name)
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                TextColumn::make('day.name_en')
                    ->label(__('Day'))
                    ->getStateUsing(fn ($record) => $record->day?->name)
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label(__('Start Time'))
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label(__('End Time'))
                    ->time('h:i A')
                    ->sortable(),
                TextColumn::make('limit')
                    ->label(__('Limit'))
                    ->numeric(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'assessment' => 'info',
                        'monthly' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => __($state === 'assessment' ? 'Assessment' : 'Monthly')),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
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
