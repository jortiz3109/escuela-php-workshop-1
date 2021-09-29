<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Developers\IndexRequest;
use App\Http\Resources\DeveloperCollection;
use App\Models\Developer;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

class DeveloperController extends Controller
{
    public function index(IndexRequest $request): ResourceCollection
    {
        $filters = Arr::get($request->validated(), 'filters', []);
        $developers = Developer::filter($filters)->paginate();
        return new DeveloperCollection($developers);
    }
}
