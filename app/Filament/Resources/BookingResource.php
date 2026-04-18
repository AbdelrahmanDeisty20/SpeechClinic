<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Actions;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = 'Booking Management';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Booking Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Assessment Bookings');
    }

    public static function getPluralLabel(): string
    {
        return __('Assessment Bookings');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Child Information'))
                    ->description(__('Basic details of the child.'))
                    ->schema([
                        FileUpload::make('child_photo')
                            ->label(__('Photo'))
                            ->image()
                            ->avatar()
                            ->directory('children')
                            ->columnSpanFull(),
                        TextInput::make('child_name')
                            ->label(__('Child Name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('child_age')
                            ->label(__('Child Age'))
                            ->numeric()
                            ->required(),

                    ])
                    ->columns(2),

                Grid::make(2)
                    ->schema([
                        Section::make(__('Booking Details'))
                            ->description(__('Service and status details.'))
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'email')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label(__('Parent/User')),
                                Select::make('available_time_id')
                                    ->label(__('Available Time'))
                                    ->relationship('availableTime', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => __('Day') . ": {$record->day?->name} - " . __('Time') . ": " . \Carbon\Carbon::parse($record->start_time)->format('h:i A') . " - " . \Carbon\Carbon::parse($record->end_time)->format('h:i A') . " ({$record->day?->branch?->name})")
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('type')
                                    ->label(__('Type'))
                                    ->options([
                                        'assessment' => __('Assessment'),
                                        'monthly' => __('Monthly'),
                                    ])
                                    ->required(),
                                Select::make('status')
                                    ->label(__('Status'))
                                    ->options([
                                        'pending' => __('Pending'),
                                        'confirmed' => __('Confirmed'),
                                        'cancelled' => __('Cancelled'),
                                        'completed' => __('Completed'),
                                    ])
                                    ->required(),
                                TextInput::make('price')
                                    ->label(__('Price'))
                                    ->numeric()
                                    ->prefix(__('EGP'))
                                    ->required(),
                            ])
                            ->columnSpan(1),

                        Section::make(__('Problem Description'))
                            ->schema([
                                Textarea::make('problem_description')
                                    ->label(__('Problem Description'))
                                    ->required()
                                    ->rows(12)
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Problem Description'))
                    ->schema([
                        Placeholder::make('problem_description')
                            ->label(__('Description'))
                            ->content(fn ($record) => $record?->problem_description)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Booking Summary'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                // Column 1: Child Details
                                Grid::make(1)
                                    ->schema([
                                        Placeholder::make('photo_title')
                                            ->label('')
                                            ->content(__('Child Photo'))
                                            ->extraAttributes(['class' => 'font-bold underline text-primary-600']),
                                        Image::make(fn ($record) => $record->child_photo_url ?? '', __('Photo')),
                                        Placeholder::make('child_name')
                                            ->label(__('Child Name'))
                                            ->content(fn ($record) => $record?->child_name),
                                        Placeholder::make('child_age')
                                            ->label(__('Child Age'))
                                            ->content(fn ($record) => ($record?->child_age ?? '0') . ' ' . __('Years')),
                                    ])->columnSpan(1),

                                // Column 2: Parent Details
                                Grid::make(1)
                                    ->schema([
                                        Placeholder::make('user_name')
                                            ->label(__('Parent Name'))
                                            ->content(fn ($record) => $record?->user?->full_name),
                                        Placeholder::make('user_phone')
                                            ->label(__('Phone'))
                                            ->content(fn ($record) => $record?->user?->phone),

                                        Placeholder::make('price')
                                            ->label(__('Price'))
                                            ->content(fn ($record) => number_format($record?->price ?? 0, 2) . ' ' . __('ج.م')),
                                    ])->columnSpan(1),

                                // Column 3: Appointment Details
                                Grid::make(1)
                                    ->schema([
                                        Placeholder::make('status')
                                            ->label(__('Status'))
                                            ->content(fn ($record) => match ($record?->status) {
                                                'pending' => __('Pending'),
                                                'confirmed' => __('Confirmed'),
                                                'cancelled' => __('Cancelled'),
                                                'completed' => __('Completed'),
                                                default => $record?->status,
                                            }),
                                        Placeholder::make('type')
                                            ->label(__('Type'))
                                            ->content(fn ($record) => __($record?->type === 'assessment' ? 'Assessment' : 'Monthly')),
                                        Placeholder::make('branch_name')
                                            ->label(__('Branch'))
                                            ->content(fn ($record) => $record?->availableTime?->day?->branch?->name),
                                        Placeholder::make('appointment')
                                            ->label(__('Appointment'))
                                            ->content(function ($record) {
                                                $day = $record?->availableTime?->day?->name;
                                                $state = $record?->availableTime;
                                                if (!$state) return $day ?? '-';
                                                $start = \Carbon\Carbon::parse($state->start_time)->format('h:i A');
                                                $end = \Carbon\Carbon::parse($state->end_time)->format('h:i A');
                                                return "{$day} ({$start} - {$end})";
                                            }),
                                    ])->columnSpan(1),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('child_photo')
                    ->disk('public')
                    ->getStateUsing(fn($record) => $record->child_photo ? "children/{$record->child_photo}" : null)
                    ->circular()
                    ->label(__('Photo')),
                TextColumn::make('child_name')
                    ->label(__('Child Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('availableTime.day.branch.name_en')
                    ->label(__('Branch'))
                    ->getStateUsing(fn($record) => $record->availableTime?->day?->branch?->name)
                    ->badge()
                    ->color('primary'),
                TextColumn::make('availableTime.day.name_en')
                    ->label(__('Day'))
                    ->getStateUsing(fn($record) => $record->availableTime?->day?->name)
                    ->badge()
                    ->color('info'),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'assessment' => 'info',
                        'monthly' => 'success',
                    })
                    ->formatStateUsing(fn(string $state): string => __($state === 'assessment' ? 'Assessment' : 'Monthly')),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('Pending'),
                        'confirmed' => __('Confirmed'),
                        'cancelled' => __('Cancelled'),
                        'completed' => __('Completed'),
                    }),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('EGP', locale: 'ar_EG')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'assessment' => __('Assessment'),
                        'monthly' => __('Monthly'),
                    ]),
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'pending' => __('Pending'),
                        'confirmed' => __('Confirmed'),
                        'cancelled' => __('Cancelled'),
                        'completed' => __('Completed'),
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\Action::make('setMonthlyPackage')
                    ->label(__('Prepare Monthly Package'))
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->visible(fn ($record) => $record->type === 'assessment' && $record->status === 'confirmed')
                    ->form([
                        TextInput::make('price')
                            ->label(__('Monthly Price'))
                            ->numeric()
                            ->required()
                            ->default(fn ($record) => $record->availableTime?->day?->branch?->cost?->where('type', 'monthly')->first()?->price ?? 0),
                    ])
                    ->action(function ($record, array $data) {
                        \App\Models\BookinMonthly::updateOrCreate(
                            ['booking_id' => $record->id],
                            [
                                'price' => $data['price'],
                                'status' => 'pending',
                            ]
                        );
                        
                        \Filament\Notifications\Notification::make()
                            ->title(__('Monthly package prepared successfully'))
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'view' => Pages\ViewBooking::route('/{record}'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
