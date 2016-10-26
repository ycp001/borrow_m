<?php
require_once "CONFIG.php";

date_default_timezone_set('Asia/Taipei');

function datetime($hour_type){
	if($hour_type == 12){
		return date("Y/m/d");
	}else{
		return date("Y/m/d");
	}
}


function echobr($str){
	echo $str . "<br />";

}

/**
 * @return mixed 傳回 資料庫連線
 */
function get_conn(){
	$db_server 		= "localhost";
	$db_username 	= "root";
	$db_password 	= "root";
	//$db_password 	= "";
	$db_name		= "borrow";

	$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

	mysqli_query($conn, "set names utf8");

	return $conn;
}

/**
 * @param $id
 * @return array
 */
function get_user_info($id){
	$conn = get_conn();

	$stmt = sprintf("SELECT * from `borrow` WHERE id='%s' ", $id);

	// return $stmt;

	
	$result = mysqli_query($conn, $stmt);

	return mysqli_fetch_assoc($result);
	
}

function check_field_complete(){
    $form_fill_complete = true;
    if( ($_POST[ "item" ]==false) )$form_fill_complete = false;

    return $form_fill_complete;
}


/**
 * @return array|null
 * 取得所有的設備名稱
 */
function get_items(){
	$stmt = "select id, item from createitem ";
	$result = mysqli_query( get_conn(), $stmt);

	return mysqli_fetch_all($result);
}


function get_item_borrowed( $item = '' ){

	if( $item == '') return false;


	$ret = '';

	$stmt = "SELECT * FROM  `borrow` where `item` = '" . $item  .  "' and p2 is null order by `borrowtime` desc";


	$result = mysqli_query(get_conn(), $stmt );

	while($record = mysqli_fetch_assoc($result)){
		$ret .= "<li class='list-group-item no-border'>".$record['borrowtime']."--".$record['cname']."借用".$record['mamo']."</li>";
	}

	return $ret;
}

function dump( $obj ){
	print "<pre>";
	var_dump( $obj );
	print "</pre>";
}


function chk_permission($school_id = '', $title = ''){
	if( $school_id=='' or $title=='') return false;

	$forward_url = 'notschool.html';

	if( in_array($school_id, CONFIG::$ALLOW_SCHOOL ) ){
		if( in_array($title, CONFIG::$ALLOW_TITLE) ){
			$forward_url = 'mylist.php';
		}
	}

	return $forward_url;
}

/*function chk_title($title = ''){
	if( $title=='') return false;

	$forward_url = '';

	if( $title == '014754' or $title == '014613'){
		$forward_url = 'mylist.php';
	}else{
		$forward_url = 'notschool.html';
	}
}*/
?>
