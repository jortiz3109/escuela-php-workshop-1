<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

abstract class Action
{
    abstract public function execute(array $data, Model $model): Model;
}
