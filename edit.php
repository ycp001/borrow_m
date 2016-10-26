<?php
session_start();
ob_start();
include "function.php";

$id         =$_GET['id'];
$teacherid  =$_GET['teacherid'];
$cname      =$_GET['cname'];
$itme       =$_GET['item'];
$borrowtime =$_GET['borrowtime'];





    $sql = "DELETE FROM `borrow` WHERE `id` = '$id'";
    $conn = get_conn();

    $result = mysqli_query( $conn, $sql);
   
      if (!mysqli_query( $conn, $sql))
    {
        die ('Error:' . mysqli_error( $conn));
    }

    mysqli_close($conn);
    header('location:mylist.php');



?>