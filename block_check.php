<?php
include("../login/connect.php");

$user_block = $_POST['check'];

if(!$user_block){
  echo "<script> alert('선택하세요'); </script>";
  echo "<script> location.replace('user_board.php'); </script>";
}
for($i=0; $i<count($user_block); $i++){
  $sql = "SELECT mb_block FROM member WHERE mb_id = '$user_block[$i]'";
  $result = mysqli_query($conn, $sql);
  $mb = mysqli_fetch_assoc($result);
  if($mb['mb_block']==1){
    $sql = "UPDATE member SET mb_block = 0 WHERE mb_id = '$user_block[$i]'";
    $result = mysqli_query($conn, $sql);
  }else {
    $sql = "UPDATE member SET mb_block = 1 WHERE mb_id = '$user_block[$i]'";
    $result = mysqli_query($conn, $sql);
  }

}

if($result){
  echo "<script> alert('완료'); </script>";
  echo "<script> location.replace('user_board.php'); </script>";
}else{
  echo "실패";
}
 ?>
