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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Child Information')
                            ->description('Basic details of the child.')
                            ->schema([
                                FileUpload::make('child_photo')
                                    ->image()
                                    ->avatar()
                                    ->directory('children')
                                    ->columnSpanFull(),
                                TextInput::make('child_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('child_age')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('booking_number')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->placeholder('Auto-generated'),
                                TextInput::make('assessment_number')
                                    ->label('Ref. Assessment #')
                                    ->placeholder('N/A')
                                    ->disabled(),
                            ])->columnSpan(2),

                        Section::make('Booking Details')
                            ->description('Service and status details.')
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'email')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Parent/User'),
                                Select::make('available_time_id')
                                    ->relationship('availableTime', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "Slot #{$record->id} ({$record->day?->name_en}: {$record->start_time} - {$record->end_time})")
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('type')
                                    ->options([
                                        'assessment' => 'Assessment',
                                        'monthly' => 'Monthly',
                                    ])
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'confirmed' => 'Confirmed',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->required(),
                                TextInput::make('price')
                                    ->numeric()
                                    ->prefix('$')
                                    ->required(),
                            ])->columnSpan(1),

                        Section::make('Problem Description')
                            ->schema([
                                Textarea::make('problem_description')
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
                    ->label('ID'),
                TextColumn::make('assessment_number')
                    ->searchable()
                    ->sortable()
                    ->label('Ref.'),
                ImageColumn::make('child_photo')
                    ->circular()
                    ->label('Photo'),
                TextColumn::make('child_name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'assessment' => 'info',
                        'monthly' => 'success',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                    }),
                TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'assessment' => 'Assessment',
                        'monthly' => 'Monthly',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
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
