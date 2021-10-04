<?php
namespace App\Filters\ModelFilters;

use App\Filters\Conditions\Email;
use App\Filters\Conditions\Name;
use App\Filters\Filter;
use App\Models\Developer;

class DeveloperFilters extends Filter
{
    protected string $model = Developer::class;
    protected array $applicableConditions = [
        'name' => Name::class,
        'email' => Email::class
    ];

    protected function select(): Filter
    {
        $this->query->select(['id', 'name', 'email', 'created_at', 'updated_at']);
        return $this;
    }
}
