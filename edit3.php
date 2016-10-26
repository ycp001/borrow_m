<?php
session_start();
ob_start();
include "function.php";
$id=$_GET['id'];
$teacherid=$_GET['teacherid'];
$cname=$_GET['cname'];
$bookingtime=$_GET['bookingtime'];
$item=$_GET['item'];
$borrowtime=$_GET['borrowtime'];
$date=$_GET['date'];
$p1=$_GET['p1'];
$takeaway=$_GET['takeaway'];
if( !isset($_SESSION["teacherid"] )) return false;

mysqli_select_db("borrow");
$sql = "DELETE FROM `borrow` WHERE `id` = '$id'";
$conn = get_conn();

$result = mysqli_query( $conn, $sql);
$sql= "INSERT INTO `borrow` (teacherid, cname, bookingtime, item, borrowtime, p1, takeaway, p2, returnback) VALUES ('$teacherid', '$cname', '$bookingtime', '$item', '$borrowtime', '$p1', '$takeaway', '$_SESSION[cname]', now())";

if (!mysqli_query( $conn, $sql))
{
    die ('Error:' . mysqli_error( $conn ));
}

mysqli_close($conn);
header('location:alllist.php');



?>