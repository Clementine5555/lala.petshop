<?php

namespace App\Filament\Admin\Resources\RefundHeaders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RefundHeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('transaction_id')
                    ->relationship('transaction', 'transaction_id')
                    ->required(),
                DateTimePicker::make('date')
                    ->required(),
                Textarea::make('reason')
                    ->default(null)
                    ->columnSpanFull()
                    ->required(),
                Select::make('status_refund')
                    ->options([
            'reviewing' => 'Reviewing',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'refunded' => 'Refunded',
        ])
                    ->default('reviewing')
                    ->required(),
            ]);
    }
}
