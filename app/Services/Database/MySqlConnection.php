<?php

namespace App\Services\Database;

use PDO;
use PDOException;

class MySqlConnection
{

  private $host;
  private $dbName;
  private $user;
  private $pass;
  private $dbh;
  private $stmt;

  public function __construct()
  {
    $this->host     = SERVER;
    $this->dbName   = DB_NAME;
    $this->user     = USER_DB;
    $this->pass     = PASS_DB;

    $conn = "mysql:host={$this->host};dbname={$this->dbName}";

    try {
      $this->dbh = new PDO($conn, $this->user, $this->pass);
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
