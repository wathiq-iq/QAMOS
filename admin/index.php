<?php
	$page = "index.php";
	require_once("auth.php");
	require_once("../assets/database.php");
	if(isset($_POST["submit"]) && isset($_POST["user"]) && isset($_POST["pass"])){
		$error = ""; $ok = 0;
		$user = secure($con, $_POST["user"]);
		$pass = md5(secure($con, $_POST["pass"]));
		$sql = "SELECT * FROM users WHERE username='$user' AND password='$pass' LIMIT 1";
		$res = $con->query($sql);
		if($res->num_rows == 1){
			$ok = 1;
			$id = $res->fetch_assoc()["id"];
		}else{
			$error = "Invalid Username Or Password!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Asus Cpanel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php
	if(!empty($error) && $error !== ""){
		echo '
			<div class="container text-center">
				<br/><br/><br/>
				<div class="alert alert-danger">
				  <strong>Error: </strong>'.$error.'
				</div>
		    </div>';
	}else if($ok === 1 && isset($id)){
		$_SESSION["user"] = $user;
		$_SESSION["userid"] = $id;
			echo '
			<div class="container text-center">
				<br/><br/><br/>
				<div class="alert alert-success">
				  <strong>Done: </strong> You Have Logged In Successfuly!
				</div>
		    </div>';
		header("refresh:1;url=control.php");
	}
?>


  <div class="login">
	<h1>Administration Panel</h1>
    <form method="post">
    	<input type="text" name="user" placeholder="Username" required="required" />
        <input type="password" name="pass" placeholder="Password" required="required" />
        <button type="submit" name="submit" class="btn btn-primary btn-block btn-large">Log in</button>
    </form>
  </div>
  
</body>
</html>
