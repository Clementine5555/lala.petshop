<?php

namespace App\Filament\Admin\Resources\TransactionDetails\Pages;

use App\Filament\Admin\Resources\TransactionDetails\TransactionDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransactionDetail extends CreateRecord
{
    protected static string $resource = TransactionDetailResource::class;
}
