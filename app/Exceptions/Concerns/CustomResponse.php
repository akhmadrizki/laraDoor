<?php

namespace App\Exceptions\Concerns;

use App\Exceptions\Contracts\CustomHttpExceptionInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Str;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

trait CustomResponse
{
    protected function needCustomResponse($request): bool
    {
        return $request->routeIs($this->customResponseRoutes());
    }

    protected function customResponseRoutes(): array
    {
        return  [];
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception): JsonResponse
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
    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        if (!$this->needCustomResponse($request)) {
            return parent::prepareJsonResponse($request, $e);
        }

        return response()->json([
            'error' => [
                'code'    => $this->getStatusCode($e),
                'title'   => $this->getTitle($e),
                'message' => $this->getMessage($e),
                'errors'  => [],
            ]
        ], status: $this->getStatusCode($e));
    }

    /**
     * Undocumented function
     *
     * @param Throwable $e
     * @return string
     */
    protected function getTitle(Throwable $e): string
    {
        $previousException = $e->getPrevious();
        $statusCode = $this->getStatusCode($e);

        if ($e instanceof CustomHttpExceptionInterface) {
            return $e->getTitle();
        }

        if ($previousException) {
            return match (true) {
                $previousException instanceof ModelNotFoundException => 'Resource not found',
                $previousException instanceof AuthorizationException => 'Access denied',
                default => 'Unexpected Error Occurred',
            };
        }

        return match ($statusCode) {
            Response::HTTP_BAD_REQUEST => 'Bad Request',
            Response::HTTP_UNAUTHORIZED => 'Unauthorized',
            Response::HTTP_NOT_FOUND => 'Not Found',
            Response::HTTP_FORBIDDEN => 'Forbidden',
            Response::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
            default => 'Unexpected Error Occurred',
        };
    }

    /**
     * @param Throwable|HttpExceptionInterface $e
     * @return int
     */
    protected function getStatusCode(Throwable|HttpExceptionInterface $e): int
    {
        return $this->isHttpException($e) ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * @param Throwable $e
     * @return string
     */
    public function getMessage(Throwable $e): string
    {
        $previousException = $e->getPrevious();

        if ($previousException instanceof ModelNotFoundException) {
            return $this->modelNotFoundMessage($previousException);
        }

        return $e->getMessage();
    }

    /**
     * @param ModelNotFoundException $e
     * @return string
     */
    protected function modelNotFoundMessage(ModelNotFoundException $e): string
    {
        $model = new ($e->getModel());

        if (method_exists($model, 'notFoundMessage')) {
            return $model->notFoundMessage();
        }

        $model = explode('\\', (string) $e->getModel());
        $model = implode(' ', Str::ucsplit(end($model)));

        return 'Sorry, the ' . $model . 'is not found';
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
        return $request->expectsJson() || $this->needCustomResponse($request);
    }
}
