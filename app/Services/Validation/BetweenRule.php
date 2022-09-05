<?php

namespace App\Services\Validation;

class BetweenRule implements Rules
{
	protected int $min;
	protected int $max;
	protected string $customMessage;

	public function __construct(int $min, int $max, string $customMessage = '')
	{
		$this->min           = $min;
		$this->max           = $max;
		$this->customMessage = $customMessage;
	}

	public function isValid(mixed $value): bool
	{
		if (is_string($value)) {
			$value = strlen($value);
		}

		if (!is_int($value)) {
			return false;
		}

		return $this->min <= $value && $this->max >= $value;
	}

	public function getMessage($attribute)
	{
		return $this->customMessage ?: "{$attribute} is reqquired";
	}
}
