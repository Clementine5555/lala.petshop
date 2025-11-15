<?php

namespace App\Filament\Admin\Resources\Pets\Pages;

use App\Filament\Admin\Resources\Pets\PetResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePet extends CreateRecord
{
    protected static string $resource = PetResource::class;
}
