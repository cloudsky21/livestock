<?PHP 
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');

if((!isset($_SESSION['isLogin'])) && (!isset($_COOKIE["lx"]))) { header("location: logmeOut");}



	?>

	<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){

		$db->beginTransaction();
		try {
			$pyear = htmlentities($_POST['year']);
			$tablename = 'control'.$pyear;
			$tb_reg = "controlr".$pyear;
			$tb_apcp = "controla".$pyear;
			$tb_pnl = "controlacpc".$pyear;

			$result = $db->prepare("INSERT INTO year(year) VALUES(?)");
			$result->execute([$pyear]);	

//RSBSA
			$result = $db->prepare("
				CREATE TABLE `$tablename` ( 
				Year VARCHAR(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,	
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(4) NOT NULL DEFAULT 'PPPP',
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal DECIMAL(20,0) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,0) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(200) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				PRIMARY KEY (idsnumber)
			);");

			$result->execute();

//REGULAR

			$result = $db->prepare("
				CREATE TABLE `$tb_reg` ( 
				Year VARCHAR(4) NOT NULL,
				date_r DATE NOT NULL,
				receiptNumber DECIMAL(20,0) NOT NULL,
				receiptAmt DECIMAL(20,2) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				rcd VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal DECIMAL(20,0) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,0) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				second_from DATE NOT NULL,
				second_to DATE NOT NULL,
				third_from DATE NOT NULL,
				third_to DATE NOT NULL,
				imagepath VARCHAR(300) NOT NULL,
				loading VARCHAR(500) NOT NULL,
				iu VARCHAR(500) NOT NULL,
				prepared VARCHAR(200) NOT NULL,
				s_charge DECIMAL(20,2) NOT NULL,
				PRIMARY KEY (idsnumber)
			);");

			$result->execute();

	//APCP
			$result = $db->prepare("
				CREATE TABLE `$tb_apcp` ( 
				Year VARCHAR(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,	
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(4) NOT NULL DEFAULT 'PPPP',
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal DECIMAL(20,0) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,0) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				PRIMARY KEY (idsnumber)
			);");

			$result->execute();	

		//PUNLA
			$result = $db->prepare("
				CREATE TABLE `$tb_pnl` ( 
				Year VARCHAR(4) NOT NULL,
				date_r DATE NOT NULL,
				program VARCHAR(20) NOT NULL,
				groupName VARCHAR(300) NOT NULL,
				ids1 VARCHAR(30) NOT NULL,	
				idsnumber INT(4) NOT NULL AUTO_INCREMENT,
				idsprogram VARCHAR(4) NOT NULL DEFAULT 'PPPP',
				lsp VARCHAR(20) NOT NULL,
				status TEXT(20) NOT NULL,
				office_assignment VARCHAR(200) NOT NULL,
				province VARCHAR(300) NOT NULL,
				town VARCHAR(300) NOT NULL,
				assured VARCHAR(300) NOT NULL,
				farmers DECIMAL(20,0) NOT NULL,
				heads DECIMAL(20,0) NOT NULL,
				animal DECIMAL(20,0) NOT NULL,
				premium DECIMAL(20,2) NOT NULL,
				amount_cover DECIMAL(20,2) NOT NULL,
				rate DECIMAL(20,0) NOT NULL,
				Dfrom DATE NOT NULL,
				Dto DATE NOT NULL,
				lslb INT(4),
				imagepath VARCHAR(300) NOT NULL,
				PRIMARY KEY (idsnumber)
			);");

			$result->execute();	

			$RSBSA = "../L/uploads/RSBSA/".$pyear;
			if (!file_exists($RSBSA)) {
				mkdir($RSBSA, 0777, true);
			}
			$REG = "../L/uploads/REGULAR/".$pyear;
			if (!file_exists($REG)) {
				mkdir($REG, 0777, true);
			}
			$APCP = "../L/uploads/APCP/".$pyear;
			if (!file_exists($APCP)) {
				mkdir($APCP, 0777, true);
			}
			$PNL = "../L/uploads/PUNLA/".$pyear;
			if (!file_exists($PNL)) {
				mkdir($PNL, 0777, true);
			}


			unset($_POST);
			header('Location: '.$_SERVER[REQUEST_URI]);

		}
		catch(Exception $e){
			echo $e->getMessage();
			$db->rollback();
		}
		


	}	



	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>Livestock | Control</title>
		<link rel="shortcut icon" href="images/favicon.ico"/>
		<link rel="stylesheet" href="bootswatch/solar/bootstrap.min.css">
		<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
		<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">		
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
						<ul class="nav navbar-nav navbar-right">
							
							<li><a href="rsbsa">RSBSA</a></li>
							<li><a href="indexR">Regular Program</a></li>
							<li><a href="apcp">APCP</a></li>
							<li><a href="acpc">Punla</a></li>
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
								else {}
									?>
								<li><a href="locations">Locations</a></li>
								<li><a href="logmeOut">Log Out</a></li>
							</ul>
						</li>      
					</ul>	

				</div>
			</div>
		</nav>

		<div style="margin-top:100px;">
			<form method="post" class="form-inline" action="">
				<div class="form-group">
					<label for="year">Year:</label>

					<input type="number" name="year" step="any" min="0" class="form-control input-lg">

				</div>
				<button type="submit" class="btn btn-primary">Add Year</button>
			</div>
		</form>


		<table class="table" style="margin-top: 100px;">
			<thead>
				<tr>
					<th>ID</th>
					<th>Year</th>

				</tr>
			</thead>

			<tbody>
				<?php 
				$result = $db->prepare("SELECT * FROM year");
				$result->execute();

				foreach($result as $row){
					echo '<tr>';
					echo '<td>'.$row['id'].'</td>';
					echo '<td>'.$row['year'].'</td>';
					echo '</tr>';

				}
				?>

			</tbody>	


		</table>
	</div>











</div>
</body>
</html>