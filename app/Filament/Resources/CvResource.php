<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CvResource\Pages;
use App\Models\Cv;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class CvResource extends Resource
{
    protected static ?string $model = Cv::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static string|\UnitEnum|null $navigationGroup = 'HR Management';

    protected static ?string $modelLabel = 'Candidate CV';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(3)
                    ->schema([
                        Section::make('Candidate Profile')
                            ->description('Visual and basic identity.')
                            ->schema([
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('cvs')
                                    ->required()
                                    ->imageEditor()
                                    ->columnSpanFull(),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name_ar')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Name (Arabic)'),
                                        TextInput::make('name_en')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Name (English)'),
                                    ]),
                            ])->columnSpan(2),

                        Section::make('Professional Focus')
                            ->description('Localized titles and descriptions.')
                            ->schema([
                                TextInput::make('title_ar')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Job Title (Arabic)'),
                                TextInput::make('title_en')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Job Title (English)'),
                                Textarea::make('description_ar')
                                    ->rows(4)
                                    ->label('Biography (Arabic)'),
                                Textarea::make('description_en')
                                    ->rows(4)
                                    ->label('Biography (English)'),
                            ])->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->circular()
                    ->size(60),
                TextColumn::make('name_en')
                    ->label('Candidate (EN)')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Cv $record): string => $record->title_en ?? ''),
                TextColumn::make('name_ar')
                    ->label('Candidate (AR)')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Cv $record): string => $record->title_ar ?? ''),
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
            'index' => Pages\ListCvs::route('/'),
            'create' => Pages\CreateCv::route('/create'),
            'edit' => Pages\EditCv::route('/{record}/edit'),
        ];
    }
}
