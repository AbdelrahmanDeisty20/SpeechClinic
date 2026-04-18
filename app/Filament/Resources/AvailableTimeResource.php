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

    protected static string|\UnitEnum|null $navigationGroup = 'Available Times Management';

    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return __('Available Times Management');
    }
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
                    ->columns(3)
                    ->schema([
                        Select::make('branch_id')
                            ->label(__('Branch'))
                            ->relationship('day.branch', 'name_en')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                            ->searchable()
                            ->preload()
                            ->live()
                            ->dehydrated(false)
                            ->afterStateHydrated(function (Select $component, $record) {
                                if ($record?->day?->branch_id) {
                                    $component->state($record->day->branch_id);
                                }
                            }),
                        Select::make('day_id')
                            ->label(__('Day of Week'))
                            ->relationship(
                                name: 'day',
                                titleAttribute: 'name_en',
                                modifyQueryUsing: fn ($query, $get) => $query->when($get('branch_id'), fn($q) => $q->where('branch_id', $get('branch_id')))
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn ($get) => !$get('branch_id'))
                            ->createOptionForm([
                                TextInput::make('name_ar')
                                    ->label(__('Name AR'))
                                    ->required(),
                                TextInput::make('name_en')
                                    ->label(__('Name EN'))
                                    ->required(),
                            ])
                            ->createOptionUsing(function (array $data, \Filament\Schemas\Components\Utilities\Get $get) {
                                $data['branch_id'] = $get('branch_id');
                                $data['is_active'] = true;
                                
                                return \App\Models\Day::create($data)->id;
                            }),
                        \Filament\Forms\Components\Hidden::make('type')
                            ->default('assessment')
                            ->required(),
                        \Filament\Forms\Components\Placeholder::make('type_display')
                            ->label(__('Type'))
                            ->content(__('Assessment')),
                    ]),

                Section::make(__('Timing & Capacity'))
                    ->description(__('Set the time window and max bookings.'))
                    ->columns(3)
                    ->schema([
                        TimePicker::make('time')
                            ->label(__('Time'))
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
                TextColumn::make('time')
                    ->label(__('Time'))
                    ->formatStateUsing(function ($state) {
                        return \Carbon\Carbon::parse($state)->isoFormat('hh:mm a');
                    })
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
                \Filament\Tables\Filters\SelectFilter::make('branch_id')
                    ->label(__('Branch'))
                    ->relationship('day.branch', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name),
                \Filament\Tables\Filters\SelectFilter::make('day_id')
                    ->label(__('Day'))
                    ->relationship('day', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->branch?->name})"),
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
            'index' => Pages\ListAvailableTimes::route('/'),
            'create' => Pages\CreateAvailableTime::route('/create'),
            'view' => Pages\ViewAvailableTime::route('/{record}'),
            'edit' => Pages\EditAvailableTime::route('/{record}/edit'),
        ];
    }
}
