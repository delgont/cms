<?php

namespace Delgont\Cms\Concerns;

trait HasActivityLog
{
    public function activityLog()
    {
        return $this->morphMany('Delgont\Cms\Models\Activity\ActivityLog', 'loggable');
    }
}