<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecialistResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;

class SpecialistResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static string|\UnitEnum|null $navigationGroup = 'إدارة الموظفين والعملاء';
    protected static ?int $navigationSort = 81;

    public static function getNavigationGroup(): ?string
    {
        return __('إدارة الموظفين والعملاء');
    }

    public static function getNavigationLabel(): string
    {
        return __('الأخصائيين');
    }

    public static function getPluralLabel(): string
    {
        return __('الأخصائيين');
    }

    public static function getLabel(): string
    {
        return __('أخصائي');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('type', 'specialist');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make(__('Profile Information'))
                            ->description(__('Basic specialist profile details.'))
                            ->schema([
                                TextInput::make('first_name')
                                    ->label(__('First Name'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->label(__('Last Name'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label(__('Email address'))
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('phone')
                                    ->label(__('Phone'))
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                FileUpload::make('image')
                                    ->label('Photo')
                                    ->image()
                                    ->directory('users')
                                    ->disk('public')
                                    ->imageEditor()
                                    ->columnSpanFull(),
                                Hidden::make('type')
                                    ->default('specialist'),
                            ])->columnSpan(2),

                        Section::make(__('Access & Details'))
                            ->description(__('Manage specialist access.'))
                            ->schema([
                                Select::make('roles')
                                    ->label(__('Roles'))
                                    ->relationship('roles', 'name', fn (Builder $query) => $query->where('name', 'specialist'))
                                    ->multiple()
                                    ->preload()
                                    ->searchable(),
                                TextInput::make('password')
                                    ->label(__('Password'))
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $context): bool => $context === 'create'),
                                Toggle::make('is_active')
                                    ->label(__('Is Active'))
                                    ->onColor('success')
                                    ->default(true),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->disk('public')
                    ->size(100),
                TextColumn::make('full_name')
                    ->label(__('Full Name'))
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Email address'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->badge()
                    ->color('primary'),
                ToggleColumn::make('is_active')
                    ->label(__('Is Active')),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
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
            'index' => Pages\ListSpecialists::route('/'),
            'create' => Pages\CreateSpecialist::route('/create'),
            'view' => Pages\ViewSpecialist::route('/{record}'),
            'edit' => Pages\EditSpecialist::route('/{record}/edit'),
        ];
    }
}
