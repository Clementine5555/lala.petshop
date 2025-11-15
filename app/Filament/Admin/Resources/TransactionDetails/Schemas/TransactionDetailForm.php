<?php

namespace App\Filament\Admin\Resources\TransactionDetails\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TransactionDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('transaction_id')
                    ->relationship('transaction', 'transaction_id')
                    ->required(),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                TextInput::make('quantity')
                    ->numeric()
                    ->default(1),
                TextInput::make('price_at_purchase')
                    ->numeric()
                    ->default(0.0)
                    ->required(),
            ]);
    }
}
