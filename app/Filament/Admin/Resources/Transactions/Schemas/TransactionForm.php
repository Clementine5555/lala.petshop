<?php

namespace App\Filament\Admin\Resources\Transactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('payment_id')
                    ->relationship('payment', 'payment_id')
                    ->required(),
                Select::make('delivery_method')
                    ->options(['pickup' => 'Pickup', 'delivery' => 'Delivery'])
                    ->default('delivery')
                    ->required(),
                Select::make('status')
                    ->options([
            'processing' => 'Processing',
            'waiting_for_payment' => 'Waiting for payment',
            'ready_for_pickup' => 'Ready for pickup',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('processing')
                    ->required(),
            ]);
    }
}
