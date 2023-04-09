<?php

namespace App\Http\Controllers;

use App\Dtos\FriendPokeDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\FriendPokeRequest;
use App\Services\FriendPokeService;
use Illuminate\Http\JsonResponse;

class FriendPokeController extends Controller
{
    public function __construct(
        private readonly FriendPokeService $friendPokeService,
    ) {
    }

    /**
     * Create a new friend poke
     */
    public function create(FriendPokeRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["sender_id", "receiver_id"]);

        $poke = $this->friendPokeService->create(new FriendPokeDto($validated["sender_id"], $validated["receiver_id"]));

        return response()->json([
            'message' => 'Friend poke was created successfully',
            'data' => $poke
        ], 201);
    }
}
