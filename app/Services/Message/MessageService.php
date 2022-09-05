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
		// $conn = new QueryBuilder;
		// $page = 3;
		// $get  = $conn->from(Message::getTable())->select(['*'])
		// 	->orderBy('created_at', 'DESC')
		// 	->limit(0, $page)
		// 	->get();

		// $getPaginateNumber = $conn->get_pagination_number($page);
		// $getCurrentPage    = $conn->current_page();

		// dd($get);

		$pagination = new QueryBuilder;
		$paginate = 9;
		$a = $pagination->from(Message::getTable())->select(['*'])
			->orderBy('created_at', 'DESC')
			->paginate($paginate);

		$getPaginateNumber = $pagination->get_pagination_number($paginate);
		$getCurrentPage    = $pagination->current_page();
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

		// Array destructuring
		return [$msg, $getPaginateNumber, $getCurrentPage];
	}

	public function store(array $data)
	{
		$query = new QueryBuilder;

		$query->table('posts')->insert($data);
	}
}
