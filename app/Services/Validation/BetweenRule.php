<?php

namespace App\Services\Validation;

class BetweenRule
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
    if (strlen($value) < $this->min || strlen($value) > $this->max) {
      return false;
    }

    return true;
  }

  public function getMessage()
  {
    if ($this->customMessage == '') {
      return "{$this->min} {$this->max}";
    } else {
      return $this->customMessage;
    }
  }
}
