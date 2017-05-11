<?php

/**
 * @package   SQL
 * @module    Tbl
 * @author    Roderic Linguri
 * @copyright 2017 Digices LLC
 * @license   MIT
 */

/** @class Dbo **/
abstract class Dbo
{

  protected $pdo;

  protected $error;

  protected $host;
  
  protected $name;
  
  protected $user;
  
  protected $pass;

  public function __construct() {
  
    $this->error = false;
  
    try {
      $this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->name, $this->user, $this->pass);
      $errorInfo = $this->pdo->errorInfo();
      if (isset($errorInfo[2])) {
        $this->error = $errorInfo[2];
      }
    } catch (PDOException $e) {
    		$this->error = $e->getMessage();
    }
  
    print $this->error;
  
  }

  public function executeSQL($sql) {
    return $this->pdo->exec($sql);
  }

  public function insertStmt($sql, $values) {
    $sth = $this->pdo->prepare($sql);
    $sth->execute($values);
    return $this->pdo->lastInsertId();
  }

  public function fetchStmt()
  {
		$args = func_get_args();
		$sql = array_shift($args);
    $rows = array();
    $sth = $this->pdo->prepare($sql);
    $sth->execute($args);
    if ($result = $sth->fetch(PDO::FETCH_OBJ)) {
      foreach ($result as $row) {
        array_push($rows,$row);
      }
      return $rows;
    } else {
      return false;
    }
  }
}
