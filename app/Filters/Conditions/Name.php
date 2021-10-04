<?php

namespace App\Filters\Conditions;

use Illuminate\Database\Eloquent\Builder;

class Name
{
    public static function append(Builder $query, string $name): void
    {
        $query->where('name', 'like', "%{$name}%");
    }
}
