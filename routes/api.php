<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\FriendPokeController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserBlockListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("v1")->group(function () {
    Route::get('health', function () {
        return response()->json([
            'status' => 'ok',
            'message' => 'Service is running'
        ]);
    });

    Route::prefix("authentication")->group(function () {
        Route::post("/register", [AuthenticationController::class, "register"])->name("v1.authentication.register");
        Route::post("/login", [AuthenticationController::class, "login"])->name("v1.authentication.login");
        Route::prefix("admins")->group(function () {
            Route::post("/register", [AuthenticationController::class, "adminRegister"])->name("v1.authentication.admin.register");
            Route::post("/login", [AuthenticationController::class, "adminLogin"])->name("v1.authentication.admin.login");
        });
        Route::post("/request-password-reset", [AuthenticationController::class, "requestPasswordReset"])->name("v1.authentication.request-password-reset");
        Route::post("/logout", [AuthenticationController::class, "logout"])->middleware("auth:sanctum")->name("v1.authentication.logout");
    });

    Route::middleware("auth:sanctum")->group(function () {
        Route::prefix("users")->group(function () {
            Route::get("/", [UserController::class, "index"])->name("v1.user.index");
            Route::get("/{id}", [UserController::class, "show"])->name("v1.user.show");
            Route::post("/", [UserController::class, "store"])->name("v1.user.store");
            Route::put("/{id}", [UserController::class, "update"])->name("v1.user.update");
            Route::delete("/{id}", [UserController::class, "destroy"])->name("v1.user.destroy");
        });

        Route::prefix("accounts")->group(function () {
            Route::post("/create", [AccountController::class, "create"])->name("v1.account.create");
            Route::post("/update-mood", [AccountController::class, "updateMood"])->name("v1.account.update-mood");
            Route::get("user/{user-id}", [AccountController::class, "user"])->name("v1.account.user");
        });

        Route::prefix("account-settings")->group(function () {
            Route::post("/create", [AccountSettingController::class, "create"])->name("v1.account-setting.create");
            Route::post("/update/{id}", [AccountSettingController::class, "update"])->name("v1.account-setting.update");
            Route::get("/user/{user-id}", [AccountSettingController::class, "readByUser"])->name("v1.account-setting.user");
        });

        Route::prefix("uploads")->group(function () {
            Route::post("/upload", [UploadController::class, "upload"])->name("v1.upload.upload");
        });

        Route::prefix("locations")->group(function () {
            Route::post("/create", [LocationController::class, "create"])->name("v1.location.create");
            Route::get("/nearby", [LocationController::class, "nearbyUsers"])->name("v1.location.nearby");
        });

        Route::prefix("friend-requests")->group(function () {
            Route::post("/create", [FriendRequestController::class, "create"])->name("v1.friend-request.create");
            Route::post("/accept/{id}", [FriendRequestController::class, "accept"])->name("v1.friend-request.accept");
            Route::post("/decline", [FriendRequestController::class, "decline"])->name("v1.friend-request.decline");
            Route::get("/sender/{sender-id}", [FriendRequestController::class, "readBySender"])->name("v1.friend-request.sender");
            Route::get("/receiver/{receiver-id}", [FriendRequestController::class, "readByReceiver"])->name("v1.friend-request.receiver");
        });

        Route::prefix("friend-pokes")->group(function () {
            Route::post("/create", [FriendPokeController::class, "create"])->name("v1.friend-poke.create");
            Route::get("/user/{user-id}", [FriendPokeController::class, "readByUser"])->name("v1.friend-poke.user");
        });

        Route::prefix("user-block-lists")->group(function () {
            Route::post("/create", [UserBlockListController::class, "create"])->name("v1.user-block.create");
            Route::get("/user/{user-id}", [UserBlockListController::class, "readByUser"])->name("v1.user-block.user");;
        });
    });
});

// not found route
Route::any('{any}', function (string $any) {
    return response()->json([
        "status" => false,
        "message" => "Route '" . (request()->getMethod() . ' ' . $any) . "' Not Found",
    ], 404);
})->where('any', '.*');