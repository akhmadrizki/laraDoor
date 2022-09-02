<?php

namespace App\Services\Session;

class Session
{
  public function put(string $key, mixed $value): void
  {
    $_SESSION[$key] = $value;
  }

  public function get(string $key, mixed $default = []): array
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }

    return $default;
  }

  public function forget(string $key): void
  {
    unset($_SESSION[$key]);
  }
}
