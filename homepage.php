<?php
class Page{
  // page 속성
  public $content;
  public $title = "Homepage";
  public $image;  
 // page 클래스의 메서드(함수)
 public function __set($name, $value){
   $this->$name = $value;
 }

 public function Display(){
   echo "<html>\n<head>\n";
   $this->DisplayTitle();
   $this->DisplayKeywords();
   $this->DisplayStyles();
   $this->DisplayHeader();
   echo "</head>\n<body>\n";
   $this->DisplayContent();
   $this->DisplayFooter();
   echo "</body>\n</html>\n";
 }

 public function DisplayTitle(){
   echo "<title> $this->title </title>";
 }

 public function DisplayKeywords(){
   ?>
   <meta charset = "utf8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <?php
 }

 public function DisplayStyles(){
   ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css" />
   <link rel="stylesheet" href="./homepage.css">
   <?php
 }

 public function DisplayHeader(){
   ?>
   <!-- page header -->
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
 }

 public function DisplayContent(){
   ?>
   <div class="content">
     <center>
       <?php echo $this->image; ?>
     </center>
     <p>
       <?php echo $this->content; ?>
     </p>
   </div>
   <hr>
   <?php
 }
 public function DisplayFooter(){
   ?>
   <!-- page footer -->
   <footer>
     <p>
       &copy; homepage ltd.<br>
       Please see our
       <a href="#">legal information page</a>
     </p>
   </footer>
   <?php
 }
}
 ?>
