<?php
include("../login/connect.php");
include('./multi_login.php');
include('./auto_logout.php');

$mb_id = $_SESSION['ss_mb_id'];
$number = $_GET['number'];
$sql = "SELECT * FROM notice WHERE mb_id = '$mb_id' and mb_no = '$number'";
$result = mysqli_query($conn, $sql);
$mb = mysqli_fetch_assoc($result);
mysqli_close($conn);
$title = ' ';
$content = ' ';
if($_GET['mode']=='modify'){
  if($_SESSION['ss_mb_id'] == $mb['mb_id']){
      $mode = "modify";
      $title = $mb['mb_title'];
      $content = $mb['mb_content'];
  }else{
    echo "<script> alert('글쓴이만 수정 가능합니다'); </script>";
    echo "<script> history.back(); </script>";
  }
}
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
 </head>
     <title></title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="./homepage.css">
     <link rel="stylesheet" href="./login.css">
     <style media="screen">
     .write textarea, .write input[type=text]{
       margin : 10px 5px;
     }
     </style>
   </head>
   <body>
     <?php if($_SESSION['ss_mb_id']) {?>
       <div class="top">
         <?php echo $_SESSION['ss_mb_id'] ?>님 환영합니다
         <a href="./logout.php">로그아웃</a>
       </div>
   <?php } ?>
     <div class="header">
       <h2 class = "logo"><a href="./homepage.php">Homepage</a></h2>
       <input type="checkbox" id ="chk" value="">
       <label for="chk" class="show-menu-btn">
         <i class="fas fa-ellipsis-h"></i>
       </label>

       <ul class="menu">
         <a href="#">Home</a>
         <a href="./post.php">community</a>
         <a href="#">Services</a>
         <a href="#">Works</a>
         <a href="#">Contact</a>
         <label for="chk" class="hide-menu-btn">
           <i class="fas fa-times"></i>
         </label>
       </ul>
     </div>
     <?php if(!$_SESSION['ss_mb_id'] && !$_SESSION['ss_mb_ip']){ ?>
     <div class="content">
       <center>
         <form class="login_form" action="login_check.php" method="post">
           <input type="text" name="id" value="" placeholder = "아이디">
           <input type="password" name="pw" value="" placeholder = "비밀번호">
           <input type="submit" name="" value="로그인">
         </form>
         <div class="image">
           <img src="background.jpg" alt="">
         </div>
       <?php } else{?>
         <div class="write">
           <form class="" action="./write_update.php" method="post" enctype = "multipart/form-data">
             <table>
               <tr>
                 <th class = "center">제목</th>
                 <td><input type="text" name="title" value="<?php echo $title ?>" class = "title"> </td>
               </tr>
               <tr>
                 <th class = "center">내용</td>
                 <td><textarea name="content" rows="8" cols="80"><?php echo $content?></textarea> </td>
               </tr>
               <tr>
                 <th class = "center">파일</th>
                 <td colspan = "2" id = "file"><input type="file" name="myfile" value="파일선택 "></td>
               </tr>
             </table>
             <input type="submit" name="" value="올리기">
           </form>
         </div>
       <?php } ?>
     </center>
     </div>
   </body>
 </html>
