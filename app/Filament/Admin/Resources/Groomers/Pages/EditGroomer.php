<?php

namespace App\Filament\Admin\Resources\Groomers\Pages;

use App\Filament\Admin\Resources\Groomers\GroomerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditGroomer extends EditRecord
{
    protected static string $resource = GroomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
