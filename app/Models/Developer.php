<?php

namespace App\Models;

use App\Filters\Concerns\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    use HasFactory;
    use HasFilters;
}
