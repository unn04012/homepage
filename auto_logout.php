<?php
if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
  echo "<script> alert('요청한 시간이 지나 자동 로그아웃되었습니다'); </script>";
  echo "<script> location.replace('./homepage.php'); <script>";
  unset($_SESSION['LAST_ACTIVITY']);
  session_destroy();
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}
 ?>
