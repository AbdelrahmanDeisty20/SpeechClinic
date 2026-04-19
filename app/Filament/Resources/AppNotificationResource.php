<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppNotificationResource\Pages;
use App\Models\AppNotification;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Filament\Schemas\Components\Section;

class AppNotificationResource extends Resource
{
    protected static ?string $model = AppNotification::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bell';


    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('App Configuration');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('App Notifications');
    }

    public static function getPluralLabel(): string
    {
        return __('App Notifications');
    }

    public static function getLabel(): string
    {
        return __('App Notification');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Notification Details'))
                    ->description(__('Create a new notification for the mobile app.'))
                    ->schema([
                        Select::make('user_id')
                            ->label(__('Target User'))
                            ->options(User::all()->pluck('full_name', 'id'))
                            ->searchable()
                            ->hint(__('Leave empty to send to all users')),
                        TextInput::make('title')
                            ->label(__('Notification Title'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('link')
                            ->label(__('Redirection Link (Optional)'))
                            ->url()
                            ->maxLength(255),
                        RichEditor::make('message')
                            ->label(__('Notification Message'))
                            ->required()
                            ->columnSpanFull(),
                        Select::make('type')
                            ->label(__('Notification Type'))
                            ->options([
                                'info' => __('General Info'),
                                'alert' => __('Alert'),
                                'promotion' => __('Promotion'),
                            ])
                            ->default('info')
                            ->required(),
                    ])
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 2,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')
                    ->label(__('User'))
                    ->default(__('All Users'))
                    ->badge()
                    ->color(fn ($state) => $state === __('All Users') ? 'success' : 'primary'),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->limit(50),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge(),
                IconColumn::make('is_read')
                    ->label(__('Read Status'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(__('Sent At'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->emptyStateHeading(__('No notifications found'))
            ->actions([
                Actions\ViewAction::make()->label(__('View')),
                Actions\DeleteAction::make()->label(__('Delete')),
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
            'index' => Pages\ListAppNotifications::route('/'),
            'create' => Pages\CreateAppNotification::route('/create'),
            'view' => Pages\ViewAppNotification::route('/{record}'),
        ];
    }
}
