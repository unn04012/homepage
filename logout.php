<?php
include("../login/connect.php");
$sql = "DELETE FROM currentUser WHERE userID = '".$_SESSION["ss_mb_id"]."'";
$result = mysqli_query($conn, $sql);
if(!$result){
  echo "실패";
}
session_start();
session_unset();
session_destroy();

if(!isset($_SESSION['ss_mb_id'])){
  echo "<script> alert('로그아웃 되었습니다.'); </script>";
  echo "<script> location.replace('./homepage.php'); </script>";
  exit;
}
 ?>
