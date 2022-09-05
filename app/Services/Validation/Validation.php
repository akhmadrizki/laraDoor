<?php

namespace App\Services\Validation;

class Validation
{
	protected array $error = [];

	public static function make(array $attributes, array $rules): static
	{
		$validation = new static;

		foreach ($rules as $attribute => $attrRules) {
			foreach ($attrRules as $rule) {
				if (!$rule->isValid($attributes[$attribute] ?? null)) {
					$validation->error[$attribute][] = $rule->getMessage($attribute);
				}
			}
		}

		// dd($validation);
		return $validation;
	}

	/**
	 * This function to know the validation is fail or not
	 *
	 * @return boolean
	 */
	public function fails(): bool
	{
		if (count($this->error) > 0) {
			return true;
		}

		return false;
	}

	public function getErrors(): array
	{
		return $this->error;
	}
}
