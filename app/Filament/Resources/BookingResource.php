<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|\UnitEnum|null $navigationGroup = 'Booking Management';

    public static function getNavigationGroup(): ?string
    {
        return __('Booking Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Booking Management');
    }

    public static function getPluralLabel(): string
    {
        return __('Booking Management');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(3)
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
                                TextInput::make('booking_number')
                                    ->label(__('Booking Number'))
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder(__('ID')),
                            ])->columnSpan(2),

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
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "Slot #{$record->id} ({$record->day?->name_en}: {$record->start_time} - {$record->end_time})")
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
                                    ->prefix('$')
                                    ->required(),
                            ])->columnSpan(1),

                        Section::make(__('Problem Description'))
                            ->schema([
                                Textarea::make('problem_description')
                                    ->label(__('Problem Description'))
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ])->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_number')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->label(__('ID')),
                ImageColumn::make('child_photo')
                    ->circular()
                    ->label(__('Photo')),
                TextColumn::make('child_name')
                    ->label(__('Child Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'assessment' => 'info',
                        'monthly' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => __($state === 'assessment' ? 'Assessment' : 'Monthly')),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => __('Pending'),
                        'confirmed' => __('Confirmed'),
                        'cancelled' => __('Cancelled'),
                        'completed' => __('Completed'),
                    }),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('USD')
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
