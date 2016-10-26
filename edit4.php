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

if( !isset($_SESSION["teacherid"] )) return false;
?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>借用的資訊設備修改</title>
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
        <link href="css/styles.css" rel="stylesheet" >
    </head>
    <body>
    <p></p>

    <div class = "container">
        <div class = "jumbotron">

            借用的資訊設備修改
            <a href = "mylist.php" class = "navbar-btn btn-info btn pull-right">回個人行政日誌</a>

        </div>
    </div>
    <div class = "container">
        <meta charset="UTF-8">
        <form action="" method="post">
            <center>
                <table >

                    <tr> <td>借用者:</td><td><?=echobr($cname);?> </td></tr>
                    <tr><td><br></td></tr>
                    <tr> <td> 設備：</td><td><input value="<?=$item;?>" name="depart" type="text" required="required"></td></tr>
                    <tr><td><br></td></tr>
                    <tr> <td>借用日期：</td><td>  <input value="<?=$borrowtime;?>" name="month" type="text" required="required"> </td></tr>

                    <tr><td><br></td></tr>
                    <tr>  <td> 備註：</td><td><input value="" name="mamo" type="text" required="required"> </td></tr>
                    <tr><td><br></td></tr>
                </table>
                <input type="hidden" name="act" value="update">
                <input type="submit" >
            </center>




            <script src="lib/jquery/jquery-1.11.0.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    </body>
    </form>
    </html>
<?php
if( !isset($_POST["act"] )) return false;
if( $_POST["act"] === "update"){

    $sql = "DELETE FROM `borrow` WHERE `id` = '$id'";
    $conn = get_conn();

    $result = mysqli_query( $conn, $sql);
    $sql= "INSERT INTO `borrow` (teacherid, cname, bookingtime,item, borrowtime,mamo, p1, takeaway) VALUES ('$teacherid', '$cname', '$bookingtime','$item','$borrowtime', '$_POST[mamo]', '$_SESSION[cname]',now())";

    if (!mysqli_query($conn, $sql))
    {
        die ('Error:' . mysqli_error($conn));
    }

    mysqli_close($conn);
    header('location:alllist.php');

}

?>