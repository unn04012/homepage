<?php
include("../login/connect.php");
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
   </head>
   <body>
     <?php
     $number = $_GET['number'];
     $sql = "SELECT * FROM notice WHERE mb_no = $number";
     $sql_increase_look = "UPDATE notice SET mb_look_number = mb_look_number+1 WHERE mb_no = $number";
     $sql_image = "SELECT * FROM upload_file WHERE file_no = $number";

     $result_image = mysqli_query($conn, $sql_image);
     if($result_image){
       $list_image = mysqli_fetch_assoc($result_image);
     }else{
       $list_image['file_path'] = "";
     }



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
     $sql = "SELECT * FROM notice ORDER BY mb_no DESC LIMIT $s_point, $list_page";
     $result = mysqlI_query($conn, $sql);
     for($i = 0; $row = mysqli_fetch_assoc($result); $i++){
       $list[$i] = $row;
       if($row==false){
         break;
       }
     }
      ?>
     <div class="header">
       <h2 class = "logo"><a href="./homepage.php">Homepage</a></h2>
       <input type="checkbox" id ="chk" value="">
       <label for="chk" class="show-menu-btn">
         <i class="fas fa-ellipsis-h"></i>
       </label>

       <ul class="menu">
         <a href="#">Home</a>
         <a href="#">community</a>
         <a href="#">Services</a>
         <a href="#">Works</a>
         <a href="#">Contact</a>
         <label for="chk" class="hide-menu-btn">
           <i class="fas fa-times"></i>
         </label>
       </ul>
     </div>
     <?php if($_GET['number']) {
       mysqli_query($conn, $sql_increase_look);

       $result = mysqli_query($conn, $sql);
       $list_number = mysqli_fetch_assoc($result);?>
     <div class="content">
       <center>
         <table class = "noticeboard">
           <thead>
             <tr>
               <th colspan = "6"><?php echo $list_number['mb_title'] ?></th>
             </tr>
           </thead>
           <tbody>
             <tr>
               <th>글쓴이</th>
               <td><?php echo $list_number['mb_id'] ?></td>
               <th>날짜</th>
               <td><?php echo $list_number['mb_post_datetime'] ?></td>
               <th>조회</th>
               <td><?php echo $list_number['mb_look_number'] ?></td>
             </tr>
           </tbody>
           <tr>
             <td colspan = "6">
             <div class="inner_content">
               <?php echo $list_number['mb_content'] ?>
             </div>
               <img src="<?php echo $list_image['file_path'] ?>" alt="" width ="500">
             </td>
           </tr>
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
              <td><a href="" class = "a_tag">필독</a></td>
              <td>운영자</td>
              <td>2020-02-27</td>
              <td>0</td>
            </tr>
            <?php for($i =0; $i<count($list); $i++){ ?>
            <tbody>
              <tr>
                <td><?php echo $list[$i]['mb_no'] ?></td>
                <td><a href="<?php $PHP_SELF ?>?number=<?php echo $list[$i]['mb_no'] ?>"><?php echo $list[$i]['mb_title']?></a> </td>
                <td><a href="#"><?php echo $list[$i]['mb_id'] ?></a> </td>
                <td><?php echo date("Y-m-d", strtotime($list[$i]['mb_post_datetime'])) ?></td>
                <td><?php echo $list[$i]['mb_look_number'] ?></td>
              </tr>
            </tbody>
          <?php } ?>
         </table>
         <div class="paging">
           <a href="<?php $PHP_SELF?>?page=<?php echo $s_page-1 ?>">이전</a>
           <?php for($i=$s_page; $i<=$e_page; $i++){?>
           <a href="<?php $PHP_SELF ?>?page=<?php echo $i ?>"><?php echo $i;?></a>
           <?php } ?>
           <a href="<?php $PHP_SELF?>?page=<?php echo $s_page+1 ?>">다음</a>
         </div>
       </center>
     </div>
   </body>
 </html>
