<?php

namespace App\Http\Controllers\Api;

use App\Actions\Developer\StoreAction;
use App\Actions\Developer\UpdateAction;
use App\Events\DeveloperCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Developers\IndexRequest;
use App\Http\Requests\Api\Developers\StoreRequest;
use App\Http\Requests\Api\Developers\UpdateRequest;
use App\Http\Resources\DeveloperCollection;
use App\Models\Developer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class DeveloperController extends Controller
{
    public function index(IndexRequest $request): ResourceCollection
    {
        $filters = Arr::get($request->validated(), 'filters', []);
        $developers = Developer::filter($filters)->paginate();
        return new DeveloperCollection($developers);
    }

    public function store(StoreRequest $request, StoreAction $storeAction): JsonResponse
    {
        $developer = $storeAction->execute($request->validated(), new Developer());
        DeveloperCreated::dispatch($developer);
        return response()->json($developer->toArray(), Response::HTTP_CREATED);
    }

    public function update(UpdateRequest $request, Developer $developer, UpdateAction $updateAction): JsonResponse
    {
        $developer = $updateAction->execute($request->all(), $developer);
        return response()->json($developer->toArray(), Response::HTTP_OK);
    }
}
