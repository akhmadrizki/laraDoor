<?php

namespace App\Services\Message;

use App\Services\Database\QueryBuilder;
use DateTime;

class MessageService
{

  public function get()
  {
    /**
     * This variable get return thic code
     * SELECT * FROM posts ORDER BY created_at DESC
     */
    $get = QueryBuilder::from(Message::getTable())->select(['*'])->orderBy(['created_at', 'DESC'])->get();

    $msg = [];

    /**
     * The code loop data from Message.php
     * then put on the array msg
     */
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
