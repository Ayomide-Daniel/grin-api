<?php

namespace App\Http\Controllers;

use App\Dtos\AccountSettingDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountSettingRequest;
use App\Services\AccountSettingService;
use Illuminate\Http\JsonResponse;

class AccountSettingController extends Controller
{
    public function __construct(
        private readonly AccountSettingService $accountSettingService,
    ) {
    }

    /**
     * Create a new account setting
     */
    public function create(AccountSettingRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["user_id", "tag", "value"]);

        $accountSetting = $this->accountSettingService->create(new AccountSettingDto(
            $validated["user_id"],
            $validated["tag"],
            $validated["value"]
        ));

        return response()->json([
            'message' => 'Account setting was created successfully',
            'data' => $accountSetting
        ], 201);
    }

    /**
     * Update an account setting
     */
    public function update(string $id, AccountSettingRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["user_id", "tag", "value"]);

        /**
         * TODO: Check if the user is authorized to update the account setting by using a Policy
         */

        $this->accountSettingService->update($id, new AccountSettingDto(
            $validated["user_id"],
            $validated["tag"],
            $validated["value"]
        ));

        return response()->json([
            'message' => 'Account setting was updated successfully',
        ], 200);
    }

    /**
     * Read account setting by user
     */
    public function readByUser(string $user_id): JsonResponse
    {
        /**
         * TODO: Check if the user is authorized to update the account setting by using a Policy
         */
        // $this->checkIfAuthorized($user_id);

        $account_settings = $this->accountSettingService->readByUser($user_id);

        return response()->json([
            'message' => 'Account settings were fetched successfully',
            'data' => $account_settings
        ], 200);
    }
}
