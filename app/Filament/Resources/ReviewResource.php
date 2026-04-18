<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\IconColumn;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static string|\UnitEnum|null $navigationGroup = 'المحتوى والإحصائيات';
    protected static ?int $navigationSort = 53;

    public static function getNavigationGroup(): ?string
    {
        return __('المحتوى والإحصائيات');
    }

    public static function getNavigationLabel(): string
    {
        return __('تقييمات العملاء');
    }

    public static function getPluralLabel(): string
    {
        return __('تقييمات العملاء');
    }

    public static function getLabel(): string
    {
        return __('تقييم');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Review Details'))
                    ->description(__('Feedback from the client.'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),
                        Select::make('user_id')
                            ->label(__('Related User'))
                            ->relationship('user', 'email')
                            ->searchable()
                            ->preload(),
                        TextInput::make('rate')
                            ->label(__('Rating (1-5)'))
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->maxValue(5),
                        Textarea::make('comment')
                            ->label(__('Comment'))
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rate')
                    ->label(__('Rating'))
                    ->badge()
                    ->color('warning')
                    ->suffix(' / 5'),
                ToggleColumn::make('is_active')
                    ->label(__('Is Active')),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'view' => Pages\ViewReview::route('/{record}'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
