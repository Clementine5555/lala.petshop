<?php

namespace App\Filament\Admin\Resources\AppointmentDetails\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('appointment_id')
                    ->relationship('appointment', 'appointment_id')
                    ->required(),
                Select::make('groomer_id')
                    ->relationship('groomer', 'groomer_id')
                    ->required(),
                Select::make('service_id')
                    ->relationship('service', 'service_id')
                    ->required(),
                Select::make('pet_id')
                    ->relationship('pet', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TimePicker::make('time')
                    ->required(),
                Textarea::make('note')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
