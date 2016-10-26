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


function parse_students_xml( $xml_filename = '')
{

	if( $xml_filename == '') return false;


	$dom = new DOMDocument('1.0', 'UTF-8');
	$dom->load($xml_filename);

	$students = $dom->getElementsByTagNameNS("http://163.20.240.13", "row");


	$arr = array();

	foreach ($students as $row) {
		$student = $row->getElementsByTagNameNS("http://163.20.240.13", "col");

		if ($student->item(0)->nodeValue == '學號') {
			continue;
		}



		$schoolno = $student->item(0)->nodeValue;

		$studentName = $student->item(1)->nodeValue;
		$classname = $student->item(2)->nodeValue . $student->item(5)->nodeValue;
		$gender = $student->item(3)->nodeValue;

		$birth = $student->item(4)->nodeValue;


		if (strlen($birth) == 8) {              // 生日為西元年
			$birth = substr($birth, 0, 4) . "-" . substr($birth, 4, 2) . "-" . substr($birth, 6, 2);
		} else {                                                  // 生日>非西元年
			if (strlen($birth) == 6) {
				$birth = (substr($birth, 0, 2) + 1911) . "-" . substr($birth, 2, 2) . "-" . substr($birth, 4, 2);
			} elseif (strlen($birth) == 7) {
				$birth = (substr($birth, 0, 3) + 1911) . "-" . substr($birth, 3, 2) . "-" . substr($birth, 5, 2);
			}
		}

		$classno = $student->item(6)->nodeValue;


		$arr[] = [
			'schoolno' => $schoolno,
			'cname' =>$studentName,
			'classname' => $classname,
			'classno' => $classno,
			'gender' => $gender,
			'birth' => $birth
		];
	}

	return $arr;
}