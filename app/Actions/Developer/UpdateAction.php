<?php

namespace App\Actions\Developer;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class UpdateAction extends Action
{
    public function execute(array $data, Model $developer): Model
    {
        foreach ($data as $field => $value) {
            $developer->{$field} = $value;
        }

        $developer->save();

        return $developer;
    }
}
