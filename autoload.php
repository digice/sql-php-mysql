<?php

/** SQL Autoload **/

$sql_dir = __DIR__.DIRECTORY_SEPARATOR.'lib';

$sql_itr = new DirectoryIterator($sql_dir);

foreach ($sql_itr as $item) {
  $file = $item->getFilename();
  if (substr($file,0,1) != '.') {
    $path = $sql_dir.DIRECTORY_SEPARATOR.$file;
    require_once($path);
  }
}
