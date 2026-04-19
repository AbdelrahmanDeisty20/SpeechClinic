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

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Doctor\'s CV');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('CVs');
    }

    public static function getPluralLabel(): string
    {
        return __('CVs');
    }

    public static function getLabel(): string
    {
        return __('CV');
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
                            ->label(__('Photo'))
                            ->image()
                            ->directory('cvs')
                            ->disk('public')
                            ->required()
                            ->imageEditor()
                            ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "cvs/{$state}" : $state)
                            ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                            ->columnSpanFull(),
                        Section::make(__('Doctor Information'))
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('Doctor Name'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label(__('Phone'))
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                RichEditor::make('biography')
                                    ->label(__('Short Biography'))
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 2,
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
                ImageColumn::make('image_url')
                    ->label(__('Photo'))
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
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->emptyStateHeading(__('No CVs found'))
            ->actions([
                Actions\ViewAction::make()->label(__('View')),
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
