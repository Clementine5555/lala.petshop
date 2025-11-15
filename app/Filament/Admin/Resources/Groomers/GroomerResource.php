<?php

namespace App\Filament\Admin\Resources\Groomers;

use App\Filament\Admin\Resources\Groomers\Pages\CreateGroomer;
use App\Filament\Admin\Resources\Groomers\Pages\EditGroomer;
use App\Filament\Admin\Resources\Groomers\Pages\ListGroomers;
use App\Filament\Admin\Resources\Groomers\Schemas\GroomerForm;
use App\Filament\Admin\Resources\Groomers\Tables\GroomersTable;
use App\Models\Groomer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroomerResource extends Resource
{
    protected static ?string $model = Groomer::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-scissors';      

    public static function form(Schema $schema): Schema
    {
        return GroomerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroomersTable::configure($table);
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
            'index' => ListGroomers::route('/'),
            'create' => CreateGroomer::route('/create'),
            'edit' => EditGroomer::route('/{record}/edit'),
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
