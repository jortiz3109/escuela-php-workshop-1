<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Filter
{
    /**
     * Applicable conditions to filter entity.
     */
    protected array $applicableConditions = [];

    /**
     * The name of the filter's corresponding model.
     */
    protected string $model;
    protected Builder $query;
    protected array $conditions;

    public function __construct(array $conditions)
    {
        $this->query = $this->newModel()->newQuery();
        $this->conditions = array_filter($conditions) ?? [];
    }

    private function newModel(): Model
    {
        $model = $this->model;

        return new $model();
    }

    public function apply(): Builder
    {
        $this->select()->joins()->conditions();
        return $this->query;
    }

    protected function conditions(): self
    {
        $applicableConditions = array_intersect_key($this->conditions, $this->applicableConditions);
        foreach ($applicableConditions as $condition => $values) {
            $conditionClass = $this->getConditionClassName($condition);
            $conditionClass::append($this->query, $values);
        }

        return $this;
    }

    private function getConditionClassName(string $condition): string
    {
        return $this->applicableConditions[$condition];
    }

    protected function joins(): self
    {
        return $this;
    }

    protected function select(): self
    {
        return $this;
    }
}
