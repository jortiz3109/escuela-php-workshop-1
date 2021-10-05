<?php

namespace App\Filters\Conditions;

use Illuminate\Database\Eloquent\Builder;

class Enabled
{
    public static function append(Builder $query, bool $enabled): void
    {
        (true === $enabled)
            ? $query->whereNotNull('enabled_at')
            : $query->whereNull('enabled_at');
    }
}
