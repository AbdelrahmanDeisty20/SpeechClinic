<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CallUsResource\Pages;
use App\Models\callUs;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;

class CallUsResource extends Resource
{
    protected static ?string $model = callUs::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-phone-arrow-up-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Systems Config';

    protected static ?string $navigationLabel = 'Call Us Requests';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Call Request Details')
                    ->schema([
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Select::make('branch_id')
                            ->relationship('branch', 'name_en')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('phone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branch.name_en')
                    ->label('Branch')
                    ->badge()
                    ->color('info'),
                TextColumn::make('created_at')
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
            'index' => Pages\ListCallUs::route('/'),
            'create' => Pages\CreateCallUs::route('/create'),
            'view' => Pages\ViewCallUs::route('/{record}'),
            'edit' => Pages\EditCallUs::route('/{record}/edit'),
        ];
    }
}
