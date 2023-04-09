<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Throwable;
use Psr\Log\LogLevel;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // NotFoundHttpException
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ], 404);
        });

        // Bad request
        $this->renderable(function (BadRequestException $e, $request) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ], 400);
        });

        // Unauthorized
        $this->renderable(function (UnauthorizedException $e, $request) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage(),
            ], 403);
        });

        // ErrorException
        $this->renderable(function (ErrorException $e, $request) {
            if (!config('app.debug')) {
                return response()->json([
                    "status" => false,
                    "message" => "Oops! Something went wrong. Please try again later.",
                ], 500);
            }
        });

        // AccessDeniedHttpException
        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if (!config('app.debug')) {
                return response()->json([
                    "status" => false,
                    "message" => $e->getMessage(),
                ], 403);
            }
        });

        // ValidationException
        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                "status" => false,
                "message" => $e->validator->errors()->first(),
            ], 422);
        });

        // QueryException
        $this->renderable(function (QueryException $e, $request) {
            if (!config('app.debug')) {
                return response()->json([
                    "status" => false,
                    "message" => "Oops! Something went wrong. Please try again later. [QE]",
                ], 500);
            }
        });

        // ModelNotFoundException
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if (!config('app.debug')) {
                return response()->json([
                    "status" => false,
                    "message" => "Oops! Something went wrong. Please try again later. [MNF]",
                ], 500);
            }
        });

        // AuthenticationException
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthenticated. Please login to continue.'
                ], 401);
            }
        });
    }
}
