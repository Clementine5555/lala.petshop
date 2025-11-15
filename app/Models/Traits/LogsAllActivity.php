<?php

namespace App\Models\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsAllActivity
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()          // log semua atribut
            ->logOnlyDirty()    // hanya perubahan yang nyata
            ->useLogName(class_basename($this)); // optional: nama log sesuai model
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return class_basename($this) . " has been {$eventName}";
    }
}
