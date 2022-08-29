<?php

namespace App\Services\Message;

use App\Services\Database\QueryBuilder;
use DateTime;

class MessageService
{

  public function get(): array
  {
    $query = new QueryBuilder;
    $get = $query->select(['*'])->table('posts')->orderBy(['created_at', 'DESC'])->get();

    $msg = [];

    foreach ($get as $value) {
      $msg[] = new Message(
        id: $value['id'],
        title: $value['title'],
        message: $value['message'],
        created_at: new DateTime($value['created_at'])
      );
    }

    return $msg;
  }

  public function store(array $data)
  {
    $query = new QueryBuilder;
    $query->table('posts')->insert($data);
  }
}
