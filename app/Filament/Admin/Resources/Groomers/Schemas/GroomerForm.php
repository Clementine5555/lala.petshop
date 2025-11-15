<?php

namespace App\Filament\Admin\Resources\Groomers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GroomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('total_appointments_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_minutes_worked')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
