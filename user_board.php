<?php
include("../login/connect.php");

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
    <link rel="stylesheet" href="./post.css">
    <style media="screen">
    .noticeboard td{
      font-size : 14px;
    }
    .write input{
      padding : 2px 10px;
      border : 2px solid #34495e;
      border-radius : 10px;
      color : white;
      background : #34495e;
      cursor : pointer;
    }
    </style>
  </head>
  <body>
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
    <div class="content">
      <center>
        <?php if($_SESSION['ss_mb_id']== "admin"){ ?>
        <table class = "noticeboard">
          <!-- //mb_id, mb_password, mb_name, mb_email,mb_gender, mb_datetime  -->
          <thead>
            <th>선택</th>
            <th>아이디</th>
            <th>비밀번호</th>
            <th>이름</th>
            <th>이메일</th>
            <th>성</th>
            <th>가입날짜</th>
            <th>차단여부</th>
          </thead>
          <?php
          $sql = "SELECT * FROM member";
          $result = mysqli_query($conn, $sql);
          $mb = mysqli_fetch_assoc($result);
          if(!$result){
            echo "실패";
          }

          $list = array();
          for($i = 0; $mb = mysqli_fetch_assoc($result) ; $i++){
            $list[$i]= $mb;
          }

          $sql = "SELECT * FROM currentUser";
          $result = mysqli_query($conn, $sql);

          $list_access = array();
          for($i=0; $currentUser = mysqli_fetch_assoc($result); $i++){
            $list_access[$i] = $currentUser;
          }
          // for($i=0; $i<count($_SESSION['ss_mb_id']; $i++)){
          //   echo $_SESSION['ss_mb_id'][];
          // }
           ?>
          <tbody>
            <?php for($i=0; $i<count($list); $i++){ ?>
              <tr>
                <form class="" action="block_check.php" method="post">
                  <td><input type="checkbox" name="check[]" value="<?php echo $list[$i]['mb_id'] ?>"></td>
                  <td><?php echo $list[$i]['mb_id'] ?> </td>
                  <td><?php echo $list[$i]['mb_password'] ?></td>
                  <td><?php echo $list[$i]['mb_name'] ?></td>
                  <td><?php echo $list[$i]['mb_email'] ?></td>
                  <td><?php echo $list[$i]['mb_gender'] ?></td>
                  <td><?php echo $list[$i]['mb_datetime'] ?></td>
                  <td class = "block"><?php if($list[$i]['mb_block']==1){echo "차단중";}else{echo "차단아님";} ?></td>
                 </tr>
          <?php } ?>
          </tbody>
        </table>
              <div class="write">
                <input type="submit" name="" value="차단여부변경">
              </div>
              <h1>접속중인 사용자</h1>
              <table class = "noticeboard">
                <thead>
                  <th>사용자</th>
                  <th>OS</th>
                  <th>브라우저</th>
                  <th>ip</th>
                </thead>
                <tbody>
                    <?php for($i=0; $i<count($list_access); $i++){ ?>
                  <tr>
                    <td><?php echo $list_access[$i]['userID'] ?></td>
                    <td><?php echo $list_access[$i]['OS'] ?></td>
                    <td><?php echo $list_access[$i]['browser'] ?></td>
                    <td><?php echo $list_access[$i]['ipaddr'] ?></td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
        <?php }else{
          echo "<script> alert('관리자만 접근가능합니다');</script>";
          echo "<script> location.replace('./post.php');</script>";
        } ?>
           </form>
      </center>
    </div>
  </body>
  <script type="text/javascript">
    var block = document.getElementsByClassName('block');
    for(var i =0; i<block.length; i++){
      if(block[i].innerHTML == "차단중"){
        block[i].style.color = "red";
      }else{
        block[i].style.color = "green";
      }
    }
  </script>
</html>
