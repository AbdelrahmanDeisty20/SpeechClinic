<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Actions;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|\UnitEnum|null $navigationGroup = 'Banners Management';

    public static function getNavigationGroup(): ?string
    {
        return __('Banners Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Banners');
    }

    public static function getPluralLabel(): string
    {
        return __('Banners');
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
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->default(true),
                    ]),
                Grid::make(2)
                    ->schema([
                        Section::make(__('Arabic Content'))
                            ->description(__('Content displayed in Arabic.'))
                            ->schema([
                                TextInput::make('title_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Title (Arabic)')),
                                Textarea::make('description_ar')
                                    ->rows(3)
                                    ->label(__('Description (Arabic)')),
                            ])
                            ->columnSpan(1),
                        Section::make(__('English Content'))
                            ->description(__('Content displayed in English.'))
                            ->schema([
                                TextInput::make('title_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Title (English)')),
                                Textarea::make('description_en')
                                    ->rows(3)
                                    ->label(__('Description (English)')),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->square()
                    ->size(100),
                TextColumn::make('title_en')
                    ->label(__('Title (English)'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title_ar')
                    ->label(__('Title (Arabic)'))
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('Is Active')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
