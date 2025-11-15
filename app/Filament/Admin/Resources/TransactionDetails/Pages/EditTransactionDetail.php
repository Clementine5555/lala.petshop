<?php

namespace App\Filament\Admin\Resources\TransactionDetails\Pages;

use App\Filament\Admin\Resources\TransactionDetails\TransactionDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTransactionDetail extends EditRecord
{
    protected static string $resource = TransactionDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
