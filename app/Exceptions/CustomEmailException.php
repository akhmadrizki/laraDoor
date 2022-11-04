<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Exceptions\Contracts\CustomHttpExceptionInterface;
use Illuminate\Http\RedirectResponse;
use Redirect;
use URL;

class CustomEmailException extends HttpException implements CustomHttpExceptionInterface
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
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function render($request): RedirectResponse|null
    {
        if (!$request->expectsJson()) {
            flash('Sorry, your account has not been activated 🤯')->error();
            return Redirect::guest(URL::route('verification.notice'));
        }

        return null;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
