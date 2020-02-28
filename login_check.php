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

if(!($mb['mb_id']==$mb_id) || !($mb['mb_password']==$mb_password)){
  echo "<script> alert('가입된 아이디가 아니거나 비밀번호가 틀립니다'); </script>";
  echo "<script> location.replace('./login.php'); </script>";
  exit;
}

if($result && ($mb['mb_password'] == $mb_password)){
  if($mb_id ==="admin"){
    $_SESSION['ss_mb_id'] = $mb_id;
    echo "<script> alert('관리자 로그인 성공'); </script>";
  }else if($mb['mb_block'] == 0){
    $_SESSION['ss_mb_id'] = $mb_id;
    echo "<script> alert('로그인 성공'); </script>";
  }else{
    echo "<script> alert('차단 된 아이디입니다'); </script>";
  }
  echo "<script> location.replace('./post.php'); </script>";
  exit;
}


mysqli_close($conn);





 ?>
