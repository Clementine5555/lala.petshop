<?php

namespace App\Filament\Admin\Resources\RefundDetails;

use App\Filament\Admin\Resources\RefundDetails\Pages\CreateRefundDetail;
use App\Filament\Admin\Resources\RefundDetails\Pages\EditRefundDetail;
use App\Filament\Admin\Resources\RefundDetails\Pages\ListRefundDetails;
use App\Filament\Admin\Resources\RefundDetails\Schemas\RefundDetailForm;
use App\Filament\Admin\Resources\RefundDetails\Tables\RefundDetailsTable;
use App\Models\RefundDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefundDetailResource extends Resource
{
    protected static ?string $model = RefundDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-receipt-refund';      

    public static function form(Schema $schema): Schema
    {
        return RefundDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RefundDetailsTable::configure($table);
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
            'index' => ListRefundDetails::route('/'),
            'create' => CreateRefundDetail::route('/create'),
            'edit' => EditRefundDetail::route('/{record}/edit'),
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
