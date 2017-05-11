<?php

/**
 * @package   SQL
 * @module    Dbo
 * @author    Roderic Linguri
 * @copyright 2017 Digices LLC
 * @license   MIT
 */

/** @class Dbo **/
abstract class Dbo
{

  /** @property PDO instance **/
  protected $pdo;

  /** @property string **/
  protected $error;

  /** @property string **/
  protected $host;

  /** @property string **/
  protected $name;

  /** @property string **/
  protected $user;

  /** @property string **/
  protected $pass;

  /** @method Constructor **/
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

  } // ./Constructor

  /** @method ExecuteSQL
   * @param  string (sql statement)
   * @return integer (affected rows)
   **/

  public function executeSQL($sql) {
    return $this->pdo->exec($sql);
  } // ./executeSQL

  /** @method insertStatement
   * @param  string (sql statement)
   * @param  mixed (array of values)
   * @return integer (affected rows)
   **/
  public function insertStmt($sql, $values) {
    $sth = $this->pdo->prepare($sql);
    $sth->execute($values);
    return $this->pdo->lastInsertId();
  } // ./insertStmt

  /** @method fetchStatement
   * @param  string (sql statement)
   * @param  any (values)
   * @return mixed (array of row objects)
   **/
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
  } // ./fetchStmt

} // ./Dbo
