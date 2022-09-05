<?php

namespace App\Services\Validation;

interface Rules
{
	public function isValid(mixed $attribute);
	public function getMessage(string $attribute);
}
