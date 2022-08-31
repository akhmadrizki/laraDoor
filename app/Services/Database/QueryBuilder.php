<?php

namespace App\Services\Database;

use App\Services\Database\MySqlConnection;
use Exception;
use PDO;

class QueryBuilder
{
  protected MySqlConnection $db;
  protected string $table;
  protected ?array $select;
  protected string $query;
  protected array $orderBy = [];

  public function __construct()
  {
    $this->db      = new MySqlConnection();
    $this->table   = "";
    $this->select  = null;
    $this->query   = "";
  }

  public function table(string $table)
  {
    $this->table = $table;
    return $this;
  }

  // public function orderBy(array $order)
  // {
  //   $this->orderBy = $order;
  //   return $this;
  // }

  public function insert(array $data)
  {
    $insert  = "INSERT INTO {$this->table}(title, message) VALUES (:title, :message)";
    $stm     = $this->db->query($insert);
    $title   = strtolower($data['title']);
    $message = strtolower($data['message']);
    $stm->bindParam(':title', $title, PDO::PARAM_STR);
    $stm->bindParam(':message', $message, PDO::PARAM_STR);
    $stm->execute();
  }

  public static function from(string $table): static
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

  public function select(array $columns)
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

    // dd($this->orderBy);

    return $this->query;
  }
}
