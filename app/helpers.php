<?php

use App\Exceptions\CustomHttpException;

if (!function_exists('http_abort')) {
    /**
     * Abort request using http response
     *
     * @param integer $statusCode
     * @param string $title
     * @param string $message
     * @return void
     * 
     * @throws \App\Exceptions\CustomHttpException
     */
    function http_abort(int $statusCode, string $title = '', string $message = ''): void
    {
        throw new CustomHttpException($statusCode, $title, $message);
    }
}
