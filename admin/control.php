<?php
$page = "control.php";
require_once("auth.php");
if(isset($_POST["submit"]) && isset($_POST["logout"])){
	unset($_SESSION["user"]);
	unset($_SESSION["userid"]);
	session_destroy();
	if($page !== 'index.php') {
		exit(header("Location: index.php"));
	}
}
if(isset($_POST["wadd"]) && isset($_POST["weng"]) && isset($_POST["war"])){
	require_once("../assets/database.php");
	$weng = secure($con, $_POST['weng']);
	$war = secure($con, $_POST['war']);
	
	if(isset($_POST["wex"])){
		$wex = secure($con, $_POST['wex']);
	}else{
		$wex = "0";
	}if(isset($_POST["wcom"])){
		$comm = secure($con, $_POST['wcom']);
	}else{
		$comm = "0";
	}
	$id = $_SESSION["userid"];
	$sql = "SELECT realname FROM users WHERE id='$id' LIMIT 1";
	$res = $con->query($sql);
	if($res->num_rows === 1){
		$realname = $res->fetch_assoc()["realname"];
		$sqlz = "INSERT INTO dictionary (id, ename, aname, translator, ver, example, comment) VALUES (NULL, '$weng','$war','$realname','0','$wex','$comm')";
		$con->query($sqlz);
	}else{
		header("Location: control.php");
	}
	
	header("Location: control.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Asus Control Panel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript">
		$(document).ready(function(e){
			$("textarea").focus(function(e){
				$(this).attr("placeholder",null);
				$(this).removeClass("text-center");
			});
			$("textarea").focusout(function(e){
				var x = $("textarea").val();
				if(!x){
					$(this).attr("placeholder",".... ملاحظات ....");
					$(this).addClass("text-center");
				}
			});
			$("#glist").click(function(e){
				window.location.href = "edit.php";
			});
		});
  </script>
</head>
<body>

<div class="jumbotron text-center">
  <h1><?php echo ucfirst($_SESSION["user"]); ?>&nbsp;أهلا بك</h1>
  <b style="font-size: 18px;"><kbd style="font-size: 25px;"><span class="text-danger">@Pal</span><span class="text-success">Vps</span></kbd>&nbsp;هذا الموقع تحت التطوير </b> 
</div>
  
<div class="container text-center">
<div class="panel panel-info">
<div class="panel-heading" style="font-size: 20px;">إضافة كلمة جديدة</div>
  <div class="panel-body">
  <form method="post">
		<div class="form-group">
		<div class="col-sm-10">
			  <input type="text" name="weng" class="form-control text-center" maxlength="15" placeholder=".... ادخل الكلمة هنا ...." required />
			</div>
			<label class="control-label col-sm-2" style="font-size: 20px; margin-top: 2px;">: الكلمة بالإنجليزية</label>
	   </div><br/><br/>
	   	<div class="form-group">
		<div class="col-sm-10">
			  <input type="text" class="form-control text-center" name="war" maxlength="30" placeholder=".... ترجمة الكلمة ...." required />
			</div>
			<label class="control-label col-sm-2" style="font-size: 20px; margin-top: 2px;">: الترجمة باللغة العربية</label>
	   </div><br/><br/>
	   	<div class="form-group">
		<div class="col-sm-10">
			  <input type="text" class="form-control text-center" name="wex" placeholder=".... أدخل مثال هنا ...." />
			</div>
			<label class="control-label col-sm-2" style="font-size: 20px; margin-top: 2px;">:مثال</label>
	   </div><br/><br/>
	  	<div class="form-group">
		<div class="col-sm-10">
			  <textarea class="form-control text-center" rows="5" name="wcom" style="resize: none;" placeholder=".... ملاحظات ...."></textarea>
			</div>
			<label class="control-label col-sm-2" style="font-size: 20px; margin-top: 3%;">: ملاحظات على الكلمة</label>
	   </div>
	   <br/><br/>
	   <button type="button" class="btn btn-warning" id="glist" style="width: 250px; font-size: 18px; margin-top: 3%;">تعديل الكلمات</button>
	   <button type="submit" class="btn btn-primary" name="wadd" style="width: 250px; font-size: 18px; margin-top: 3%;">أضافة الكلمة</button>
	   </form>
  </div>
  <div class="panel-footer"></div>
</div>
  <br/><br/><br/>
  <form method="post" class="text-center">
	<input type="hidden" value="logout" name="logout" />
	<button type="submit" class="btn btn-danger" name="submit">تسجيل الخروج</button>
</form>
</div>

</body>
</html>
