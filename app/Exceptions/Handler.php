<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function needCustomResponse($request): bool
    {
        return $request->routeIs('api.*');
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        if (!$this->needCustomResponse($request)) {
            return parent::invalidJson($request, $exception);
        }

        $err = [];

        foreach ($exception->errors() as $key => $value) {
            $err[] = [
                'key' => $key,
                'message' => $value[0]
            ];
        }

        return response()->json([
            'error' => [
                'code'    => $exception->status,
                'title'   => 'Validation Error',
                'message' => 'The given data was invalid',
                'errors'  => $err,
            ]
        ], $exception->status);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, Throwable $e)
    {
        if (!$this->needCustomResponse($request)) {
            return parent::prepareJsonResponse($request, $e);
        }

        return response()->json([
            'error' => [
                'code'    => $this->isHttpException($e) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR,
                'title'   => 'Server Error',
                'message' => $e->getMessage(),
                'errors'  => [],
            ]
        ], status: $this->isHttpException($e) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Convert an authentication exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (!$this->needCustomResponse($request)) {
            return parent::unauthenticated($request, $exception);
        }

        return response()->json([
            'error' => [
                'code'    => Response::HTTP_UNAUTHORIZED,
                'title'   => 'Authentication Failed',
                'message' => 'Unauthenticated',
                'errors'  => [],
            ]
        ], status: Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Determine if the exception handler response should be JSON.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return bool
     */
    protected function shouldReturnJson($request, Throwable $e)
    {
        return $request->expectsJson() || $request->routeIs('api.*');
    }
}
