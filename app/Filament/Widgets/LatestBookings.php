<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookings extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function getHeading(): string
    {
        return __('Latest Bookings');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                BookingResource::getEloquentQuery()
                    ->latest()
            )
            ->defaultPaginationPageOption(10)
            ->columns([
                Tables\Columns\TextColumn::make('booking_number')
                    ->label(__('ID'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('child_name')
                    ->label(__('Child Name')),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'assessment' => 'info',
                        'monthly' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => __($state === 'assessment' ? 'Assessment' : 'Monthly')),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'pending' => __('Pending'),
                        'confirmed' => __('Confirmed'),
                        'cancelled' => __('Cancelled'),
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'assessment' => __('Assessment'),
                        'monthly' => __('Monthly'),
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'pending' => __('Pending'),
                        'confirmed' => __('Confirmed'),
                        'cancelled' => __('Cancelled'),
                    ]),
            ])
            ->emptyStateHeading(__('No bookings found'));
    }
}
