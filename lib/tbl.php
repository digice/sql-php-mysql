<?php

/**
 * @package   SQL
 * @module    Tbl
 * @author    Roderic Linguri
 * @copyright 2017 Digices LLC
 * @license   MIT
 */

/** @class Tbl **/
abstract class Tbl
{

  /** @property string **/
  protected $name;

  /** @property Dbo **/
  protected $dbo;

  /** @method Constructor **/
  public function __construct()
  {

  } // ./Constructor

  /** @method insertAssoc
    * @param  mixed (assoc)
    * @return integer (id of inserted row)
    **/
  public function insertAssoc($assoc)
  {

    $keys = array();
    $values = array();

    foreach ($assoc as $k=>$v) {
      array_push($keys, $k);
      array_push($values, $v);
    }

    $sql = "INSERT INTO `".$this->name."` (`id`";

    foreach ($keys as $k) {
      $sql .= ", `".$k."`";
    }

    $sql .= ") VALUES (NULL";

    foreach ($values as $v) {
      $sql .= ", ?";
    }

    $sql .= ");";

    return $this->dbo->insertStmt($sql,$values);

  } // ./insertAssoc

  /** @method fetchRowById
    * @param  integer (id)
    * @return Row
    **/
  public function fetchRowById($id)
  {
    $sql = "SELECT * FROM `".$this->name."` WHERE `id` = ?;";
    if ($rows = $this->dbo->fetchStmt($sql,$id)) {
      if (isset($rows[0])) {
        return $rows[0];
      }
    }
    return false;
  } // ./fetchRowById

  /** @method fetchRowByColumn
    * @param  string (column key)
    * @param  any (value to match)
    * @return mixed (array of rows)
    **/
  public function fetchRowsByColumn($column,$value)
  {
    $sql = "SELECT * FROM `".$this->name."` WHERE `".$column."` = ?;";
    if ($rows = $this->dbo->fetchStmt($sql,$value)) {
      if (count($rows) > 0) {
        return $rows;
      }
    }
    return false;
  } // ./fetchRowsByColumn

} // ./Tbl
