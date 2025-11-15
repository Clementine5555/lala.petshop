<?php

namespace App\Filament\Admin\Resources\Carts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
                Select::make('status')
                    ->options(['active' => 'Active', 'converted' => 'Converted'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
