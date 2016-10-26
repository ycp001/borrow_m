<?php 
session_start();
include "function.php";
require 'openid.php';
header("Content-Type:text/html; charset=utf-8");
if( !isset($_SESSION["teacherid"] )) return false;

?>


<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>我所借用資訊設備</title>
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
        <link href="css/styles.css" rel="stylesheet" >
    </head>
    <body>
    <p></p>

        <div class = "container">
            <div class = "jumbotron">


                我所借用的資訊設備
                  
                  <form action="" method="post">
                      <a href = "http://www.tsces.ntpc.edu.tw" class = "navbar-btn btn-success btn pull-right">回學校首頁</a>
                      <a href = "index.php" class = "navbar-btn btn-primary btn pull-right">回資訊設備借用總表</a>
                      <a href = "input_web.php" class = "navbar-btn btn-info btn pull-right">新增借用資料</a>
                      <a href = "chk_teacher.php" class = "navbar-btn btn-info btn pull-right">管理者登入</a>
              
               
</form>
              
                       
             </div>
         </div>
     
<div class = "container">
   <div class = "row">

       <div class = "col-md-12">
         <div class="panel panel-info">
           <div class="panel-heading text-center">我預約借用的資訊設備

</div>
             <ul class="list-group my-listlink text-left">
                 <?php
                   $stmt = "SELECT * FROM  `borrow` where `teacherid` = '$_SESSION[teacherid]' and p1 is null order by `borrowtime` desc";
                   $result = mysqli_query( get_conn(), $stmt);
                   while($record = mysqli_fetch_assoc($result)){
                      echo "<li class='list-group-item no-border' >".$record['cname']."借".$record['item']."--登記日期". date('Y-m-d H:i', strtotime($record['bookingtime']))."  <a href='edit.php?id=" . $record['id'] . "&teacherid=" . $record['teacherid'] . "&cname=" . $record['cname'] . "&item=" . $record['item'] . "&borrowtime=" .  date('Y-m-d H:i', strtotime($record['borrowtime'])) . "'><button>刪除</button></a> </li>";
                      }
                ?>                
              </ul> 
             </div>
            </div>

       <div class = "col-md-12">
           <div class="panel panel-info">
               <div class="panel-heading text-center">我正在借用的資訊設備

               </div>
               <ul class="list-group my-listlink text-left">
                   <?php
                   $stmt = "SELECT * FROM  `borrow` where `teacherid` = '$_SESSION[teacherid]' and p1 is not null and p2 is null order by `borrowtime` desc";
                   $result = mysqli_query( get_conn(), $stmt);
                   while($record = mysqli_fetch_assoc($result)){
                       echo "<li class='list-group-item no-border' >".$record['cname']."借". $record['item']."--領用日期". date('Y-m-d H:i', strtotime($record['takeaway']))."</a> </li>";
                   }
                   ?>
               </ul>
           </div>
       </div>

       <div class = "col-md-12">
           <div class="panel panel-info">
               <div class="panel-heading text-center">我在已歸還的資訊設備

               </div>
               <ul class="list-group my-listlink text-left">
                   <?php
                   $stmt = "SELECT * FROM  `borrow` where `teacherid` = '$_SESSION[teacherid]' and p2 is not null order by `borrowtime` desc";
                   $result = mysqli_query( get_conn(), $stmt);
                   while($record = mysqli_fetch_assoc($result)){
                       echo "<li class='list-group-item no-border' >".$record['cname']."借".$record['item']."--領用日期". date('Y-m-d H:i', strtotime($record['takeaway']))."--歸還日期". date('Y-m-d H:i', strtotime($record['returnback']))."</a> </li>";
                   }
                   ?>
               </ul>
           </div>
       </div>


   </div>
  </div>
       

        <script src="lib/jquery/jquery-1.11.0.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
