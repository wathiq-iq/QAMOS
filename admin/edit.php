<?php
$page = "edit.php";
require_once("auth.php");
if(isset($_POST["submit"]) && isset($_POST["logout"])){
	unset($_SESSION["user"]);
	unset($_SESSION["userid"]);
	session_destroy();
	if($page !== 'index.php') {
		exit(header("Location: index.php"));
	}
}
require_once("../assets/database.php");
if(isset($_GET["zoz"])){
	$x = urldecode($_GET["zoz"]);
	$xz = intval($con->real_escape_string(strip_tags(stripslashes(base64_decode(base64_decode(gzinflate($x)))))));
	$sql = "UPDATE dictionary SET ver='0' WHERE id='$xz'";
	$con->query($sql);
	header("Location: edit.php");
}else if(isset($_GET["vrf"])){
	$x = urldecode($_GET["vrf"]);
	$xz = intval($con->real_escape_string(strip_tags(stripslashes(base64_decode(base64_decode(gzinflate($x)))))));
	$sql = "UPDATE dictionary SET ver='1' WHERE id='$xz'";
	$con->query($sql);
	header("Location: edit.php");
}else if(isset($_GET["dll"])){
	$x = urldecode($_GET["dll"]);
	$xz = intval($con->real_escape_string(strip_tags(stripslashes(base64_decode(base64_decode(gzinflate($x)))))));
	$sql = "DELETE FROM dictionary WHERE id='$xz'";
	$con->query($sql);
	header("Location: edit.php");
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
  <script src="../assets/tableEdit.js"></script>
  <style type="text/css">
    .glyphicon{
		font-size: 20px;
		color: #333;
	}
	.glyphicon-time:hover{
		cursor: pointer;
		color: #D91E18;
	}
	.glyphicon-ok:hover{
		cursor: pointer;
		color: #22A7F0;
	}
	.glyphicon-remove{
		color: #D64541;
	}
	.glyphicon-remove:hover{
		cursor:pointer;
		color: #CF000F;
	}
  </style>
	<script type="text/javascript">
			$(document).ready(function(e){
				$(".glyphicon").hover(function(e){
					if($(this).hasClass("glyphicon-time")){
						$(this).removeClass("glyphicon-time");
						$(this).addClass("glyphicon-ok");
					}else if($(this).hasClass("glyphicon-ok")){
						$(this).removeClass("glyphicon-ok");
						$(this).addClass("glyphicon-time");
					}
				});
				
				$('.table').Tabledit({
					deleteButton: false,
					removeButton: false,
					editButton: false,
					saveButton: false,
					restoreButton: false,
					url: "table.php",
					inputClass: 'form-control input-sm text-center rtl',
					dangerClass: '',
					onSuccess: function() { alert("Done"); },
					columns: {
						identifier: [0, 'id'],
						editable: [[1, 'Ename'],[2, 'Aname']]
					}
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
	<form method="get">
	<div class="input-group" style="width: 50%; left: 25%;">
	
		<input type="text" class="form-control text-center" name="search" placeholder=".... أكتب كلمة للبحث ....">
		<div class="input-group-btn">
		  <button class="btn btn-default" type="submit">
			<i class="glyphicon glyphicon-search" style="font-size: 16px;"></i>
		  </button>
		</div>
		
  </div></form><br/><br/><br/>
 <div class="table-responsive" dir="rtl">          
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th class="text-center">#</th>
        <th class="text-center">الأسم الانجليزي</th>
        <th class="text-center">الترجمة بالعربى</th>
        <th class="text-center">أسم المترجم</th>
        <th class="text-center">الحالة</th>
        <th class="text-center">حذف</th>
      </tr>
    </thead>
    <tbody>
	<?php	
			$maxres = 10;
			$pagez = secure($con, $_GET['page']);
			$page = (isset($pagez) && !empty($pagez)) ? (int)$_GET['page'] : 1;
			$offset = $maxres * ($page - 1);
			$srch = null;
			if(isset($_GET['search']) && !empty($_GET['search'])){
				$srch = secure($con, $_GET['search']);
				$sqlz = "SELECT COUNT(*) as total FROM dictionary WHERE ename LIKE '%$srch%' OR aname LIKE '%$srch%'";
			}else{
				$sqlz = "SELECT COUNT(*) as total FROM dictionary";
			}
			
			$res = $con->query($sqlz)->fetch_assoc();
			$total = ceil($res["total"] / $maxres);
			
			if(isset($srch) && !empty($srch)){
				$sql = "SELECT * FROM dictionary WHERE ename LIKE '%$srch%' OR aname LIKE '%$srch%' LIMIT $offset, $maxres";
			}else{
				$sql = "SELECT * FROM dictionary WHERE ename LIKE '%$srch%' OR aname LIKE '%$srch%' LIMIT $offset, $maxres";
			}
			
			$res = $con->query($sql);
			if($res->num_rows > 0){
				while($data = $res->fetch_assoc()){
					$id = $data["id"];
					$trans = $data["translator"];
					$ename = $data["ename"];
					$aname = $data["aname"];
					$ver = intval($data["ver"]);
					$idm = urlencode(gzdeflate(base64_encode(base64_encode($id))));
					$verz = "<a href='?vrf=$idm'><span class='glyphicon glyphicon-time'></span></a>";	
					$vero = "<a href='?zoz=$idm'><span class='glyphicon glyphicon-ok'></span></a>";
					echo "<tr> <td>$id</td> <td>$ename</td> <td>$aname</td> <td>$trans</td>"; if($ver === 0){ echo "<td>$verz</td>"; }else if($ver ===  1){ echo "<td>$vero</td>"; } 
					echo "<td><a href='?dll=$idm'><span class='	glyphicon glyphicon-remove'></span></a></td></tr>";
				}
			}else{
				$page = 1;
				$total = 1;
				echo "<tr> <td>-</td> <td>- - -</td> <td>- - -</td> <td>- - -</td> <td>-</td> </tr>";
			}
	?>
	
    </tbody>
  </table>
  </div>
	<footer>
		<ul class="pagination">
			<?php
				for($i = 1; $i <= $total; $i++){
					if($page === $i){ 
						echo "<li class='active'><a href=''>$i</a><li>";
					}else if(isset($srch) && !empty($srch)){
						echo "<li><a href='?page=$i&search=$srch'>$i</a><li>";
					}else{
						echo "<li><a href='?page=$i'>$i</a><li>";
					}	
				}
			?>
		</ul> 
	</footer>
</div>

</body>
</html>
