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

// 테이블 구조 : uid, ipaddr, date, time, OS, browser, userID, hit
// SESSION 이 살아있는 동안에는 카운트 안되도록 처리
$access_ip=$_SERVER['REMOTE_ADDR'];
$getOS = getOS(); // 접속 OS 정보
$getBrowser = getBrowser(); // 브라우저 접속 정보
$date = date("Y-m-d", time()); // 오늘날짜
$time = date("H:i:s", time()); // 시간
$mb_id = $mb_id ? $mb_id : 'none';
$sql ="SELECT count(*) FROM accesslog WHERE date ='$date' AND userID = '$mb_id  '";
$result=mysqli_query($conn, $sql);
$row = mysqli_fetch_row($result);

  if($row[0]==0){ // 오늘 접속날짜 기록이 없으면
    $sql = "INSERT INTO accesslog (ipaddr,date,time,OS,browser,userID,hit,log)
              VALUES ('$access_ip','$date','$time','$getOS','$getBrowser','$mb_id','1','1')";
    $result=mysqli_query($conn, $sql);

  } else { // 접속 기록이 있으면 해당 IP주소의 카운트만 증가시켜라.
    $sql = "UPDATE accessLog SET hit=hit+1 Where ipaddr='$access_ip' AND userID = '$mb_id'";
    $result=mysqli_query($conn, $sql);
  }




// 접속 Device
function user_agent(){
$iPod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
if($iPad||$iPhone||$iPod){
  return 'ios';
} else if($android){
  return 'android';
} else {
  return 'etc';
}
}

function getOS() {
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
$os_platform    =   "Unknown OS Platform";
$os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
          );
foreach ($os_array as $regex => $value) {
  if (preg_match($regex, $user_agent)) {
    $os_platform    =   $value;
  }
}
return $os_platform;
}

function getBrowser() {
$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
$browser        =   "Unknown Browser";
$browser_array  =   array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/edge/i'       =>  'Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Mobile Browser'
          );
foreach ($browser_array as $regex => $value) {
  if (preg_match($regex, $user_agent)) {
    $browser    =   $value;
  }
}
return $browser;
}

//end class
if($result && ($mb['mb_password'] == $mb_password)){
  if($mb_id ==="admin"){
    $_SESSION['ss_mb_id'] = $mb_id;
    echo "<script> alert('관리자 로그인 성공'); </script>";
    echo "<script> location.replace('./post.php'); </script>";
    exit;
  }else if($mb['mb_block'] == 0){
    $sql = "SELECT *  FROM currentUser WHERE userID = '$mb_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if(!$user){
      $_SESSION['ss_mb_id'] = $mb_id;
      $_SESSION['ss_mb_ip'] = $ipaddr;
      $sql = "INSERT INTO currentUser
                      SET ipaddr = '$ipaddr',
                          date = '$date',
                          time = '$time',
                          OS = '$os',
                          browser = '$browser',
                          userID = '$mb_id'";
      $result = mysqli_query($conn, $sql);

      // echo "<script> location.replace('./post.php'); </script>";
    }else{
      $_SESSION['ss_mb_id'] = $mb_id;
      $_SESSION['ss_mb_ip'] = $ipaddr;
      $sql = "UPDATE currentuser SET ipaddr = '$ipaddr' WHERE userID = '$mb_id'";
      $result = mysqli_query($conn, $sql);
    }
    // else{
    //     echo "<script> alert('현재 접속중인 아이디입니다'); </script>";
    //     // echo "<script> location.replace('./post.php'); </script>";
    //     exit;
    // }

  }else{
    echo "<script> alert('차단 된 아이디입니다'); </script>";
    echo "<script> location.replace('./post.php'); </script>";
    exit;
  }
  echo "<script> alert('로그인 성공'); </script>";
  echo "<script> location.replace('./post.php'); </script>";
  exit;
}



mysqli_close($conn);





 ?>
