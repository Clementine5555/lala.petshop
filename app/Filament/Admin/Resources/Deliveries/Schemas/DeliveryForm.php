<?php

namespace App\Filament\Admin\Resources\Deliveries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;

class DeliveryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('courier_id')
                    ->relationship('courier', 'courier_id')
                    ->required(),
                Select::make('transaction_id')
                    ->relationship('transaction', 'transaction_id')
                    ->required(),
                Textarea::make('address')
                    ->columnSpanFull()
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'returned' => 'Returned',
        ])
                    ->default('Pending')
                    ->required(),
                FileUpload::make('evidence')
                    ->image()
                    ->required(),                    
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('delivery_date')
                    ->required(),
            ]);
    }
}
