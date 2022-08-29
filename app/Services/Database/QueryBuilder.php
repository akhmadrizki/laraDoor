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
  protected ?array $orderBy;
  protected string $query;

  public function __construct()
  {
    $this->db    = new MySqlConnection();
    $this->table = "";
    $this->select = null;
    $this->orderBy = null;
    $this->query = "";
  }

  public function table(string $table)
  {
    $this->table = $table;
    return $this;
  }

  public function select(array $select)
  {
    $this->select = $select;
    return $this;
  }

  public function orderBy(array $order)
  {
    $this->orderBy = $order;
    return $this;
  }

  public function get()
  {
    if ($this->select != null) {
      $this->query .= "SELECT ";

      $joined = join(',', $this->select);
      $this->query .= $joined;
    }

    if ($this->table != null) {
      $this->query .= " FROM {$this->table}";
    }

    if ($this->orderBy != null) {
      $this->query .= " ORDER BY ";
      $joined = join(' ', $this->orderBy);
      $this->query .= $joined;
    }

    $this->db->query($this->query);

    try {
      return $this->db->fetchAll();
    } catch (Exception $e) {
      echo $e->getMessage();
      die;
    }
  }

  public function insert(array $data)
  {
    $insert = "INSERT INTO {$this->table}(title, message) VALUES (:title, :message)";
    $stm = $this->db->query($insert);
    $secureMsg = htmlspecialchars(strtolower($data['message']));
    $secureTitle = htmlspecialchars(strtolower($data['title']));
    $stm->bindParam(':title', $secureTitle, PDO::PARAM_STR);
    $stm->bindParam(':message', $secureMsg, PDO::PARAM_STR);
    $stm->execute();
  }
}
