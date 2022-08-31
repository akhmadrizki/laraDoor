<?php

namespace App\Services\Validation;

class RequiredRule
{
  public function __construct(string $customMessage = '')
  {
    $this->customMessage = $customMessage;
  }

  public function isValid(mixed $value): bool
  {
    if ($value == null || $value == '') {
      return false;
    }
    return true;
  }

  public function getMessage()
  {
    if ($this->customMessage == '') {
      return "Harus isi";
    } else {
      return $this->customMessage;
    }
  }
}
