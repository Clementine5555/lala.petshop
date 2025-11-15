<?php

namespace App\Filament\Admin\Resources\Couriers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('total_deliveries_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_distance_km')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
