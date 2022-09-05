<?php

namespace App\Services\Validation;

class RequiredRule implements Rules
{
	public function __construct(string $customMessage = '')
	{
		$this->customMessage = $customMessage;
	}

	public function isValid(mixed $value): bool
	{
		if (is_null($value)) {
			return false;
		}

		if (is_array($value)) {
			return count($value) > 0;
		}

		if (is_string($value)) {
			return $value != '';
		}

		return true;
	}

	public function getMessage($attribute)
	{
		return $this->customMessage ?: "{$attribute} is reqquired";
	}
}
