<?php

namespace App\Filament\Admin\Resources\Pets;

use App\Filament\Admin\Resources\Pets\Pages\CreatePet;
use App\Filament\Admin\Resources\Pets\Pages\EditPet;
use App\Filament\Admin\Resources\Pets\Pages\ListPets;
use App\Filament\Admin\Resources\Pets\Schemas\PetForm;
use App\Filament\Admin\Resources\Pets\Tables\PetsTable;
use App\Models\Pet;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PetResource extends Resource
{
    protected static ?string $model = Pet::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-heart';      

    public static function form(Schema $schema): Schema
    {
        return PetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PetsTable::configure($table);
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
            'index' => ListPets::route('/'),
            'create' => CreatePet::route('/create'),
            'edit' => EditPet::route('/{record}/edit'),
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
