<?php

namespace App\Filament\Admin\Resources\AppointmentDetails\Pages;

use App\Filament\Admin\Resources\AppointmentDetails\AppointmentDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointmentDetail extends CreateRecord
{
    protected static string $resource = AppointmentDetailResource::class;
}
