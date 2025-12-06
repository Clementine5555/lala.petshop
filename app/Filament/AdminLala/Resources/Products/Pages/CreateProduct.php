<?php

namespace App\Filament\AdminLala\Resources\Products\Pages;

use App\Filament\AdminLala\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
