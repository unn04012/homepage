<?php
session_start();
session_unset();
session_destroy();

if(!isset($_SESSION['ss_mb_id'])){
  echo "<script> alert('로그아웃 되었습니다.'); </script>";
  echo "<script> location.replace('./homepage.php'); </script>";
  exit;
}
 ?>
