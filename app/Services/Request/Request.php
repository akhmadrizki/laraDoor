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

	public function input(string $key, mixed $default = null): mixed
	{
		return isset($_POST[$key]) ? trim(string: $_POST[$key]) : $default;
	}

	public function only(array $keys): array
	{
		$arr = [];

		foreach ($keys as $key) {
			$arr[$key] = $this->input($key);
		}

		return $arr;
	}

	public function query(string $attribute, mixed $default = null): mixed
	{
		return isset($_GET[$attribute]) ? trim(string: $_GET[$attribute]) : $default;
	}
}
