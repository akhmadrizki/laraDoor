<?php

namespace App\Exceptions\Contracts;

interface CustomHttpExceptionInterface
{
    public function getTitle(): string;
}
