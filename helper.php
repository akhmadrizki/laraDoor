<?php

use App\Services\Session\Session;

function view(string $path, array $data = []): void
{
	extract($data);
	require "views/{$path}.php";
}

function session()
{
	return new Session;
}

function dd($var): void
{
	echo '<pre>';
	print_r($var);
	echo '<pre>';
	die;
}

function redirect(string $url): void
{
	header('Location: ' . $url);
	die;
	exit;
}
