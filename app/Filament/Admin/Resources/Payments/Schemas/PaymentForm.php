<?php

namespace App\Filament\Admin\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('method')
                    ->options(['cash' => 'Cash', 'bank_transfer' => 'Bank transfer', 'ewallet' => 'Ewallet'])
                    ->default('cash')
                    ->required(),
                Select::make('status')
                    ->options([
                    'pending' => 'Pending',
                    'success' => 'Success',
                    'failed' => 'Failed',
                    'cancelled' => 'Cancelled',
                ])
                    ->default('pending')
                    ->required(),
                FileUpload::make('evidence')
                    ->image()
                    ->required(),
            ]);
    }
}
