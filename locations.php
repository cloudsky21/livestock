<?PHP 
session_start();

require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');

if(!isset($_SESSION['isLogin']) || (!isset($_COOKIE["lx"]))) {
	
	header("location: logmeOut");
}


if(isset($_POST['add'])){

	$unwanted = array("&NTILDE;" => "Ñ");		
	$cnt = 0;
	$office = strtr(strtoupper(htmlentities($_POST['peo'])),$unwanted);
	$city = strtr(strtoupper(htmlentities($_POST['city'])),$unwanted);
	$brgy = strtr(strtoupper(htmlentities($_POST['barangay'])),$unwanted);
	$province = strtr(strtoupper(htmlentities($_POST['province'])),$unwanted);

	$check = $db->prepare("SELECT * FROM location WHERE office = ? && province = ? && town = ? && barangay = ?");
	$check->execute([$office, $province, $city, $brgy]);
	$cnt = $check->rowCount();
	if($cnt == 0){

		$result = $db->prepare("INSERT INTO location(barangay,town,province,office) VALUES(?,?,?,?)");
		$result->execute([$brgy,$city,$province,$office]);

		unset($_POST);
		header("location: ".$_SERVER[REQUEST_URI]);

	}
	else
	{
		$notice = "<div class=\"alert alert-warning\">Location already been added.</div>";
	}




}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Livestock | Control</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<link rel="stylesheet" href="resources/bootswatch/lumen/bootstrap.min.css">
	<script src="resources/bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="resources/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

	<script>
		function address($val){

			var office = $val;
			$('#mytable > tbody').empty();
			$.ajax({
				type: "POST",
				url: "address.php",
				data: { 'id': office  },
				success: function(data){

					$('#mytable > tbody').html(data); 


				}
			});
		}




	</script>

	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
</head>
<body>


	<div class="container">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="home">Livestock Control</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">

					</ul>

					<ul class="nav navbar-nav navbar-right">
						<li><a href="programs/rsbsa">RSBSA</a></li>
						<li><a href="programs/regular">Regular Program</a></li>
						<li><a href="programs/apcp">APCP</a></li>
						<li><a href="programs/acpc">Punla</a></li>

						<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#" style="color:gray; pointer-events: none; border-bottom: 1px solid #ddd" tabindex="-1"><?PHP echo $_SESSION['isLoginName']; ?></a></li>
								<?php 
								if($_SESSION['stat']=="Admin") { ?>
								<li><a href="year">Insurance Year</a></li>

								<li><a href="farmers">Farmers List</a></li>
								<li><a href="accounts">Accounts</a></li>
								<?php 
							}
							?>
							<li><a href="locations">Locations</a></li>
							<li><a href="logmeOut">Log Out</a></li>
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</nav>





	<div class="page-header" style="margin-top:100px;">
		<h2>ADDRESS</h2>
	</div>


	<form method="post" action="" class="form-inline">

		<div class="form-group">

			<label for="peo">OFFICE: </label>
			<select id="peo" name="peo" class="form-control" onchange="address(this.value);">
				<option value="Leyte1-2" selected>Leyte 1 and 2</option>
				<option value="PEO Biliran">Biliran Extension</option>
				<option value="PEO Ormoc">Ormoc Extension</option>
				<option value="PEO Abuyog">Abuyog Extension</option>
				<option value="PEO Sogod">Sogod Extension</option>
				<option value="PEO W-Samar">Western Samar Extension</option>
				<option value="PEO E-Samar">Eastern Samar Extension</option>
				<option value="PEO N-Samar">Northern Samar Extension</option>
			</select>

		</div>

		<div class="form-group">
			<label for="city">Province: </label>
			<input type="text" class="form-control" id="province" name="province">
		</div>

		<div class="form-group">
			<label for="city">City/Town: </label>
			<input type="text" class="form-control" id="city" name="city">
		</div>

		<div class="form-group">
			<label for="barangay">Barangay: </label>
			<input type="text" class="form-control" id="barangay" name="barangay">
			<button class="btn btn-success" type="submit" name="add">Add</button>
		</div>







	</form>
	<?php if(isset($notice)){ 
		echo $notice; 
		header('Refresh: 3; url='.$_SERVER['PHP_SELF']); 
	} 
	?> 
	<table class="table table-hover" style="margin-top: 60px;" id="mytable">

		<thead>
			<tr>

				<th>Office</th>
				<th>Province</th>
				<th>City/Town</th>
				<th>Barangay</th>
			</tr>
		</thead>

		<tbody>
			<?php

			$result = $db->prepare("SELECT * FROM location ORDER BY id DESC");
			$result->execute();
			
			
			foreach($result as $row){
				echo '<tr>';
				echo '<td>'.$row['office'].'</td>';
				echo '<td>'.$row['province'].'</td>';
				echo '<td>'.$row['town'].'</td>';
				echo '<td>'.$row['barangay'].'</td>';
				echo '</tr>';	
				
				
				
				
			}
			

			?>
		</tbody>
	</table>
</div>
</body>
</html>