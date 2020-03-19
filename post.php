<?php
include("../login/connect.php");
include('./multi_login.php');
include('./auto_logout.php');
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
     <title></title>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="./homepage.css">
     <link rel="stylesheet" href="./post.css">
     <style media="screen">
       .noticeboard td{
         font-size : 14px;
       }
       .modify{
         text-align : right;
       }
       .modify a{
         padding : 5px 10px;
         border-radius : 10px;
         text-decoration : none;
         color : white;
         background : #34495e;
         font-weight : bold;
       }
       .modify a:hover{
         text-decoration : underline;
         color : white;
       }
       .write a{
           padding : 5px 10px;
           border : none;
           border-radius : 10px;
           text-decoration : none;
           color : white;
           background : #34495e;
           font-weight : bold;
       }
       .search select, option, input{
         padding : 5px 10px;
         border-radius : 10px;
         text-decoration : none;
         color : white;
         background : #34495e;
         font-weight : bold;
         margin-bottom : 20px;
       }
       .paging a{
         font-weight : bold;
       }
       .search input[type=submit]{

       }
     </style>
   </head>
   <body>
     <?php
     $data = "SELECT mb_no FROM notice";
     $result = mysqli_query($conn, $data);
     $num = mysqli_num_rows($result); // 총 데이터 수
     $list_page = 10;
     $block = 5;
     $page = ($_GET['page'])? $_GET['page'] : 1;

     $pageNum = ceil($num/$list_page);
     $blockNum = ceil($pageNum/$block);
     $nowBlock = ceil($page/$block);

     $s_page = ($nowBlock * $block) - ($block - 1);
     if($s_page<=1) $s_page=1;
     $e_page = $nowBlock * $block;
     if($pageNum <= $e_page) $e_page = $pageNum;


     $list = array();

     $s_point = ($page-1) * $list_page;
     if($_GET['category'] && $_GET['search']){
       $search = $_GET['search'];
       $category = $_GET['category'];
       $sql = "SELECT * FROM notice where $category LIKE '%$search%' ORDER BY mb_no DESC LIMIT $s_point, $list_page ";  //  검색기능
     }else{
       $sql = "SELECT * FROM notice ORDER BY mb_no DESC LIMIT $s_point, $list_page";    // 게시글 보여주는 sql
     }
     $result = mysqli_query($conn, $sql);
     for($i = 0; $row = mysqli_fetch_assoc($result); $i++){
       $list[$i] = $row;
       if($row==false){
         break;
       }
     }

     //관리자 게시판
       $sql = "SELECT * FROM admin_notice";
       $result = mysqli_query($conn, $sql);
       $admin = mysqli_fetch_assoc($result);
      ?>
      <?php if($_SESSION['ss_mb_id']) {?>
        <div class="top">
          <?php echo $_SESSION['ss_mb_id'] ?>님 환영합니다
          <a href="./logout.php">로그아웃</a>
        </div>
    <?php }else{?>
      <div class="top">
        <a href="./login.php">로그인</a>
        <a href="../login/register.php">회원가입</a>
      </div>
    <?php } ?>
     <div class="header">
       <h2 class = "logo"><a href="./homepage.php">Homepage</a></h2>
       <input type="checkbox" id ="chk" value="">
       <label for="chk" class="show-menu-btn">
         <i class="fas fa-ellipsis-h"></i>
       </label>

       <ul class="menu">
         <a href="./homepage.php">Home</a>
         <a href="./post.php">community</a>
         <a href="./user_board.php">Services</a>
         <a href="./visitor_statistic.php">Works</a>
         <a href="#">Contact</a>
         <label for="chk" class="hide-menu-btn">
           <i class="fas fa-times"></i>
         </label>
       </ul>
     </div>
     <?php
     if($_GET['number']) {
        $number = $_GET['number'];
       if(empty($_COOKIE['board_'.$number])){
         if($number== $admin['mb_no']){
            $sql_increase_look = "UPDATE admin_notice SET mb_look_number = mb_look_number+1";
         }else{
            $sql_increase_look = "UPDATE notice SET mb_look_number = mb_look_number+1 WHERE mb_no = $number";
         }
        $result = mysqli_query($conn, $sql_increase_look);
        if(empty($result)){
          echo "<script> alert('조회수 오류가 발생하였습니다'); </script>";
          echo "<script> history.back(); </script>";
        }else{
          setcookie('board_'.$number,TRUE,time()+(60*60*24),'/');
        }
       }

       $sql_image = "SELECT * FROM upload_file WHERE file_no = $number";
       $result_image = mysqli_query($conn, $sql_image);
       if($result_image){
         $list_image = mysqli_fetch_assoc($result_image);
       }else{
         $list_image['file_path'] = "";
       }


         // 사용자 게시판 가져오기
         $sql = "SELECT * FROM notice WHERE mb_no = $number";
         $result = mysqli_query($conn, $sql);
         $list_number = mysqli_fetch_assoc($result);
       ?>
     <div class="content">
       <center>
         <table class = "noticeboard">
            <!-- 관리자 일 경우 -->
               <?php if($_GET['number']==-1){ ?>
                 <thead>
                   <tr>
                     <th colspan = "6"><?php echo $admin['mb_title'] ?></th>
                   </tr>
                 </thead>
                 <tbody>
                 <tr>
                   <th class = "th">글쓴이</th>
                   <td class = "td">운영자</td>
                   <th class = "th">날짜</th>
                   <td class = "td"><?php echo $admin['mb_datetime'] ?></td>
                   <th class = "th">조회</th>
                   <td class = "td"><?php echo $admin['mb_look_number'] ?></td>
                 </tr>
               </tbody>
               <tr>
                 <td colspan = "6">
                 <div class="inner_content">
                   <?php echo $admin['mb_content'] ?>
                 </div>
                   <img src="<?php echo $list_image['file_path'] ?>" alt="" width ="500">
                   <div class="modify"><a href="./write.php?mode=modify&amp;number=<?php echo $admin['mb_no'] ?>">수정</a></div>
                 </td>
               </tr>
             <?php }else{ // 사용자 일경우?>
             <thead>
               <tr>
                 <th colspan = "6"><?php echo $list_number['mb_title'] ?></th>
               </tr>
             </thead>
             <tbody>
             <tr>
               <th class = "th">글쓴이</th>
               <td class = "td"><?php echo $list_number['mb_id'] ?></td>
               <th class = "th">날짜</th>
               <td class = "td"><?php echo $list_number['mb_post_datetime'] ?></td>
               <th class = "th">조회</th>
               <td class = "td"><?php echo $list_number['mb_look_number'] ?></td>
             </tr>
           </tbody>
           <tr>
             <td colspan = "6">
             <div class="inner_content">
               <?php echo $list_number['mb_content'] ?>
             </div>
               <img src="<?php echo $list_image['file_path'] ?>" alt="" width ="500">
               <div class="modify"><a href="./write.php?mode=modify&amp;number=<?php echo $list_number['mb_no'] ?>">수정</a></div>
             </td>
           </tr>
         <?php } ?>
         </table>
       </center>
     </div>
   <?php }?>
     <div class="content">
       <center>
         <table class = "noticeboard">
           <thead>
             <th>번호</th>
             <th id = "title">제목</th>
             <th>글쓴이</th>
             <th>날짜</th>
             <th>조회</th>
           </thead>
            <tr class = "important">
              <td><span>공지</span></td>
              <td><a href="<?php $PHP_SELF ?>?number=-1"class = "a_tag"><?php echo $admin['mb_title'] ?></a></td>
              <td>운영자</td>
              <td><?php echo date("Y-m-d", strtotime($admin['mb_datetime'])) ?></td>
              <td><?php echo $admin['mb_look_number'] ?></td>
            </tr>
            <?php for($i =0; $i<count($list); $i++){ ?>
            <tbody>
              <tr>
                <td><?php echo $list[$i]['mb_no'] ?></td>
                <td><a href="<?php $PHP_SELF ?>?page=<?php echo $page ?>&amp;number=<?php echo $list[$i]['mb_no'] ?>"><?php echo $list[$i]['mb_title']?></a> </td>
                <td><a href="#"><?php echo $list[$i]['mb_id'] ?></a> </td>
                <td><?php echo date("Y-m-d", strtotime($list[$i]['mb_post_datetime'])) ?></td>
                <td><?php echo $list[$i]['mb_look_number'] ?></td>
              </tr>
            </tbody>
          <?php } ?>
         </table>
         <div class="write">
            <a href="write.php">글쓰기</a>
            <?php if($_SESSION['ss_mb_id']){?>
            <a href="./logout.php">로그아웃</a>
          <?php }else{ ?>
            <a href="./login.php">로그인</a>
          <?php } ?>
         </div>
         <div class="search">
           <form class="" method="get">
             <select class="search" name="category">
               <option value="mb_title">제목</option>
               <option value="mb_id">글쓴이</option>
               <option value="mb_post_datetime">날짜</option>
             </select>
             <input type="text" name="search" value="">
             <input type="submit" name="" value="검색">
           </form>
         </div>
         <div class="paging">
           <a href="<?php $PHP_SELF?>?page=<?php echo $s_page-1 ?>&amp;number=<?php echo $list_number['mb_no'] ?>">이전</a>
           <?php for($i=$s_page; $i<=$e_page; $i++){?>
           <a href="<?php $PHP_SELF ?>?page=<?php echo $i ?>&amp;number=<?php echo $list_number['mb_no'] ?>"id ="current_page"><?php echo $i;?></a>
           <?php } ?>
           <a href="<?php $PHP_SELF?>?page=<?php echo $e_page+1 ?>&amp;number=<?php echo $list_number['mb_no'] ?>">다음</a>
         </div>
       </center>
     </div>
   </body>
 </html>
