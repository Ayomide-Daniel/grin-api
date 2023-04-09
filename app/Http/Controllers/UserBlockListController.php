<?php

namespace App\Http\Controllers;

use App\Dtos\UserBlockListDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserBlockRequest;
use App\Services\UserBlockListService;
use Illuminate\Http\JsonResponse;

class UserBlockListController extends Controller
{
    public function __construct(
        private readonly UserBlockListService $userBlockListService,
    ) {
    }

    /**
     * Create a new user block list
     */
    public function create(UserBlockRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["user_id", "blocked_user_id"]);

        $blockUser = $this->userBlockListService->create(new UserBlockListDto(
            $validated["user_id"],
            $validated["blocked_user_id"]
        ));

        return response()->json([
            'message' => 'User blocked successfully',
            'data' => $blockUser
        ], 201);
    }

    /**
     * Unblock a user
     */
    public function unblock(string $id): JsonResponse
    {
        $this->userBlockListService->remove($id, auth()->user());

        return response()->json([
            'message' => 'User unblocked successfully',
        ], 200);
    }
}
