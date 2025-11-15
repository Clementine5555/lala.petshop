<?php

namespace App\Filament\Admin\Resources\Groomers\Pages;

use App\Filament\Admin\Resources\Groomers\GroomerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGroomers extends ListRecords
{
    protected static string $resource = GroomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
