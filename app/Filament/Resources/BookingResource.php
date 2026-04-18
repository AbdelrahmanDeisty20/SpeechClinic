<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
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

    protected static string|\UnitEnum|null $navigationGroup = 'حجوزات المواعيد';
    protected static ?int $navigationSort = 10;

    public static function getNavigationGroup(): ?string
    {
        return __('حجوزات المواعيد');
    }

    public static function getNavigationLabel(): string
    {
        return __('الحجوزات التقييمية');
    }

    public static function getPluralLabel(): string
    {
        return __('الحجوزات التقييمية');
    }

    public static function getLabel(): string
    {
        return __('حجز تقييمي');
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('type', 'assessment');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('بيانات الطفل'))
                    ->description(__('التفاصيل الأساسية للطفل.'))
                    ->schema([
                        FileUpload::make('child_photo')
                            ->label(__('الصورة'))
                            ->image()
                            ->avatar()
                            ->disk('public')
                            ->directory('children')
                            ->columnSpanFull(),
                        TextInput::make('child_name')
                            ->label(__('اسم الطفل'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('child_age')
                            ->label(__('عمر الطفل'))
                            ->numeric()
                            ->required(),

                    ])
                    ->columns(2),

                Grid::make(2)
                    ->schema([
                        Section::make(__('تفاصيل الحجز'))
                            ->description(__('تحديد حالة الخدمة والتفاصيل.'))
                            ->schema([
                                Select::make('user_id')
                                    ->relationship('user', 'email')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label(__('ولي الأمر/المستخدم')),
                                Select::make('available_time_id')
                                    ->label(__('الموعد المتاح'))
                                    ->relationship('availableTime', 'id')
                                    ->getOptionLabelFromRecordUsing(fn ($record) => __('اليوم') . ": {$record->day?->name} - " . __('الوقت') . ": " . \Carbon\Carbon::parse($record->start_time)->format('h:i A') . " - " . \Carbon\Carbon::parse($record->end_time)->format('h:i A') . " ({$record->day?->branch?->name})")
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                \Filament\Forms\Components\Hidden::make('type')
                                    ->default('assessment'),
                                Select::make('status')
                                    ->label(__('الحالة'))
                                    ->options([
                                        'pending' => __('Pending'),
                                        'accepted' => __('Accepted'),
                                        'confirmed' => __('Confirmed'),
                                        'cancelled' => __('Cancelled'),
                                        'completed' => __('Completed'),
                                    ])
                                    ->required()
                                    ->live(),
                                TextInput::make('price')
                                    ->label(__('السعر'))
                                    ->numeric()
                                    ->prefix(__('ج.م'))
                                    ->required(),
                                TextInput::make('booking_number')
                                    ->label(__('رقم الحجز'))
                                    ->placeholder(__('أدخل رقم الحجز'))
                                    ->maxLength(255)
                                    ->hidden(fn (Get $get) => $get('status') !== 'confirmed')
                                    ->required(fn (Get $get) => $get('status') === 'confirmed'),
                            ])
                            ->columnSpan(1),

                        Section::make(__('وصف المشكلة'))
                            ->schema([
                                Textarea::make('problem_description')
                                    ->label(__('وصف المشكلة'))
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
                Section::make(__('وصف المشكلة'))
                    ->schema([
                        Placeholder::make('problem_description')
                            ->label(__('الوصف'))
                            ->content(fn ($record) => $record?->problem_description)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('ملخص الحجز'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                // Column 1: Child Details
                                Grid::make(1)
                                    ->schema([
                                        Placeholder::make('photo_title')
                                            ->label('')
                                            ->content(__('صورة الطفل'))
                                            ->extraAttributes(['class' => 'font-bold underline text-primary-600']),
                                        Image::make(fn ($record) => $record?->child_photo_url ?? asset('images/placeholder.png'), __('الصورة')),
                                        Placeholder::make('child_name')
                                            ->label(__('اسم الطفل'))
                                            ->content(fn ($record) => $record?->child_name),
                                        Placeholder::make('child_age')
                                            ->label(__('عمر الطفل'))
                                            ->content(fn ($record) => ($record?->child_age ?? '0') . ' ' . __('سنة')),
                                    ])->columnSpan(1),

                                // Column 2: Parent Details
                                Grid::make(1)
                                    ->schema([
                                        Placeholder::make('user_name')
                                            ->label(__('اسم ولي الأمر'))
                                            ->content(fn ($record) => $record?->user?->full_name),
                                        Placeholder::make('user_phone')
                                            ->label(__('الهاتف'))
                                            ->content(fn ($record) => $record?->user?->phone),

                                        Placeholder::make('price')
                                            ->label(__('السعر'))
                                            ->content(fn ($record) => number_format($record?->price ?? 0, 2) . ' ' . __('ج.م')),
                                        Placeholder::make('booking_number')
                                            ->label(__('رقم الحجز'))
                                            ->content(fn ($record) => $record?->booking_number ?? '-'),
                                    ])->columnSpan(1),

                                // Column 3: Appointment Details
                                Grid::make(1)
                                    ->schema([
                                        Placeholder::make('status')
                                            ->label(__('الحالة'))
                                            ->content(fn ($record) => match ($record?->status) {
                                                'pending' => __('Pending'),
                                                'accepted' => __('Accepted'),
                                                'confirmed' => __('Confirmed'),
                                                'cancelled' => __('Cancelled'),
                                                'completed' => __('Completed'),
                                                default => $record?->status,
                                            }),
                                        Placeholder::make('branch_name')
                                            ->label(__('الفرع'))
                                            ->content(fn ($record) => $record?->availableTime?->day?->branch?->name),
                                        Placeholder::make('appointment')
                                            ->label(__('الموعد'))
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
                TextColumn::make('booking_number')
                    ->label(__('رقم الحجز'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),

                ImageColumn::make('child_photo')
                    ->disk('public')
                    ->circular()
                    ->label(__('الصورة')),
                TextColumn::make('child_name')
                    ->label(__('اسم الطفل'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.phone')
                    ->label(__('الهاتف'))
                    ->searchable(),
                TextColumn::make('availableTime.day.branch.name_en')
                    ->label(__('الفرع'))
                    ->getStateUsing(fn($record) => $record->availableTime?->day?->branch?->name)
                    ->badge()
                    ->color('primary'),
                TextColumn::make('availableTime.day.name_en')
                    ->label(__('اليوم'))
                    ->getStateUsing(fn($record) => $record->availableTime?->day?->name)
                    ->badge()
                    ->color('info'),
                TextColumn::make('status')
                    ->label(__('الحالة'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'accepted' => 'info',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('Pending'),
                        'accepted' => __('Accepted'),
                        'confirmed' => __('Confirmed'),
                        'cancelled' => __('Cancelled'),
                        'completed' => __('Completed'),
                    }),
                TextColumn::make('price')
                    ->label(__('السعر'))
                    ->money('EGP', locale: 'ar_EG')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('التاريخ'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('branch_id')
                    ->label(__('الفرع'))
                    ->relationship('availableTime.day.branch', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name),
                SelectFilter::make('day_id')
                    ->label(__('اليوم'))
                    ->relationship('availableTime.day', 'name_en')
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} ({$record->branch?->name})"),
                SelectFilter::make('status')
                    ->label(__('الحالة'))
                    ->options([
                        'pending' => __('Pending'),
                        'accepted' => __('Accepted'),
                        'confirmed' => __('Confirmed'),
                        'cancelled' => __('Cancelled'),
                        'completed' => __('Completed'),
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\Action::make('setMonthlyPackage')
                    ->label(__('تجهيز الباقة الشهرية'))
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->visible(fn ($record) => $record->type === 'assessment' && $record->status === 'confirmed')
                    ->form([
                        TextInput::make('price')
                            ->label(__('السعر الشهري'))
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
                            ->title(__('تم تجهيز الباقة بنجاح'))
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

