<?php

namespace App\Filament\Admin\Resources\RefundDetails\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RefundDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('refund_id')
                    ->required()
                    ->numeric(),
                Select::make('transaction_detail_id')
                    ->relationship('transactionDetail', 'transaction_detail_id')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}
