<?php

namespace App\Filament\Admin\Resources\RefundHeaders\Pages;

use App\Filament\Admin\Resources\RefundHeaders\RefundHeaderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRefundHeader extends CreateRecord
{
    protected static string $resource = RefundHeaderResource::class;
}
