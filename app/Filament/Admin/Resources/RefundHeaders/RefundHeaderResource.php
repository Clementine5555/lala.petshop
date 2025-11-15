<?php

namespace App\Filament\Admin\Resources\RefundHeaders;

use App\Filament\Admin\Resources\RefundHeaders\Pages\CreateRefundHeader;
use App\Filament\Admin\Resources\RefundHeaders\Pages\EditRefundHeader;
use App\Filament\Admin\Resources\RefundHeaders\Pages\ListRefundHeaders;
use App\Filament\Admin\Resources\RefundHeaders\Schemas\RefundHeaderForm;
use App\Filament\Admin\Resources\RefundHeaders\Tables\RefundHeadersTable;
use App\Models\RefundHeader;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RefundHeaderResource extends Resource
{
    protected static ?string $model = RefundHeader::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-up';      

    public static function form(Schema $schema): Schema
    {
        return RefundHeaderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RefundHeadersTable::configure($table);
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
            'index' => ListRefundHeaders::route('/'),
            'create' => CreateRefundHeader::route('/create'),
            'edit' => EditRefundHeader::route('/{record}/edit'),
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
