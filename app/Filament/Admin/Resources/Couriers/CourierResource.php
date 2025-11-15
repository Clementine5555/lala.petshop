<?php

namespace App\Filament\Admin\Resources\Couriers;

use App\Filament\Admin\Resources\Couriers\Pages\CreateCourier;
use App\Filament\Admin\Resources\Couriers\Pages\EditCourier;
use App\Filament\Admin\Resources\Couriers\Pages\ListCouriers;
use App\Filament\Admin\Resources\Couriers\Schemas\CourierForm;
use App\Filament\Admin\Resources\Couriers\Tables\CouriersTable;
use App\Models\Courier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourierResource extends Resource
{
    protected static ?string $model = Courier::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';      

    public static function form(Schema $schema): Schema
    {
        return CourierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CouriersTable::configure($table);
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
            'index' => ListCouriers::route('/'),
            'create' => CreateCourier::route('/create'),
            'edit' => EditCourier::route('/{record}/edit'),
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
