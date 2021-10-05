<?php

namespace App\Filters\Conditions;

use Illuminate\Database\Eloquent\Builder;

class EnabledAt
{
    public static function append(Builder $query, string $date): void
    {
        $query->whereDate('enabled_at', $date);
    }
}
