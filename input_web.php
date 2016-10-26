<?php
session_start();
ob_start();
include "function.php";

date_default_timezone_set('Asia/Taipei');

if( !isset($_SESSION["teacherid"] )) return false;

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    if (!check_field_complete()) {
        ?>
        <script language='javascript'>window.alert('借用項目未選擇，請重新點選!');</script>
    <?php
    } elseif (isset($_POST["act"]) and $_POST["act"] === "insert") {

        //mysql_select_db("borrow");
        $sql = "INSERT INTO `borrow` (teacherid, cname, bookingtime, item, borrowtime) VALUES ('".$_SESSION['teacherid']."','".$_SESSION['cname']."',now(),'".$_POST['item']."',now()
)";
      // die($sql);
        $conn = get_conn();

        if (!mysqli_query($conn, $sql)) {
            die ('Error:' . mysqli_error( $conn ));
        }
        echo "1 record added";

        mysqli_close($conn);
        $_SESSION['bookingtime'] = $_POST['bookingtime'];
        $_SESSION['item'] = $_POST['item'];
        $_SESSION['borrowtime'] = $_POST['borrowtime'];
  



        header('location:mylist.php');

    }
}
?>

<!doctype html>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>借用資訊設備表單</title>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
    <link href="css/styles.css" rel="stylesheet" >



      <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <link rel="stylesheet" href="/resources/demos/style.css">
      <script>
          $(function() {
              $( "#datepicker" ).datepicker();
          });
      </script>

  </head>
  <body>
  <p></p>

        <div class = "container">
            <div class = "jumbotron">

                借用資訊設備<br>
               <a href = "mylist.php" class = "navbar-btn btn-info btn pull-right">回借用資訊設備</a>

      
             </div>
         </div>
<div class = "container">   
<meta charset="UTF-8">
<form action="" method="post">
<center>
<h3>使用完畢盡速歸還，相關資料請務必下載儲存，以免他人使用時誤刪。</h3>
    <div class = "col-md-6" align="right">
        <h3>借用者:</h3>
    </div>
    <div class = "col-md-6" align="left">
          <h3><?=echobr($_SESSION['cname']);?></h3>
    </div>
    <div class = "col-md-6"  align="right">
       <h3>資訊設備</h3>
   </div>

    <div class = "col-md-6"  align="left">
      <h3><select name="item" >
              <option value="" selected>選項</option>
              <?php
                  $conn = get_conn();
                  $sql = "select * from createitem";
                  $result = mysqli_query( $conn, $sql);
                  while($item = mysqli_fetch_assoc($result)) {
                      echo '<option value="' . $item['item'] . '">' . $item['item'] . '</option>';
                  }
              ?>

<!--              <option value="資訊車">資訊車</option>-->
<!--              <option value="攝影機">攝影機</option>-->
<!--              <option value="照相機">照相機</option>-->
<!--              <option value="攝影腳架">攝影腳架</option>-->
<!--              <option value="擴音機">擴音機</option>-->
<!--              <option value="光碟機">光碟機</option>-->
<!--              <option value="筆電">筆電</option>-->
<!--              <option value="簡報筆">簡報筆</option>-->
<!--              <option value="實物投影機">實物投影機</option>-->
<!--              <option value="無線分享器">無線分享器</option>-->
<!--              <option value="海報機">海報機</option>-->
          </select></h3>
     </div>








       

 <h3>   <input type="hidden" name="act" value="insert">

    <input type="submit" ></h3></center>
    

        
</div>

    <script src="lib/jquery/jquery-1.11.0.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="lib/chk_data.js"></script>
  </body>
</form>
</html>