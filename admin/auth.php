<?php
session_start();
if(isset($_SESSION["user"]) && isset($_SESSION["userid"])){
	session_regenerate_id();
	if($page !== "edit.php" && $page !== "control.php"){
		exit(header("Location: control.php"));
	}
}else{
	if($page !== 'index.php') {
		exit(header("Location: index.php"));
	}	
}
?>