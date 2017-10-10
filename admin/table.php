<?php
if(isset($_POST["id"]) && isset($_POST["action"])){
	if($_POST["action"] === "edit" && isset($_POST["Ename"])){
		require_once("../assets/database.php");
		$nick = secure($con, $_POST["Ename"]);
		$id = intval(secure($con, $_POST["id"]));
		if(is_numeric($id)){
			$sql = "UPDATE dictionary SET ename='$nick' WHERE id='$id'";
			$con->query($sql);
		}
	}else if($_POST["action"] === "edit" && isset($_POST["Aname"])){
		require_once("../assets/database.php");
		$nick = secure($con, $_POST["Aname"]);
		$id = intval(secure($con, $_POST["id"]));
		if(is_numeric($id)){
			$sql = "UPDATE dictionary SET aname='$nick' WHERE id='$id'";
			$con->query($sql);
		}
	}else{
		die();
	}
}
?>