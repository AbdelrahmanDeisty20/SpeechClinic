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
                    ->relationship('booking', 'booking_number')
                    ->label(__('Assessment Booking Number'))
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
