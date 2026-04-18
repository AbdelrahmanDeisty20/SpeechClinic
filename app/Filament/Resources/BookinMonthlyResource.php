<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookinMonthlyResource\Pages;
use App\Models\BookinMonthly;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Tables;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Components\RepeatableEntry;
use Filament\Tables\Columns\TextColumn as TableTextColumn;

class BookinMonthlyResource extends Resource
{
    protected static ?string $model = BookinMonthly::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static string|\UnitEnum|null $navigationGroup = 'Booking Management';
    
    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Booking Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Monthly Bookings');
    }

    public static function getPluralLabel(): string
    {
        return __('Monthly Bookings');
    }

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->schema([
                Section::make(__('Booking Source'))
                    ->description(__('Link this monthly package to an assessment booking.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('booking_number')
                                    ->label(__('Booking Number'))
                                    ->placeholder(__('Enter Booking Number'))
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (!$state) return;
                                        $booking = \App\Models\Booking::where('booking_number', $state)->first();
                                        if ($booking) {
                                            $set('booking_id', $booking->id);
                                            $set('child_name_temp', $booking->child_name);
                                            $set('child_age_temp', $booking->child_age . ' ' . __('Years'));
                                            $set('branch_temp', $booking->availableTime?->day?->branch?->name);
                                            $set('problem_temp', $booking->problem_description);
                                        }
                                    })
                                    ->afterStateHydrated(function (TextInput $component, $record, Set $set) {
                                        if ($record?->booking) {
                                            $component->state($record->booking->booking_number);
                                            $set('child_name_temp', $record->booking->child_name);
                                            $set('child_age_temp', $record->booking->child_age . ' ' . __('Years'));
                                            $set('branch_temp', $record->booking->availableTime?->day?->branch?->name);
                                            $set('problem_temp', $record->booking->problem_description);
                                        }
                                    }),
                                Select::make('booking_id')
                                    ->relationship('booking', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->booking_number ?? "#{$record->id}")
                                    ->label(__('Confirmed Booking'))
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->disabled()
                                    ->dehydrated(),
                            ]),
                        
                        Grid::make(4)
                            ->schema([
                                TextInput::make('child_name_temp')
                                    ->label(__('Child Name'))
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('child_age_temp')
                                    ->label(__('Age'))
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('branch_temp')
                                    ->label(__('Branch'))
                                    ->disabled()
                                    ->dehydrated(false),
                                TextInput::make('problem_temp')
                                    ->label(__('Problem'))
                                    ->disabled()
                                    ->dehydrated(false),
                            ]),
                    ]),

                Section::make(__('Payment & Package'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('price')
                                    ->label(__('Total Package Price'))
                                    ->numeric()
                                    ->prefix(__('EGP'))
                                    ->required(),
                                Select::make('status')
                                    ->label(__('Booking Status'))
                                    ->options([
                                        'pending' => __('Pending'),
                                        'confirmed' => __('Confirmed'),
                                        'cancelled' => __('Cancelled'),
                                        'completed' => __('Completed'),
                                    ])
                                    ->required(),
                                FileUpload::make('image')
                                    ->label(__('Receipt/Image'))
                                    ->directory('monthlies')
                                    ->image(),
                            ]),
                    ]),

                Section::make(__('Sessions/Appointments'))
                    ->description(__('Schedule the appointments for this monthly package.'))
                    ->schema([
                        Repeater::make('appointments')
                            ->relationship('appointments')
                            ->schema([
                                DatePicker::make('date')
                                    ->label(__('Session Date'))
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if (!$state) return;
                                        $dayName = \Carbon\Carbon::parse($state)->format('l');
                                        $day = \App\Models\Day::where('name_en', $dayName)->first();
                                        if ($day) {
                                            $set('day_id', $day->id);
                                        }
                                    })
                                    ->required(),
                                Select::make('day_id')
                                    ->label(__('Day'))
                                    ->relationship('day', 'name_en')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->disabled()
                                    ->dehydrated(),
                                TimePicker::make('time')
                                    ->label(__('Session Time'))
                                    ->required(),
                                Select::make('specialist_id')
                                    ->label(__('Specialist'))
                                    ->options(\App\Models\User::where('type', 'specialist')->get()->pluck('full_name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                \Filament\Forms\Components\Hidden::make('user_id')
                                    ->default(fn () => auth()->id()),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->itemLabel(fn (array $state): ?string => ($state['date'] ?? '') . ' ' . ($state['time'] ?? '')),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Linked Assessment Details'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('child_name')
                                    ->label(__('Child Name'))
                                    ->content(fn ($record) => $record?->booking?->child_name),
                                Placeholder::make('child_age')
                                    ->label(__('Age'))
                                    ->content(fn ($record) => $record?->booking?->child_age . ' ' . __('Years')),
                                Placeholder::make('booking_number')
                                    ->label(__('Assessment Number'))
                                    ->content(fn ($record) => $record?->booking?->booking_number),
                                
                                Placeholder::make('parent_name')
                                    ->label(__('Parent Name'))
                                    ->content(fn ($record) => $record?->booking?->user?->full_name),
                                Placeholder::make('parent_phone')
                                    ->label(__('Phone'))
                                    ->content(fn ($record) => $record?->booking?->user?->phone),
                                Placeholder::make('branch')
                                    ->label(__('Branch'))
                                    ->content(fn ($record) => $record?->booking?->availableTime?->day?->branch?->name),
                            ]),

                        Placeholder::make('problem_description')
                            ->label(__('Problem Description'))
                            ->content(fn ($record) => $record?->booking?->problem_description)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Payment & Status'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('price')
                                    ->label(__('Total Price'))
                                    ->content(fn ($record) => number_format($record?->price ?? 0, 2) . ' ' . __('ج.م')),
                                Placeholder::make('status')
                                    ->label(__('Payment Status'))
                                    ->content(fn ($record) => __($record?->status)),
                                Placeholder::make('created_at')
                                    ->label(__('Date'))
                                    ->content(fn ($record) => $record?->created_at?->format('Y-m-d H:i')),
                                
                                Image::make(fn ($record) => $record->image ? asset('storage/monthlies/' . $record->image) : '', __('Receipt Image'))
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make(__('Sessions Details'))
                    ->schema([
                        Placeholder::make('sessions_count')
                            ->label(__('Total Sessions'))
                            ->content(fn ($record) => $record->appointments()->count() . ' ' . __('Sessions')),
                        
                        RepeatableEntry::make('appointments')
                            ->label(__('Sessions List'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Placeholder::make('date')
                                            ->label(__('Date'))
                                            ->content(fn ($record) => $record?->date),
                                        Placeholder::make('time')
                                            ->label(__('Time'))
                                            ->content(fn ($record) => $record?->time ? \Carbon\Carbon::parse($record->time)->format('h:i A') : '-'),
                                        Placeholder::make('specialist')
                                            ->label(__('Specialist'))
                                            ->content(fn ($record) => $record?->specialist?->full_name),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.booking_number')
                    ->label(__('Assessment Number'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking.child_name')
                    ->label(__('Child Name'))
                    ->searchable(),
                TextColumn::make('booking.user.phone')
                    ->label(__('Phone'))
                    ->searchable(),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('EGP')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => __($state)),
                ImageColumn::make('image')
                    ->label(__('Receipt'))
                    ->disk('public')
                    ->getStateUsing(fn($record) => $record->image ? "monthlies/{$record->image}" : null),
                TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
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
            'index' => Pages\ListBookinMonthlies::route('/'),
            'create' => Pages\CreateBookinMonthly::route('/create'),
            'view' => Pages\ViewBookinMonthly::route('/{record}'),
            'edit' => Pages\EditBookinMonthly::route('/{record}/edit'),
        ];
    }
}
