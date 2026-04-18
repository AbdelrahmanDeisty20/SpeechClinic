<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CvResource\Pages;
use App\Models\Cv;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

    protected static string|\UnitEnum|null $navigationGroup = 'المحتوى والإحصائيات';
    protected static ?int $navigationSort = 52;

    public static function getNavigationGroup(): ?string
    {
        return __('المحتوى والإحصائيات');
    }

    public static function getNavigationLabel(): string
    {
        return __('السير الذاتية');
    }

    public static function getPluralLabel(): string
    {
        return __('السير الذاتية');
    }

    public static function getLabel(): string
    {
        return __('سيرة ذاتية');
    }

    public static function getModelLabel(): string
    {
        return __('Candidate CV');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Candidate CVs');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Candidate Profile'))
                    ->description(__('Visual and basic identity.'))
                    ->schema([
                        FileUpload::make('image')
                            ->label('Photo')
                            ->image()
                            ->directory('cvs')
                            ->disk('public')
                            ->required()
                            ->imageEditor()
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Name (Arabic)')),
                                TextInput::make('name_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Name (English)')),
                            ]),
                    ]),

                Grid::make(2)
                    ->schema([
                        Section::make(__('Arabic Content'))
                            ->description(__('Localized titles and descriptions.'))
                            ->schema([
                                TextInput::make('title_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Job Title (Arabic)')),
                                Textarea::make('description_ar')
                                    ->rows(6)
                                    ->label(__('Biography (Arabic)')),
                            ])
                            ->columnSpan(1),

                        Section::make(__('English Content'))
                            ->description(__('Localized titles and descriptions.'))
                            ->schema([
                                TextInput::make('title_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label(__('Job Title (English)')),
                                Textarea::make('description_en')
                                    ->rows(6)
                                    ->label(__('Biography (English)')),
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Candidate Photo'))
                    ->schema([
                        Image::make(fn ($record) => $record?->image_url ?? asset('images/placeholder.png'), __('Photo'))
                            ->imageWidth('200px')
                            ->imageHeight('200px')
                            ->circular(),
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
                TextColumn::make('name_en')
                    ->label(__('Candidate (English)'))
                    ->searchable()
                    ->sortable()
                    ->description(fn(Cv $record): string => $record->title_en ?? ''),
                TextColumn::make('name_ar')
                    ->label(__('Candidate (Arabic)'))
                    ->searchable()
                    ->sortable()
                    ->description(fn(Cv $record): string => $record->title_ar ?? ''),
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
            'index' => Pages\ListCvs::route('/'),
            'create' => Pages\CreateCv::route('/create'),
            'edit' => Pages\EditCv::route('/{record}/edit'),
        ];
    }
}
