<?php

namespace App\Filament\Admin\Resources\AppointmentDetails\Pages;

use App\Filament\Admin\Resources\AppointmentDetails\AppointmentDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAppointmentDetails extends ListRecords
{
    protected static string $resource = AppointmentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
