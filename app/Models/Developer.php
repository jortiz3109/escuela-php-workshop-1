<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Developer extends Model
{
    use HasFactory;

    public function scopeByName(Builder $query, string $name): Builder
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    public function scopeByEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', 'like', "%{$email}");
    }

    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        foreach ($filters as $filter => $value) {
            $scopeName = Str::camel("scopeBy{$filter}");
            $this->{$scopeName}($query, $value);
        }

        return $query;
    }
}
