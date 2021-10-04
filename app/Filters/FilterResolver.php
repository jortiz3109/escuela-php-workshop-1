<?php

namespace App\Filters;

final class FilterResolver
{
    /**
     * The default namespace where model filters reside.
     */
    protected static string $namespace = 'App\\Filters\\ModelFilters\\';

    public static function filterForModel(string $modelName, array $filters): Filter
    {
        $filterName = self::resolverFilterName($modelName);
        return new $filterName($filters);
    }

    public static function resolverFilterName(string $modelName): string
    {
        return self::$namespace . class_basename($modelName) . 'Filters';
    }
}
