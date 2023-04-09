<?php

namespace App\Http\Controllers;

use App\Dtos\FriendRequestDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\FriendRequestRequest;
use App\Services\FriendRequestService;
use Illuminate\Http\JsonResponse;

class FriendRequestController extends Controller
{
    public function __construct(
        private readonly FriendRequestService $friendRequestService,
    ) {
    }

    /**
     * Create a new friend request
     */
    public function create(FriendRequestRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["sender_id", "receiver_id"]);

        $friendRequest = $this->friendRequestService->create(new FriendRequestDto(
            $validated["sender_id"],
            $validated["receiver_id"]
        ));

        return response()->json([
            'message' => 'Friend request was sent successfully',
            'data' => $friendRequest
        ], 201);
    }

    /**
     * Accept a friend request
     */
    public function accept(string $id): JsonResponse
    {
        $this->friendRequestService->accept($id);

        return response()->json([
            'message' => 'Friend request was accepted successfully',
        ], 200);
    }

    /**
     * Reject a friend request
     */
    public function reject(string $id): JsonResponse
    {
        $this->friendRequestService->reject($id);

        return response()->json([
            'message' => 'Friend request was rejected successfully',
        ], 200);
    }
}
