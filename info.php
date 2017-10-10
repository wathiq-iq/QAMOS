<?php
if(!isset($_GET["query"])){
	exit(header("Location: index.php"));
}else{
	require_once("assets/database.php");
	$word = secure($con, $_GET['query']);
	$sql = "SELECT * FROM dictionary WHERE ename='$word' LIMIT 1";
	$res = $con->query($sql);
	if($res->num_rows === 1){
		$data = $res->fetch_assoc();
	}else{
		exit(header("Location: index.php"));
	}
}

if(isset($_POST["like"]) && isset($data["id"]) && !empty($data["id"])){
	$ipz = get_client_ip();
	if($ipz === false){ die("Error 404!"); }
	$idz = $data["id"];
	$ipz = secure($con, $ipz);
	$sql = "SELECT * FROM vote WHERE wordid='$idz' AND ip='$ipz'";
	$res = $con->query($sql);
	if($res->num_rows > 0){
		exit(header("Location: index.php"));
	}else{
		$sqlz = "INSERT INTO vote (voteid, wordid, ip) VALUES (NULL, '$idz','$ipz');
		UPDATE dictionary SET up = up + 1 WHERE id='$idz';";
		$con->multi_query($sqlz);
		
		header("Location: info.php?query=".$_GET["query"]);
	}
}else if(isset($_POST["dislike"]) && isset($data["id"]) && !empty($data["id"])){
	$ipz = get_client_ip();
	if($ipz === false){ die("Error 404!"); }
	$idz = $data["id"];
	$ipz = secure($con, $ipz);
	$sql = "SELECT * FROM vote WHERE wordid='$idz' AND ip='$ipz'";
	$res = $con->query($sql);
	if($res->num_rows > 0){
		exit(header("Location: index.php"));
	}else{
		$sqlz = "INSERT INTO vote (voteid, wordid, ip) VALUES (NULL, '$idz','$ipz');
		UPDATE dictionary SET down = down + 1 WHERE id='$idz';";
		$con->multi_query($sqlz);
		
		header("Location: info.php?query=".$_GET["query"]);
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Asus Dictionary</title>
  <meta charset="utf-8">
<link rel="icon" type="image/png" href="https://aosus.org/uploads/default/original/1X/d3bd83add89f9bd0da48c30c55a693e06be1b056.png">
<link rel="apple-touch-icon" type="image/png" href="https://aosus.org/uploads/default/original/2X/c/c252390ce9a24ba2e4bfb7d0730980b73b205f51.png">
<link rel="icon" type="image/png" sizes="144x144" href="https://aosus.org/uploads/default/original/2X/c/c252390ce9a24ba2e4bfb7d0730980b73b205f51.png">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
</head>
<body>

<div class="jumbotron" style="height: 220px; background-image: url('assets/test.png'); background-size: cover; background-position: center;">
</div>

<div class="container text-center">

<hr/><h2 class="text-right"><?php echo "( ".$data["aname"]." ) ".$data["ename"]; ?></h2> <br/>
<div class="well well-lg text-right">
	<h4>ملاحظات على الكلمة</h4>
	<?php
	if(isset($data["comment"]) && !empty($data["comment"])){
			echo $data["comment"];
	} else{
		echo "لا يوجد ملاحظات";
	}
	?>
</div>
<div class="well well-lg text-right">
	<h4>أمثلة توضيحية</h4>
	<kbd style="color: #81CFE0; padding: 8px;">
		<?php
			if(isset($data["example"]) && !empty($data["example"])){
					echo $data["example"];
			}else{
				echo "لا يوجد أمثلة توضيحية";
			}
		?>
	</kbd>
</div>
<br/><hr/><br/><br/>
<form method="post">
<?php
	$idz = $data["id"];
	
	$sqlz = "SELECT id,up,down FROM dictionary WHERE id='$idz' LIMIT 1";
	$resz = $con->query($sqlz);
	if($resz->num_rows > 0){
		$dz = $resz->fetch_assoc();
		$up = $dz["up"];
		$down = $dz["down"];
		if(!isset($up) || empty($up)){
			$up = 0;
		}else if(!isset($down) || empty($down)){
			$down = 0;
		}
	}else{
		$up = 0;$down = 0;
	}
	
	$ipz = get_client_ip();
	if($ipz === false){ die("Error 404!"); }
	$sqln = "SELECT * FROM vote WHERE wordid='$idz' AND ip='$ipz'";
	$res = $con->query($sqln);
	
	if($res->num_rows > 0){
		echo '<button type="button" class="btn btn-primary disabled" style="font-size: 25px;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp; '.$up.'</button>&nbsp;&nbsp;&nbsp;
		<button type="button" class="btn btn-danger disabled" style="font-size: 25px;"><span class="glyphicon glyphicon-thumbs-down"></span>&nbsp; '.$down.'</button>
		';
	}else{
		echo '<button type="submit" name="like" class="btn btn-primary" style="font-size: 25px;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp; '.$up.'</button>&nbsp;&nbsp;&nbsp;
		<button type="submit" name="dislike" class="btn btn-danger" style="font-size: 25px;"><span class="glyphicon glyphicon-thumbs-down"></span>&nbsp; '.$down.'</button>
		';
	}
?>


</form>
</div>
</body>
</html>
