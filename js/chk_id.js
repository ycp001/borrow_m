function chk_id() {
	if( username.value == "") {
		alert("「姓名」欄中不可為空白!");
		username.focus();
	}
	else if (pass.value == ""){
		alert("請點選「年級或單位」!");
		pass.focus();
	}
	else {retren true;}
		return false;
	
}