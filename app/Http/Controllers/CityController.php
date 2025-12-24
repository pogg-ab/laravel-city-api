<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityRequest;
use App\Repositories\CityRepository;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function __construct(private CityRepository $cities)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->cities->all(),
        ]);
    }

    public function store(CityRequest $request): JsonResponse
    {
        $city = $this->cities->create($request->validated());

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
