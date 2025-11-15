<?php

namespace App\Filament\Admin\Resources\RefundDetails\Pages;

use App\Filament\Admin\Resources\RefundDetails\RefundDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditRefundDetail extends EditRecord
{
    protected static string $resource = RefundDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
