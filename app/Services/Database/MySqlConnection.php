<?php

namespace App\Services\Database;

use PDO;
use PDOException;

class MySqlConnection
{

  private $dbh;
  private $stmt;

  public function __construct()
  {
    $db_host     = "localhost";
    $db_name     = "bulletin_board";
    $db_username = "root";
    $db_password = "";

    $conn = "mysql:host={$db_host};dbname={$db_name}";

    try {
      $this->dbh = new PDO($conn, $db_username, $db_password);
      $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $err) {
      die($err->getMessage());
    }
  }

  public function query($query)
  {
    $this->stmt = $this->dbh->prepare($query);
    return $this->stmt;
  }

  public function execute()
  {
    $this->stmt->execute();
  }

  public function fetchAll()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
