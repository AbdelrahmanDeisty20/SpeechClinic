<?php

namespace App\Filament\Resources\TransferNumbers;

use App\Filament\Resources\TransferNumbers\Pages\CreateTransferNumber;
use App\Filament\Resources\TransferNumbers\Pages\EditTransferNumber;
use App\Filament\Resources\TransferNumbers\Pages\ListTransferNumbers;
use App\Filament\Resources\TransferNumbers\Schemas\TransferNumberForm;
use App\Filament\Resources\TransferNumbers\Tables\TransferNumbersTable;
use App\Models\TransferNumber;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TransferNumberResource extends Resource
{
    protected static ?string $model = TransferNumber::class;

    protected static ?string $navigationIcon = Heroicon::OutlinedPhone;

    protected static ?string $navigationLabel = 'أرقام التحويل';

    protected static ?string $pluralLabel = 'أرقام التحويل';

    protected static ?string $label = 'رقم تحويل';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TransferNumberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransferNumbersTable::configure($table);
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
            'index' => ListTransferNumbers::route('/'),
            'create' => CreateTransferNumber::route('/create'),
            'edit' => EditTransferNumber::route('/{record}/edit'),
        ];
    }
}
