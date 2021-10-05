<?php

namespace App\Models;

use App\Filters\Concerns\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;
    use HasFilters;

    protected $dates = [
        'enabled_at',
    ];

    public function isEnabled(): bool
    {
        return null !== $this->enabled_at;
    }
}
