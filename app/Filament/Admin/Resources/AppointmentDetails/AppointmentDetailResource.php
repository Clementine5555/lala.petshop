<?php

namespace App\Filament\Admin\Resources\AppointmentDetails;

use App\Filament\Admin\Resources\AppointmentDetails\Pages\CreateAppointmentDetail;
use App\Filament\Admin\Resources\AppointmentDetails\Pages\EditAppointmentDetail;
use App\Filament\Admin\Resources\AppointmentDetails\Pages\ListAppointmentDetails;
use App\Filament\Admin\Resources\AppointmentDetails\Schemas\AppointmentDetailForm;
use App\Filament\Admin\Resources\AppointmentDetails\Tables\AppointmentDetailsTable;
use App\Models\AppointmentDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentDetailResource extends Resource
{
    protected static ?string $model = AppointmentDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-pencil-square';      

    public static function form(Schema $schema): Schema
    {
        return AppointmentDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentDetailsTable::configure($table);
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
            'index' => ListAppointmentDetails::route('/'),
            'create' => CreateAppointmentDetail::route('/create'),
            'edit' => EditAppointmentDetail::route('/{record}/edit'),
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
