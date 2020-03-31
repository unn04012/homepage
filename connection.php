<?php
function db_connect(){
  $result = new mysqli('localhost', 'root', '1234', 'user');
  if (!$result) {
    throw new Exception('Could not connect to database server');
  } else {
    return $result;
  }
}
 ?>
