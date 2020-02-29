<?php
include("../login/connect.php");

function getBrowserInfo()
{
  $userAgent = $_SERVER["HTTP_USER_AGENT"];
  if(preg_match('/MSIE/i',$userAgent) && !preg_match('/Opera/i',$u_agent)){
    $browser = 'Internet Explorer';
  }
  else if(preg_match('/Firefox/i',$userAgent)){
    $browser = 'Mozilla Firefox';
  }
  else if (preg_match('/Chrome/i',$userAgent)){
    $browser = 'Google Chrome';
  }
  else if(preg_match('/Safari/i',$userAgent)){
    $browser = 'Apple Safari';
  }
  elseif(preg_match('/Opera/i',$userAgent)){
    $browser = 'Opera';
  }
  elseif(preg_match('/Netscape/i',$userAgent)){
    $browser = 'Netscape';
  }
  else{
    $browser = "Other";
  }
  return $browser;
}

function getOsInfo()
{
  $userAgent = $_SERVER["HTTP_USER_AGENT"];
  if (preg_match('/linux/i', $userAgent)){
    $os = 'linux';}
  elseif(preg_match('/macintosh|mac os x/i', $userAgent)){
    $os = 'mac';}
  elseif (preg_match('/windows|win32/i', $userAgent)){
    $os = 'windows';}
  else {
    $os = 'Other';

  }
  return $os;
}

      $ipaddr = $_SERVER['REMOTE_ADDR'];
      $date = date("Y-m-d", time());
      $time = date("H:i:s", time());
      $browser = getBrowserInfo();
      $os = getOsInfo();

$mb_id       = trim($_POST['id']);
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
    $sql = "SELECT *  FROM currentUser WHERE userID = '$mb_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if(!$user){
      $_SESSION['ss_mb_id'] = $mb_id;
      $sql = "INSERT INTO currentUser
                      SET ipaddr = '$ipaddr',
                          date = '$date',
                          time = '$time',
                          OS = '$os',
                          browser = '$browser',
                          userID = '$mb_id'";
      $result = mysqli_query($conn, $sql);
    }else{
        echo "<script> alert('현재 접속중인 아이디입니다'); </script>";
        echo "<script> location.replace('./post.php'); </script>";
    }
    echo "<script> alert('로그인 성공'); </script>";
  }else{
    echo "<script> alert('차단 된 아이디입니다'); </script>";
  }
  echo "<script> location.replace('./post.php'); </script>";
  exit;
}


mysqli_close($conn);





 ?>
