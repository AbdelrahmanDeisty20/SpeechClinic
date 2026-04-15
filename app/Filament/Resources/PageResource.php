<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Systems Config';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Page Structure')
                    ->description('Localized titles for the page.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Title (Arabic)'),
                                TextInput::make('title_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Title (English)'),
                            ]),
                    ]),

                Section::make('Rich Content')
                    ->description('The main body of the page.')
                    ->schema([
                        RichEditor::make('content_ar')
                            ->required()
                            ->label('Content (Arabic)')
                            ->columnSpanFull(),
                        RichEditor::make('content_en')
                            ->required()
                            ->label('Content (English)')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title_ar')
                    ->label('Title (AR)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
