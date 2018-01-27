<?PHP 
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');

if($_SESSION['isLogin'] == 0) {
	
	header("location: index.php");
}



?>


<?php

if(isset($_POST['add'])){

$office = strtoupper(htmlentities($_POST['peo']));
$city = strtoupper(htmlentities($_POST['city']));
$brgy = strtoupper(htmlentities($_POST['barangay']));



$result = $db->prepare("INSERT INTO location(barangay,town,office) VALUES(?,?,?)");
$result->execute([$brgy,$city,$office]);

unset($_POST);
header("location: ".$_SERVER[REQUEST_URI]);



















}
?>


<!DOCTYPE html>
<html>
<head>
<title>Livestock | Control</title>
<link rel="shortcut icon" href="favicon.ico"/>
<link rel="stylesheet" href="bootswatch/solar/bootstrap.min.css">
<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

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
<div class="container-fluid">
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
		<li><a href="rsbsa">RSBSA</a></li>
		<li><a href="indexR">Regular Program</a></li>
		<li><a href="apcp">APCP</a></li>
		<li><a href="acpc">Punla</a></li>
		<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <span class="caret"></span></a>
			<ul class="dropdown-menu">
					<li><a href="#" style="color:gray; pointer-events: none; border-bottom: 1px solid #ddd" tabindex="-1"><?PHP echo $_SESSION['isLoginName']; ?></a></li>
				<li><a href="year">Insurance Year</a></li>
				<li><a href="locations">Locations</a></li>
				<li><a href="farmers">Farmers List</a></li>
				<li><a href="accounts">Accounts</a></li>
				<li><a href="logmeOut">Log Out</a></li>
			</ul>
		</li>
	</ul>
	
  </div>
</div>
</nav>





<div class="page-header" style="margin-top:100px;">
<h2>Farmers List</h2>
</div>


<form>
  <div class="input-group">
    <input type="text" class="form-control" placeholder="Search ID">
    <div class="input-group-btn">
      <button class="btn btn-default" type="submit">
        <i class="glyphicon glyphicon-search"></i>
      </button>
    </div>
  </div>
</form>
	
<table class="table table-striped table-hover" style="margin-top: 60px;" id="mytable">
	<thead>
		<tr>
			<th>ID</th>
			<th>FARMER NAME</th>
			<th>ADDRESS</th>
			<th>BIRTHDAY</th>
			<th>SEX</th>
			<th>SPOUSE</th>
			<th>Insurances</th>
		</tr>
		
			
	</thead>

	<tbody>
		<?php
		
		if($_SESSION['office'] != "Regional Office"){
			$result = $db->prepare("SELECT * FROM farmers WHERE office_assigned = ?");
			$result->execute([$_SESSION['office']]);
			
			
			foreach($result as $row){
				echo '<tr>';
					echo '<td>'.$row['id'].'</td>';
					echo '<td>'.$row['farmer'].'</td>';
					echo '<td>'.$row['sitio'].', '.$row['barangay'].', '.$row['city'].', '.$row['province'].'</td>';
					echo '<td>'.$row['bday'].'</td>';
					echo '<td>'.$row['sex'].'</td>';
					echo '<td>'.$row['spouse'].'</td>';
					echo '<td>'.$row['lg'].' Large</td>';
					echo '<td>'.$row['sm'].' Small</td>';
					echo '<td>'.$row['poultry'].'</td>';
				echo '</tr>';	
				
				
				
				
			}
		}
		else
		{
			$result = $db->prepare("SELECT * FROM farmers");
			$result->execute();
			
			
			foreach($result as $row){
				echo '<tr>';
					echo '<td>'.$row['id'].'</td>';
					echo '<td>'.$row['farmer'].'</td>';
					echo '<td>'.$row['sitio'].', '.$row['barangay'].', '.$row['city'].', '.$row['province'].'</td>';
					echo '<td>'.$row['bday'].'</td>';
					echo '<td>'.$row['sex'].'</td>';
					echo '<td>'.$row['spouse'].'</td>';
					echo '<td>'.$row['lg'].' Large</td>';
					echo '<td>'.$row['sm'].' Small</td>';
					echo '<td>'.$row['poultry'].'</td>';
				echo '</tr>';	
				
				
				
				
			}
			
			
		}

		?>
	</tbody>
</table>
</div>
</body>
</html>