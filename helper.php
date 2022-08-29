<?php

function view(string $path, array $data = []): void
{
  extract($data);
  require "views/{$path}.php";
}
