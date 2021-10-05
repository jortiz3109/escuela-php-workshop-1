<?php

namespace App\Filters\Concerns;

use App\Filters\FilterResolver;
use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    public static function filter(array $conditions = []): Builder
    {
        $filter = FilterResolver::filterForModel(get_called_class(), $conditions);
        return $filter->apply();
    }
}
