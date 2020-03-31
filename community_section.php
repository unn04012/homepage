<?php
require_once("./connection.php");

function show_post(){
  $conn = db_connect();
  $query = "SELECT * FROM posts";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $stmt->store_result();
  $stmt->bind_result($no, $title, $id, $date, $modify_date, $views);
 ?>
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
          <td><a href="#" class = "a_tag">제목</a> </td>
          <td>운영자</td>
          <td>날짜</td>
          <td>조회수</td>
        </tr>
        <?php while($stmt->fetch()){?>
        <tbody>
          <tr>
            <td><?php echo $no ?></td>
            <td><a href="#"><?php echo $title?></a> </td>
            <td><a href="#"><?php echo $id ?></a> </td>
            <td><?php echo date("Y-m-d", strtotime($date)) ?></td>
            <td><?php echo $views ?></td>
          </tr>
        </tbody>
        <?php } ?>
      </table>
    </center>
  </div>
  <hr>
<?php }?>
