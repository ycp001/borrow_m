<?php
session_start();

include "function.php";


	if( $_SESSION['teacherid'] == "alanjih" or $_SESSION['teacherid'] == "ritaapple" or $_SESSION['teacherid'] == "rash0507" or $_SESSION['teacherid'] == "zoea22" or $_SESSION['teacherid'] == "dj8816" or $_SESSION['teacherid'] == "th818" ) {
		  header('Location:alllist.php ');
	}
	else { header('Location:notteacher.html ');   
		}
	

?>