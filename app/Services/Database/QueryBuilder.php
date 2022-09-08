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
	protected ?int $limit = null;
	protected int $offset;

	public function __construct()
	{
		$this->db      = new MySqlConnection();
		$this->table   = "";
		$this->query   = "";
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

	public function insert(array $data)
	{
		$keys 		      = join(', ', array_keys($data));
		$getPlaceholder   = array_fill(0, count(array_keys($data)), '?');
		$inputPlaceholder = join(',', $getPlaceholder);

		$insert  = "INSERT INTO {$this->table}($keys) VALUES ($inputPlaceholder)";

		$stm     = $this->db->query($insert);

		foreach (array_values($data) as $index => $value) {
			$stm->bindValue($index + 1, $value, PDO::PARAM_STR);
		}

		$stm->execute();
	}

	public function table(string $table)
	{
		$this->table = $table;

		return $this;
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

	public function limit(int $offset, int $limit): static
	{
		$this->offset = $offset;
		$this->limit = $limit;

		return $this;
	}

	protected function buildQuery(): string
	{
		// This logic below for combine the query to execute database
		$query = $this->querySelect() . $this->queryFrom() . $this->queryOrder() . $this->queryLimit();

		return $query;
	}

	public function querySelect()
	{
		$this->select != null ? $query = "SELECT " : "";

		$joined = join(',', $this->select);

		return $query .= $joined;
	}

	public function queryFrom()
	{
		$query = $this->from($this->table) != null ? " FROM {$this->table}" : "";

		return $query;
	}

	public function queryOrder()
	{
		$this->orderBy != null ? $query = " ORDER BY " : "";

		$joined      = join(', ', $this->orderBy);

		return $query .= $joined;
	}

	public function queryLimit()
	{
		$this->limit != null ? $query = " LIMIT " : "";

		$offset = strval($this->offset);
		$limit  = strval($this->limit);

		return $query .= $offset . ',' . $limit;
	}

	public function count()
	{
		$tabelName = join(',', $this->select);

		$query     = "SELECT count({$tabelName}) FROM {$this->table}";
		// dd($query);
		$this->db->query($query);
		$this->db->execute();
		$this->db->fetchColumn();

		return $this->db->fetchColumn();
	}
}
