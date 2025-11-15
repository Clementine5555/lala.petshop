<?php

namespace App\Filament\Admin\Resources\AppointmentDetails\Pages;

use App\Filament\Admin\Resources\AppointmentDetails\AppointmentDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAppointmentDetail extends EditRecord
{
    protected static string $resource = AppointmentDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
