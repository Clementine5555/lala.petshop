<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BaseModel extends Model
{
    use LogsActivity;

    // Catat semua field
    protected static $logAttributes = ['*'];

    // Hanya log perubahan yang bener-bener beda
    protected static $logOnlyDirty = true;

    // Optional: kasih nama log sesuai model
    protected static $logName = 'model_changes';

    // Custom deskripsi log
    public function getDescriptionForEvent(string $eventName): string
    {
        return class_basename($this) . " has been {$eventName}";
    }

    // Required by Spatie\Activitylog\Traits\LogsActivity in recent versions
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName(static::$logName ?? 'model_changes')
            ->logAll()
            ->logOnlyDirty();
    }
}
