<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('Clinic Management');
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::count();
    }

    public static function getNavigationLabel(): string
    {
        return __('Branches');
    }

    public static function getPluralLabel(): string
    {
        return __('Branches');
    }

    public static function getLabel(): string
    {
        return __('Branch');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('Branch Identity'))
                    ->description(__('Define localized branch names.'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name_ar')
                            ->label(__('Name AR'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('name_en')
                            ->label(__('Name EN'))
                            ->required()
                            ->maxLength(255),
                    ]),

                Section::make(__('Contact & Location'))
                    ->description(__('Branch contact information and address.'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('address_link')
                            ->label(__('Address Link'))
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_ar')
                    ->label(__('Name AR'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label(__('Name EN'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address_link')
                    ->label(__('Address Link'))
                    ->url(fn ($record) => $record->address_link)
                    ->openUrlInNewTab()
                    ->limit(30),
                TextColumn::make('phone')
                    ->label(__('Phone'))
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
            ->emptyStateHeading(__('No branches found'))
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
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'view' => Pages\ViewBranch::route('/{record}'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
