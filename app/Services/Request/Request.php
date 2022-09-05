<?php

namespace App\Services\Request;

class Request
{

	public function isPost(): bool
	{
		return $this->getMethod() === 'POST';
	}

	public function getMethod(): string
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function only(array $attributes): array
	{
		$arr = [];

		foreach ($attributes as $attribute) {
			$arr[$attribute] = trim($_POST[$attribute]);
		}

		return $arr;
	}
}
