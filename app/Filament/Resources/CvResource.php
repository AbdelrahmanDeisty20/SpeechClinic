<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CvResource\Pages;
use App\Models\Cv;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Image;
use Filament\Tables\Table;
use Filament\Actions;

class CvResource extends Resource
{
    protected static ?string $model = Cv::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Doctor\'s CV');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Doctor Information'))
                    ->schema([
                        FileUpload::make('image')
                            ->label(__('Photo'))
                            ->image()
                            ->disk('public')
                            ->directory('cvs')
                            ->columnSpanFull(),
                        
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name_ar')
                                    ->label(__('Doctor Name (Arabic)'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('name_en')
                                    ->label(__('Doctor Name (English)'))
                                    ->required()
                                    ->maxLength(255),
                                
                                TextInput::make('title_ar')
                                    ->label(__('Job Title (Arabic)'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('title_en')
                                    ->label(__('Job Title (English)'))
                                    ->required()
                                    ->maxLength(255),
                            ]),

                        RichEditor::make('description_ar')
                            ->label(__('Short Biography (Arabic)'))
                            ->required()
                            ->columnSpanFull(),
                        
                        RichEditor::make('description_en')
                            ->label(__('Short Biography (English)'))
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label(__('Photo'))
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name_ar')
                    ->label(__('Name AR'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label(__('Name EN'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title_ar')
                    ->label(__('Title AR'))
                    ->searchable(),
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
                Actions\EditAction::make()->label(__('Edit')),
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
            'index' => Pages\ListCvs::route('/'),
            'create' => Pages\CreateCv::route('/create'),
            'edit' => Pages\EditCv::route('/{record}/edit'),
        ];
    }
}
