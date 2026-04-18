<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookinMonthlyResource\Pages;
use App\Models\BookinMonthly;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Tables;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Placeholder;
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
                Select::make('booking_id')
                    ->relationship('booking', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->booking_number ?? "#{$record->id} ({$record->child_name})")
                    ->label(__('Assessment Booking'))
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('price')
                    ->label(__('Price'))
                    ->numeric()
                    ->prefix(__('EGP')),
                Select::make('status')
                    ->label(__('Status'))
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
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Linked Assessment Details'))
                    ->description(__('Information from the initial assessment booking.'))
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
                        Grid::make(2)
                            ->schema([
                                Placeholder::make('price')
                                    ->label(__('Total Price'))
                                    ->content(fn ($record) => number_format($record?->price ?? 0, 2) . ' ' . __('ج.م')),
                                Placeholder::make('status')
                                    ->label(__('Payment Status'))
                                    ->content(fn ($record) => __($record?->status)),
                                
                                Image::make(fn ($record) => $record->image ? asset('storage/monthlies/' . $record->image) : '', __('Receipt Image'))
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make(__('Sessions/Appointments'))
                    ->description(__('Sessions scheduled for this monthly package.'))
                    ->schema([
                        Placeholder::make('sessions_count')
                            ->label(__('Total Sessions'))
                            ->content(fn ($record) => $record->appointments()->count() . ' ' . __('Sessions')),
                        
                        // If we want to list appointments, we can use a Placeholder with HTML if needed
                        // But for now, showing the count is a good start as requested.
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
