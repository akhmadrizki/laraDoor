<?php

namespace App\Services\Message;

use App\Services\Database\QueryBuilder;
use App\Services\Pagination\Pagination;
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
		$conn = new QueryBuilder;

		$get  = $conn->from(Message::getTable())->select(['*'])
			->orderBy('created_at', 'DESC')
			->get();

		/**
		 * The code loop data from Message.php (DTO Process)
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

	public function paginate(int $perPage, int $page, int $onEachSide): Pagination
	{
		$pagination = new QueryBuilder;

		$query      = $pagination->from(Message::getTable())->select(['*'])->orderBy('created_at', 'DESC');

		// dd($query);
		$paginator = Pagination::make($query, $perPage, $page, $onEachSide);

		$paginator->setFormater(function (array $value) {
			return new Message(
				id: $value['id'],
				title: $value['title'],
				message: $value['message'],
				created_at: new DateTime($value['created_at'])
			);
		});

		return $paginator;
	}
}
