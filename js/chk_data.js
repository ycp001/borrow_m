function chk_data() {
	if( add_form.cname.value == "") {
		alert("「姓名」欄中不可為空白!");
		add_form.cname.focus();
	}
	else if (add_form.grade.value == ""){
		alert("請點選「年級或單位」!");
		add_form.cname.focus();
	}
	else if (add_form.cclass.value == ""){
		alert("請點選「班別或類別」!");
		add_form.cname.focus();
	}
	else if (add_form.web.value == ""){
		alert("「網址」欄中不可為空白!!");
		add_form.cname.focus();
	}else {retren true;}
		return false;
	
}