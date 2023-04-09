<?php

namespace App\Http\Controllers;

use App\Dtos\CreateLocationDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationRequest;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService,
    ) {
    }

    /**
     * Create a new location
     */
    public function create(LocationRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["user_id", "latitude", "longitude", "accuracy", "status"]);

        // $this->checkIfAuthorized($validated["user_id"]);

        $location = $this->locationService->create(new CreateLocationDto(
            $validated["user_id"],
            $validated["latitude"],
            $validated["longitude"],
            $validated["accuracy"],
            $validated["status"],
        ));

        return response()->json([
            'message' => 'Location created successfully',
            'data' => $location
        ], 201);
    }

    /**
     * Get other users nearby
     */
    public function nearbyUsers(Location $location): JsonResponse
    {
        $nearbyUsers = $this->locationService->getNearbyUsers($location);

        return response()->json([
            'message' => 'Nearby users fetched successfully',
            'data' => $nearbyUsers
        ], 200);
    }
}
