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
use Filament\Tables\Table;
use Filament\Actions;

class CvResource extends Resource
{
    protected static ?string $model = Cv::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'HR Management';

    public static function getNavigationGroup(): ?string
    {
        return __('HR Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Candidate CVs');
    }

    public static function getPluralLabel(): string
    {
        return __('Candidate CVs');
    }

    protected static ?string $modelLabel = 'Candidate CV';

    public static function getModelLabel(): string
    {
        return __('Candidate CV');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make(__('Candidate Profile'))
                            ->description(__('Visual and basic identity.'))
                            ->schema([
                                FileUpload::make('image')
                                    ->label(__('Photo'))
                                    ->image()
                                    ->directory('cvs')
                                    ->disk('public')
                                    ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "cvs/{$state}" : $state)
                                    ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                                    ->required()
                                    ->imageEditor()
                                    ->columnSpanFull(),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name_ar')
                                            ->label(__('Name (Arabic)'))
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('name_en')
                                            ->label(__('Name (English)'))
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                            ])
                            ->columnSpan(2),
                        Section::make(__('Professional Focus'))
                            ->description(__('Localized titles and descriptions.'))
                            ->schema([
                                TextInput::make('title_ar')
                                    ->label(__('Job Title (Arabic)'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('title_en')
                                    ->label(__('Job Title (English)'))
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('description_ar')
                                    ->label(__('Biography (Arabic)'))
                                    ->rows(4),
                                Textarea::make('description_en')
                                    ->label(__('Biography (English)'))
                                    ->rows(4),
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
                    ->label(__('Photo'))
                    ->disk('public')
                    ->getStateUsing(fn($record) => $record->image ? "cvs/{$record->image}" : null)
                    ->circular()
                    ->size(60),
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
