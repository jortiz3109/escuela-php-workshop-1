<?php

namespace App\Actions\Developer;

use App\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class StoreAction extends Action
{
    public function execute(array $data, Model $developer): Model
    {
        $developer->name = $data['name'];
        $developer->email = $data['email'];
        $developer->save();

        return $developer;
    }
}
