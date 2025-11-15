<?php

namespace App\Filament\Admin\Resources\RefundHeaders\Pages;

use App\Filament\Admin\Resources\RefundHeaders\RefundHeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRefundHeaders extends ListRecords
{
    protected static string $resource = RefundHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
