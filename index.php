<?php
	require_once("assets/database.php");
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
<form method="get">
	<div class="input-group" style="width: 50%; left: 25%;">
	
		<input type="text" class="form-control text-center" name="search" placeholder=".... أكتب كلمة للبحث ....">
		<div class="input-group-btn">
		  <button class="btn btn-default" type="submit">
			<i class="glyphicon glyphicon-search"></i>
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
      </tr>
    </thead>
    <tbody>
	<?php	
			$maxres = 10;
			$pagez = $con->real_escape_string(htmlspecialchars(stripslashes(strip_tags($_GET['page']))));
			$page = (isset($pagez) && !empty($pagez)) ? (int)$_GET['page'] : 1;
			$offset = $maxres * ($page - 1);
			$srch = null;
			if(isset($_GET['search']) && !empty($_GET['search'])){
				$srch = $con->real_escape_string(htmlspecialchars(stripslashes(strip_tags($_GET['search']))));
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
			$verz = '<img src="assets/clock.png" width="16" height="16" alt="انتظار التأكيد" title="فى انتظار التأكد">';
			$vero = '<img src="assets/accept.png" width="16" height="16" alt="تم التأكد" title="تم التأكد">';
			if($res->num_rows > 0){
				while($data = $res->fetch_assoc()){
					$id = $data["id"];
					$trans = $data["translator"];
					$ename = $data["ename"];
					$aname = $data["aname"];
					$ver = intval($data["ver"]);
					echo "<tr> <td>$id</td> <td><a href='info.php?query=$ename'>$ename</a></td> <td>$aname</td> <td>$trans</td>"; if($ver === 0){ echo "<td>$verz</td>"; }else if($ver ===  1){ echo "<td>$vero</td>"; }  echo "</tr>";
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
