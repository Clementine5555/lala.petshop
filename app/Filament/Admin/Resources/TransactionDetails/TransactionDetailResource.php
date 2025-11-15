<?php

namespace App\Filament\Admin\Resources\TransactionDetails;

use App\Filament\Admin\Resources\TransactionDetails\Pages\CreateTransactionDetail;
use App\Filament\Admin\Resources\TransactionDetails\Pages\EditTransactionDetail;
use App\Filament\Admin\Resources\TransactionDetails\Pages\ListTransactionDetails;
use App\Filament\Admin\Resources\TransactionDetails\Schemas\TransactionDetailForm;
use App\Filament\Admin\Resources\TransactionDetails\Tables\TransactionDetailsTable;
use App\Models\TransactionDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionDetailResource extends Resource
{
    protected static ?string $model = TransactionDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';      

    public static function form(Schema $schema): Schema
    {
        return TransactionDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionDetailsTable::configure($table);
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
            'index' => ListTransactionDetails::route('/'),
            'create' => CreateTransactionDetail::route('/create'),
            'edit' => EditTransactionDetail::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
