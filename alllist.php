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
    <title>全校所借用資訊設備</title>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet" >
</head>
<body>
<p></p>

<div class = "container">
    <div class = "jumbotron">


        全校所借用資訊設備

        <form action="" method="post">
            <a href = "http://www.tsces.ntpc.edu.tw" class = "navbar-btn btn-success btn pull-right">回學校首頁</a>
            <a href = "index.php" class = "navbar-btn btn-primary btn pull-right">回資訊設備借用總表</a>
            <a href = "input_web.php" class = "navbar-btn btn-info btn pull-right">新增借用資料</a>


        </form>


    </div>
</div>

<div class = "container">
    <div class = "row">

        <div class = "col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading text-center">全校已登記借用資訊設備

                </div>
                <ul class="list-group my-listlink text-left">
                    <?php
                    $stmt = "SELECT * FROM  `borrow` WHERE p1 Is NULL order by `borrowtime`desc" ;
                    $result = mysqli_query( get_conn(), $stmt);
                    while($record = mysqli_fetch_assoc($result)){
                        echo "<li class='list-group-item no-border' >".$record['cname']."借". $record['item']."--借用日期".$record['borrowtime']."--登記日期". date('Y-m-d H:i', strtotime($record['bookingtime'])) ."備註".$record['mamo']."<a href='edit4.php?id=" . $record['id'] . "&teacherid=" . $record['teacherid'] . "&cname=" . $record['cname'] . "&bookingtime=" . $record['bookingtime'] ."&item=" . $record['item'] . "&borrowtime=" . $record['borrowtime'] . "'><button>備註</button>  <a href='edit2.php?id=" . $record['id'] . "&teacherid=" . $record['teacherid'] . "&cname=" . $record['cname'] . "&bookingtime=" . $record['bookingtime'] ."&item=" . $record['item'] ."&borrowtime=" . $record['borrowtime'] . "'><button>領用</button></a> </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class = "col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading text-center">全校已領取借用的資訊設備

                </div>
                <ul class="list-group my-listlink text-left">
                    <?php
                    $stmt = "SELECT * FROM  `borrow` WHERE p1 IS NOT NULL AND p2 IS NULL order by `borrowtime` desc" ;
                    $result = mysqli_query( get_conn(), $stmt);
                    while($record = mysqli_fetch_assoc($result)){
                        echo "<li class='list-group-item no-border' >".$record['cname']."借".$record['item']."--借用日期". date('Y-m-d H:i', strtotime($record['borrowtime']))."確認領用者".$record['p1']."--領用日期".date('Y-m-d H:i', strtotime($record['takeaway']))."備註".$record['mamo']."<a href='edit4.php?id=" . $record['id'] . "&teacherid=" . $record['teacherid'] . "&cname=" . $record['cname'] . "&bookingtime=".date('Y-m-d H:i', strtotime($record['bookingtime'])) ."&item=" . $record['item'] . "&borrowtime=" . $record['borrowtime']  . "'><button>備註</button>  <a href='edit3.php?id=" . $record['id'] . "&teacherid=" . $record['teacherid'] . "&cname=" . $record['cname'] . "&bookingtime=" . $record['bookingtime'] ."&item=" . $record['item'] . "&borrowtime=" . $record['borrowtime']  . "&p1=" . $record['p1'] ."&takeaway=" . $record['takeaway'] ."'><button>歸還</button></a> </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>


        <div class = "col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading text-center">全校已歸還借用的資訊設備

                </div>
                <ul class="list-group my-listlink text-left">
                    <?php
                    $stmt = "SELECT * FROM  `borrow` WHERE p1 IS NOT NULL AND p2 IS NOT NULL order by `borrowtime` desc" ;
                    $result = mysqli_query( get_conn(), $stmt);
                    while($record = mysqli_fetch_assoc($result)){
                        echo "<li class='list-group-item no-border' >".$record['cname']."借".$record['item']."--借用". date('Y-m-d H:i', strtotime($record['borrowtime']))."日--領用". date('Y-m-d H:i', strtotime($record['takeaway']))."確認者".$record['p1']."--歸還".date('Y-m-d H:i', strtotime($record['returnback']))."確認者".$record['p2']." </a> </li>";
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
