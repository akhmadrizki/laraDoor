<?php

namespace App\Exceptions;

use App\Exceptions\Contracts\CustomHttpExceptionInterface;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomHttpException extends HttpException implements CustomHttpExceptionInterface
{
    protected string $title;

    public function __construct(int $statusCode, string $title, string $message)
    {
        parent::__construct(statusCode: $statusCode,  message: $message);

        $this->title = $title;
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function render($request): void
    {
        //
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
