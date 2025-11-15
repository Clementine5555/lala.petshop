<?php

namespace App\Filament\Admin\Resources\RefundDetails\Pages;

use App\Filament\Admin\Resources\RefundDetails\RefundDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRefundDetails extends ListRecords
{
    protected static string $resource = RefundDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
