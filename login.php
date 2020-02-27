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
    <link rel="stylesheet" href="./login.css">
  </head>
  <style media="screen">

  </style>
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
      </center>
    </div>
  </body>
</html>
