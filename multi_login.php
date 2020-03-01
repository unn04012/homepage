<?php
include("../login/connect.php");
session_start();

// if($_SESSION['ss_mb_id']){
//   $sql = "SELECT * FROM member WHERE mb_id = '".$_SESSION["ss_mb_id"]."'";
//   $result = mysqli_query($conn ,$sql);
//   $block = mysqli_fetch_assoc($result);
//   $user_block = $block['mb_block'];
//   if($_SESSION['ss_mb_block'] != $user_block){
//         echo "<script> alert('해당 아이디는 차단되었습니다');</script>";
//         echo "<script> location.replace('./logout.php');</script>";
//   }
// }



if($_SESSION['ss_mb_id']){
  $sql = "SELECT * FROM currentuser WHERE userID = '".$_SESSION["ss_mb_id"]."'";
  $result = mysqli_query($conn, $sql);
  $record = mysqli_fetch_assoc($result);
  $ip = $record['ipaddr'];
   if($_SESSION['ss_mb_ip'] != $ip){
     // $sql = "DELETE FROM currentUser WHERE ipaddr = '".$record["ipaddr"]."'";
     // $result = mysqli_query($conn, $sql);
     unset($_SESSION['ss_mb_ip']);
     unset($_SESSION['ss_mb_id']);
     unset($_SESSION['ss_mb_block']);

     echo "<script> alert('다른 곳에서 로그인 되었습니다');</script>";
     echo "<script> location.replace('./post.php');</script>";
     exit;
  }
}
 ?>
