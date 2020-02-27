<?php
include("../login/connect.php");

$mb_id = trim($_POST['id']);
$mb_password = trim($_POST['pw']);

if(!$mb_id || !$mb_password){
  echo "<script> alert('아이디 또는 비밀번호를 입력하세요'); </script>";
  echo "<script> location.replace('./login.php'); </script>";
  exit;
}

$sql = "SELECT * FROM member WHERE mb_id = '$mb_id'";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM admin WHERE admin_id = '$mb_id'";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);
$admin_id = $admin['admin_id'];
$admin_pw = $admin['admin_pw'];

$sql = "SELECT $mb_password AS pass"; // 입력한 비밀번호를 password()함수를 이용해 암호화해서 가져옴
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$password = $row['pass'];

if(($admin['admin_id']==$mb_id) && ($admin['admin_pw'] == $mb_password)){
  echo "<script> alert('관리자 계정으로 로그인 되었습니다');</script>";
  $_SESSION['ss_mb_id'] = $admin_id;
  echo "<script> location.replace('./login.php'); </script>";
  exit;
}

if(!$mb['mb_id'] || !($password === $mb['mb_password'])){
  echo "<script> alert('가입된 아이디가 아니거나 비밀번호가 틀립니다'); </script>";
    echo "<script> location.replace('./login.php'); </script>";
  exit;
}

$_SESSION['ss_mb_id'] = $mb_id;

mysqli_close($conn);



if(isset($_SESSION['ss_mb_id'])){
  echo "<script> alert('로그인 되었습니다');</script>";
  echo "<script> location.replace('./post.php'); </script>";
  exit;
}


 ?>
