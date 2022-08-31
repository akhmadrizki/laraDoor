<?php

namespace App\Services\Message;

use DateTimeInterface;

class Message
{

  public function __construct(
    protected int $id,
    protected string $title,
    protected string $message,
    protected ?DateTimeInterface $created_at
  ) {
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getMessage(): string
  {
    return $this->message;
  }

  public function getCreatedAt(): ?DateTimeInterface
  {
    return $this->created_at;
  }

  public static function getTable(): string
  {
    return 'posts';
  }
}
