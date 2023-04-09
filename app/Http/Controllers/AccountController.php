<?php

namespace App\Http\Controllers;

use App\Dtos\AccountDto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    function __construct(
        private readonly AccountService $accountService,
    ) {
    }

    /**
     * Create a new account
     */
    function create(AccountRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["user_id", "type", "tag", "value", "status"]);

        // $this->checkIfAuthorized($validated["user_id"]);

        $account = $this->accountService->create(new AccountDto(
            $validated["user_id"],
            $validated["type"],
            $validated["tag"],
            $validated["value"],
            $validated["status"]
        ));

        return response()->json([
            'message' => 'Account was created successfully',
            'data' => $account
        ], 201);
    }

    /**
     * Read a user's account
     */
    function user(Request $request, string $user_id): JsonResponse
    {
        $accounts = $this->accountService->readUserAccounts($user_id, $request->query("dictify") ? true : false);

        return response()->json([
            'message' => 'Accounts were read successfully',
            'data' => $accounts
        ], 200);
    }

    /**
     * Update an account
     */
    function update(Account $account, AccountRequest $request): JsonResponse
    {
        $request->validated();

        $validated = $request->safe()->only(["id", "status"]);

        $account = $this->accountService->update($account, new AccountDto(
            $validated["user_id"],
            $validated["type"],
            $validated["tag"],
            $validated["value"],
            $validated["status"]
        ));

        return response()->json([
            'message' => 'Account was updated successfully',
        ], 200);
    }
}
