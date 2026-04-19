<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-finger-print';
    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return __('Appointment Management');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Attendance');
    }

    public static function getPluralLabel(): string
    {
        return __('Attendance Records');
    }

    public static function getLabel(): string
    {
        return __('Attendance Record');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Attendance Details'))
                    ->description(__('Record specialist attendance and branch presence.'))
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label(__('Specialist'))
                            ->options(User::where('type', 'specialist')->get()->pluck('full_name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('branch_id')
                            ->label(__('Branch'))
                            ->relationship('branch', 'name_en')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name)
                            ->searchable()
                            ->preload()
                            ->required(),
                        DatePicker::make('date')
                            ->label(__('Date'))
                            ->default(now())
                            ->required(),
                        Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'present' => __('Present'),
                                'absent' => __('Absent'),
                                'late' => __('Late'),
                                'excused' => __('Excused'),
                            ])
                            ->required(),
                    ]),

                Section::make(__('Timing & Location'))
                    ->description(__('Exact clock-in/out times and geographic data.'))
                    ->columns(2)
                    ->schema([
                        TimePicker::make('check_in')
                            ->label(__('Check In')),
                        TimePicker::make('check_out')
                            ->label(__('Check Out')),
                        TextInput::make('lat')
                            ->label(__('Latitude'))
                            ->numeric(),
                        TextInput::make('lng')
                            ->label(__('Longitude'))
                            ->numeric(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')
                    ->label(__('Specialist'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('branch.name_ar')
                    ->label(__('Branch'))
                    ->getStateUsing(fn($record) => $record->branch?->name)
                    ->sortable(),
                TextColumn::make('date')
                    ->label(__('Date'))
                    ->date()
                    ->sortable(),
                TextColumn::make('check_in')
                    ->label(__('Check In'))
                    ->time('h:i A'),
                TextColumn::make('check_out')
                    ->label(__('Check Out'))
                    ->time('h:i A'),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'late' => 'warning',
                        'absent' => 'danger',
                        'excused' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => __($state)),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('user_id')
                    ->label(__('Specialist'))
                    ->options(User::where('type', 'specialist')->get()->pluck('full_name', 'id')),
                \Filament\Tables\Filters\SelectFilter::make('branch_id')
                    ->label(__('Branch'))
                    ->relationship('branch', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name),
                \Filament\Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('from')
                            ->label(__('From')),
                        DatePicker::make('to')
                            ->label(__('To')),
                    ])
                    ->query(fn ($query, array $data) => $query
                        ->when($data['from'], fn($q) => $q->whereDate('date', '>=', $data['from']))
                        ->when($data['to'], fn($q) => $q->whereDate('date', '<=', $data['to']))
                    )
            ])
            ->emptyStateHeading(__('No attendance records found'))
            ->actions([
                Actions\EditAction::make()->label(__('Edit')),
                Actions\DeleteAction::make()->label(__('Delete')),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
