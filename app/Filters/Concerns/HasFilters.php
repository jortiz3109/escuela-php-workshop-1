<?php

namespace App\Filters\Concerns;

use App\Filters\FilterResolver;
use Illuminate\Database\Eloquent\Builder;

trait HasFilters
{
    public static function filter(array $filters = []): Builder
    {
        $filter = FilterResolver::filterForModel(get_called_class(), $filters);
        return $filter->apply();
    }
}
