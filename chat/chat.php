<?php
if(isset($_POST["function"]) && isset($_POST["message"]) && isset($_POST["nickname"])){
	if($_POST["function"] === "send"){
			session_start();
			if(!isset($_SESSION["ctime"])){
				$_SESSION["ctime"] = time();
			}
			$diff = abs($_SESSION["ctime"] - time());
			if($diff < 2){
				die;
			}
		header('Content-Type: application/json; charset=UTF-8');
		//$msg = htmlspecialchars(escapeshellcmd(strip_tags($_POST["message"])));
		$msg = htmlspecialchars(stripslashes(strip_tags($_POST["message"])));
		$nick = htmlspecialchars(escapeshellcmd(stripslashes(strip_tags($_POST["nickname"]))));
		$msg = trim($msg);
		if(strlen($nick) < 3 || mb_strlen($msg) > 200 || empty($msg) || ctype_space($msg) || preg_match('/^\s+$/',$msg)){ die; }
		$fp = fopen("chat.txt","a");
		$msg = str_replace("(btc)", "<span class='glyphicon glyphicon-btc text-danger'></span>", $msg);
		$msg = str_replace("(apple)", "<span class='glyphicon glyphicon-apple text-success'></span>", $msg);
		$msg = str_replace("(tree)", "<span class='glyphicon glyphicon-tree-deciduous text-success'></span>", $msg);
		$msg = str_replace("(flash)", "<span class='glyphicon glyphicon-flash text-warning'></span>", $msg);
		$nick = "<span class='text-primary'>$nick</span>";
		$msgz = base64_encode("$nick: $msg")."\n";
		fwrite($fp, $msgz);
		fclose($fp);
		$_SESSION["ctime"] = time();
	}
	
}else if(isset($_POST["function"])){
	header('Content-Type: application/json; charset=UTF-8');
	if($_POST["function"] === "update"){
		$chat = array();
		if ($file = fopen("chat.txt", "r")){
			while(!feof($file)) {
				$line = base64_decode(fgets($file));
				//$cz = explode(':', $line);
				array_push($chat, $line);
			}
			fclose($file);
		}
		echo json_encode($chat);
		fclose($fp);
	}
}

?>