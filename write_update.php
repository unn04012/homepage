<?php
include("../login/connect.php");

$mb_id = $_SESSION['ss_mb_id'];
if(!$mb_id){
  echo "<script> alert('로그인 후 이용 가능합니다'); </script>";
  echo "<script> location.replace('./login.php'); </script>";
}

$mb_post_datetime = date('Y-m-d H:i:s', time());
$mb_title   = trim($_POST['title']);
$mb_content = trim($_POST['content']);

if(!$mb_title || !$mb_content){
  echo "<script> alert('제목과 내용을 입력해주세요'); </script>";
  echo "<script> location.replace('./write.php'); </script>";
  exit;
}
// if($mb_content)



$uploads_dir = "../fileupload/fileupload/";
$allowed_ext = array('jpg','jpeg','png','');
$field_name = 'myfile';

if(!is_dir($uploads_dir)){
  if(!mkdir($uploads_dir, 0777)){
    die("업로드 디렉토리 생성에 실패 했습니다");
  }
}


if(!isset($_FILES[$field_name])){
  die("업로드된 파일이 없습니다");
}
$error = $_FILES[$field_name]['error'];
$name = $_FILES[$field_name]['name'];

$upload_file = $uploads_dir.'/'.$name; // 저장될 디렉토리 및 파일명
$fileinfo = pathinfo($upload_file);   //첨부파일의 정보를 가져옴
$ext = strtolower($fileinfo['extension']);

$i = 1;
while(is_file($upload_file)){
    $name= $fileinfo['filename']."-{$i}.".$fileinfo['extension'];
    $upload_file = $uploads_dir.'/'.$name;
    $i++;
}

if(!in_array($ext, $allowed_ext)){
  echo  "허용되지 않는 확장자입니다";
  exit;
}

if(!move_uploaded_file($_FILES[$field_name]['tmp_name'], $upload_file)){
    echo "파일이 업로드 되지 않았습니다.";
    exit;
}
$sql = "INSERT INTO notice
                SET mb_id = '$mb_id',
                    mb_post_datetime = '$mb_post_datetime',
                    mb_title = '$mb_title',
                    mb_content = '$mb_content',
                    mb_look_number = '0'";
$result = mysqli_query($conn, $sql);

//-- mb_no가져오는 코드

  $sql_no = "SELECT mb_no FROM notice WHERE mb_post_datetime = '$mb_post_datetime'";
  $result_no = mysqli_query($conn, $sql_no);
  $list = mysqli_fetch_assoc($result_no);
  $number = $list['mb_no'];

//------------

$sql = "INSERT INTO upload_file
                SET file_no = '$number',
                    file_name = '$name',
                    file_path = '$upload_file',
                    file_datetime = '$mb_post_datetime'";
$result_file = mysqli_query($conn, $sql);



if(!$result_file){
  echo "<script> alert('msyql 업데이트 실패'); </script>";
  echo "<script> location.replace('./post.php');</script>";
  exit;
}
if($result){
  echo "<script> alert('성공적으로 업로드 되었습니다'); </script>";
  echo "<script> location.replace('./post.php');</script>";
  exit;
}else{
  echo "<script> alert('업로드실패'); </script>";
  echo "<script> location.replace('./write.php');</script>";
  exit;
}



 ?>
