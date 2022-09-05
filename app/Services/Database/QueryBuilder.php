<?php

namespace App\Services\Database;

use App\Services\Database\MySqlConnection;
use Exception;
use PDO;

class QueryBuilder
{
	protected MySqlConnection $db;
	protected string $table;
	protected ?array $select = ["*"];
	protected string $query;
	protected array $orderBy = [];
	protected int $limit;
	protected int $offset;
	protected $total_record;
	protected $limValue;
	// isi default value disini yaa jgn di dlm construct!!!

	public function __construct()
	{
		$this->db      = new MySqlConnection();
		$this->table   = "";
		$this->query   = "";
	}

	public function table(string $table)
	{
		$this->table = $table;

		return $this;
	}

	public function insert(array $data)
	{
		// dd(array_keys($data));
		// array_fill

		$keys 		 = join(', ', array_keys($data));
		$valueNumber = count(array_keys($data));
		$repeat 	 = str_repeat("?,", $valueNumber);
		$removeChar  = rtrim($repeat, ",");
		// dd($removeChar);

		$insert  = "INSERT INTO {$this->table}($keys) VALUES ($removeChar)";
		$stm     = $this->db->query($insert);

		$index   = 1;
		foreach ($data as $value) {
			$toLower = strtolower($value);
			$stm->bindParam($index, $toLower, PDO::PARAM_STR);
			$index++;
		}

		$stm->execute();

		// $insert  = "INSERT INTO {$this->table}(title, message) VALUES (?, ?)";
		// dd($insert);

		// foreach ($data as $key => $value) {
		// 	$insert  = "INSERT INTO {$this->table}($key) VALUES (:title, :message)";
		// 	echo $
		// }


		// foreach ($data as $key) {
		// 	return $key;
		// }



		// $stm     = $this->db->query($insert);
		// $title   = strtolower($data['title']);
		// $message = strtolower($data['message']);

		// $stm->bindParam(':title', $title, PDO::PARAM_STR);
		// $stm->bindParam(':message', $message, PDO::PARAM_STR);
		// $stm->execute();
	}

	public function from(string $table): static
	{
		$builder = new static;

		$builder->setTable($table);

		return $builder;
	}

	public function setTable(string $table): static
	{
		$this->table = $table;

		return $this;
	}

	public function select(array $columns): static
	{
		$this->select = $columns;

		return $this;
	}

	public function orderBy(string $column, string $direction = 'ASC'): static
	{
		$this->orderBy[] = $column . ' ' . $direction;

		return $this;
	}


	public function get(): array
	{
		$query = $this->buildQuery();

		// dd($query);

		// Prepare data
		$this->db->query($query);

		try {
			return $this->db->fetchAll();
		} catch (Exception $e) {
			echo $e->getMessage();

			die;
		}
	}

	public function limit(int $offset, int $limit): static
	{
		$this->offset = $offset;
		$this->limit = $limit;

		return $this;
	}

	public function paginate(int $lim)
	{
		// $start = 0;
		// if ($this->current_page() > 1) {
		// 	$start = ($this->current_page() * $lim) - $lim;
		// }

		// $stmt = "SELECT * FROM posts LIMIT $start, {$lim}";

		// $this->limValue = $lim;
		// dd($this->limValue);


		$query = $this->buildQueryPagination($lim);
		// dd($query);
		$this->limValue = $lim;

		// Prepare data
		$this->db->query($query);

		try {
			return $this->db->fetchAll();
		} catch (Exception $e) {
			echo $e->getMessage();
			die;
		}
	}

	public function setTotalRecord()
	{
		$stmt = "SELECT * FROM posts";
		// Prepare data
		$this->db->query($stmt);

		try {
			$this->db->fetchAll();
		} catch (Exception $e) {
			echo $e->getMessage();
			die;
		}

		$this->total_record = count($this->db->fetchAll());
	}

	public function current_page()
	{
		return isset($_GET['page']) ? (int)$_GET['page'] : 1;
	}

	public function get_pagination_number($paginate)
	{
		$this->setTotalRecord();

		return ceil($this->total_record / $paginate);
	}

	protected function buildQuery(): string
	{
		// This logic below for combine the query to execute database

		if ($this->select != null) {
			$this->query .= "SELECT ";

			$joined = join(',', $this->select);
			$this->query .= $joined;
		}

		if ($this->from($this->table) != null) {
			$this->query .= " FROM {$this->table}";
		}

		if ($this->orderBy != null) {
			$this->query .= " ORDER BY ";
			$joined      = join(', ', $this->orderBy);
			$this->query .= $joined;
		}

		if ($this->limit != null) {
			$offset = strval($this->offset);
			$limit = strval($this->limit);
			$this->query .= " LIMIT ";
			$this->query .= $offset . ',' . $limit;
		}

		// dd($this->orderBy);
		return $this->query;
	}

	public function buildQueryPagination($limit): string
	{
		// This logic below for combine the query to execute database

		if ($this->select != null) {
			$this->query .= "SELECT ";

			$joined = join(',', $this->select);
			$this->query .= $joined;
		}

		if ($this->from($this->table) != null) {
			$this->query .= " FROM {$this->table}";
		}

		if ($this->orderBy != null) {
			$this->query .= " ORDER BY ";
			$joined      = join(', ', $this->orderBy);
			$this->query .= $joined;
		}

		$start = 0;
		if ($this->current_page() > 1) {
			$start = ($this->current_page() * $limit) - $limit;
		}

		$this->query .= " LIMIT ";
		$this->query .= $start . ',' . $limit;

		return $this->query;
	}
}
