<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';

    protected static string|\UnitEnum|null $navigationGroup = 'المحتوى والإحصائيات';
    protected static ?int $navigationSort = 54;

    public static function getNavigationGroup(): ?string
    {
        return __('المحتوى والإحصائيات');
    }

    public static function getNavigationLabel(): string
    {
        return __('الصفحات الثابتة');
    }

    public static function getPluralLabel(): string
    {
        return __('الصفحات الثابتة');
    }

    public static function getLabel(): string
    {
        return __('صفحة');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Page Structure'))
                    ->description(__('Localized titles for the page.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title_ar')
                                    ->label(__('Title (Arabic)'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('title_en')
                                    ->label(__('Title (English)'))
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),

                Grid::make(2)
                    ->schema([
                        Section::make(__('Arabic Content'))
                            ->description(__('Content displayed in Arabic.'))
                            ->schema([
                                RichEditor::make('content_ar')
                                    ->label(__('Content (Arabic)'))
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),

                        Section::make(__('English Content'))
                            ->description(__('Content displayed in English.'))
                            ->schema([
                                RichEditor::make('content_en')
                                    ->label(__('Content (English)'))
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListPage::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
