<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Repositories\CityRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function __construct(private CityRepository $cities)
    {
    }

    public function index(): JsonResponse
    {
        Log::info('CityController@index', ['count' => count($this->cities->all()), 'cities' => $this->cities->all()]);
        return response()->json([
            'data' => $this->cities->all(),
        ]);
    }

    public function store(CityRequest $request): JsonResponse
    {
        Log::info('CityController@store: incoming payload', ['payload' => $request->validated()]);
        $city = $this->cities->create($request->validated());
        Log::info('CityController@store: created', ['city' => $city]);

        return response()->json(['data' => $city], 201);
    }

    public function show(int $city): JsonResponse
    {
        $found = $this->cities->find($city);

        if (! $found) {
            return response()->json(['message' => 'City not found'], 404);
        }

        return response()->json(['data' => $found]);
    }

    public function update(CityRequest $request, int $city): JsonResponse
    {
        $updated = $this->cities->update($city, $request->validated());

        if (! $updated) {
            return response()->json(['message' => 'City not found'], 404);
        }

        return response()->json(['data' => $updated]);
    }

    public function destroy(int $city): JsonResponse
    {
        $deleted = $this->cities->delete($city);

        if (! $deleted) {
            return response()->json(['message' => 'City not found'], 404);
        }

        return response()->json([], 204);
    }
}
