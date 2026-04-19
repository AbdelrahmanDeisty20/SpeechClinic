<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';
    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Content & Pages');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Banners');
    }

    public static function getPluralLabel(): string
    {
        return __('Banners');
    }

    public static function getLabel(): string
    {
        return __('Banner');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Banner Details'))
                    ->schema([
                        FileUpload::make('image')
                            ->label(__('Photo'))
                            ->image()
                            ->disk('public')
                            ->directory('banners')
                            ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "banners/{$state}" : $state)
                            ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Grid::make(2)
                    ->schema([
                        Section::make(__('Arabic Content'))
                            ->schema([
                                TextInput::make('title_ar')
                                    ->label(__('Title (Arabic)'))
                                    ->required(),
                                Textarea::make('description_ar')
                                    ->label(__('Description (Arabic)'))
                                    ->rows(3),
                            ]),

                        Section::make(__('English Content'))
                            ->schema([
                                TextInput::make('title_en')
                                    ->label(__('Title (English)'))
                                    ->required(),
                                Textarea::make('description_en')
                                    ->label(__('Description (English)'))
                                    ->rows(3),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label(__('Photo'))
                    ->disk('public')
                    ->size(100),

                TextColumn::make('title_en')
                    ->label(__('Title (English)'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title_ar')
                    ->label(__('Title (Arabic)'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->emptyStateHeading(__('No banners found'))
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}