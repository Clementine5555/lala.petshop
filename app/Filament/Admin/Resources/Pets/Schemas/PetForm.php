<?php

namespace App\Filament\Admin\Resources\Pets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->default(null),
                TextInput::make('race')
                    ->default(null),
                Select::make('gender')
                    ->options(['male' => 'Male', 'female' => 'Female'])
                    ->default(null),
                TextInput::make('age')
                    ->numeric()
                    ->default(null),
                TextInput::make('weight')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
