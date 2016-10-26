<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="myFile" required="required">

    <input type="submit" value="上傳檔案">
</form>


<?php
include_once('function.php');

define("UPLOAD_DIR", "C:/wagon/uwamp/www/default/borrow_m/files/");

    if( $_SERVER['REQUEST_METHOD'] == 'POST'){
        dump( $_FILES );

        if( !empty($_FILES['myFile']) ) {
            $myfile = $_FILES['myFile'];


            if( $myfile['error'] !== UPLOAD_ERR_OK ){
                print "<p>上傳時發生錯誤！</p>";
                exit();
            }


            $name = 'students_' . date('Ymd') . '.xml';

            /*$i=0;
            $parts = pathinfo($name);
            if( file_exists(UPLOAD_DIR . $name) ){
                $i++;
                $name = sprintf("%s_%s.%s",
                            $parts['filename'],
                            date('YmdHis') . time(),
                            $parts['extension']
                );
            }*/


            $upload_status = move_uploaded_file(  $_FILES['myFile']['tmp_name'],  UPLOAD_DIR . $name);
            
            
            
            
            if( $upload_status ){
                $students = parse_students_xml( UPLOAD_DIR . $name );

                dump( $students );
            }

        }



    }





