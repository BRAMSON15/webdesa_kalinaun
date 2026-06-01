<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            ActivityLog::log(
                'create',
                class_basename($model),
                $model->id,
                'Created ' . class_basename($model),
                null,
                $model->toArray()
            );
        });

        static::updated(function ($model) {
            $oldValues = $model->getOriginal();
            $newValues = $model->getAttributes();
            
            // Only log if there are actual changes
            $changes = array_diff_assoc($newValues, $oldValues);
            if (!empty($changes)) {
                ActivityLog::log(
                    'update',
                    class_basename($model),
                    $model->id,
                    'Updated ' . class_basename($model),
                    $oldValues,
                    $newValues
                );
            }
        });

        static::deleted(function ($model) {
            ActivityLog::log(
                'delete',
                class_basename($model),
                $model->id,
                'Deleted ' . class_basename($model),
                $model->toArray(),
                null
            );
        });
    }
}
