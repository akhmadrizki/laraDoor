<?php

namespace App\Services\Message;

use App\Services\Database\QueryBuilder;
use DateTime;

class MessageService
{

  public function get()
  {
    $msg = [];
    /**
     * This variable get return this code
     * SELECT * FROM posts ORDER BY created_at DESC
     * function orderBy can be added twice
     */
    // $get = QueryBuilder::from(Message::getTable())->select(['*'])
    //   ->orderBy('created_at', 'DESC')
    //   ->paginate(5);

    // dd($get);

    $pagination = new QueryBuilder;
    $a = $pagination->paginate(5);
    // dd($a);

    /**
     * The code loop data from Message.php (DTO Process)
     * then put on the array msg
     */
    foreach ($a as $value) {
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
