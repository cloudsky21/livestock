<?PHP 
session_start();
require("connection/conn.php");
date_default_timezone_set('Asia/Manila');
if(!isset($_SESSION['isLogin']) && (!isset($_COOKIE["lx"]))) 
{ 
	header("location: logmeOut");
}








if(isset($_POST['delete_account'])){
	
	$get_record = $_POST['recorded'];
	
	$result = $db->prepare("DELETE FROM account WHERE account_id = ?");
	$result->execute([$get_record]);

	unset($_POST);
	header("location: ".$_SERVER['PHP_SELF']);

}

if(isset($_POST['addAccount'])){
	
	//Validate if not empty

	if((!empty($_POST['usr'])) && (!empty($_POST['pwd'])) && (!empty($_POST['sname'])) && (!empty($_POST['gname'])))
	{


		$userid = htmlentities($_POST['usr'], ENT_QUOTES);
		$userpas = sha1($_POST['pwd']);
		$surname = strtoupper(htmlentities($_POST['sname'], ENT_QUOTES));
		$given_name = strtoupper(htmlentities($_POST['gname'], ENT_QUOTES));
		$middlename = strtoupper(htmlentities($_POST['mname'], ENT_QUOTES));
		$userposition = htmlentities($_POST['actype'], ENT_QUOTES);
		$office_assignment= htmlentities($_POST['office']);

		$result = $db->prepare("INSERT INTO users (usrid, pswd, surname, firstname, middlename, actype, office) VALUES (?,?,?,?,?,?,?)");
		$result->execute([$userid, $userpas, $surname, $given_name, $middlename, $userposition, $office_assignment]);	

		unset($_POST);
		header("location: ".$_SERVER[REQUEST_URI]);
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" sizes="57x57" href="images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
	<link rel="stylesheet" href="bootswatch/solar/bootstrap.min.css">
	<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Accounts</title>

	<script>

		$(document).ready(function(){
			$('#delAccount').on('show.bs.modal', function (e) {
				var rowid = $(e.relatedTarget).data('id');
				$.ajax({
					cache: false,
					type : 'post',
            url : 'delete_account.php', //Here you will fetch records 
            data :  'rowid='+ rowid, //Pass $id
            success : function(data){
            $('.edit-data').html(data);//Show fetched data from database
        }
    });
			});
		});

		$(document).ready(function(){
			$('.dropdown-toggle').dropdown()
		});

	</script>
</head>

<body>
	<!-- Adding Account Modal-->
	<div class="modal fade" id="addAccount" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add User Account</h4>
					
				</div>
				<div class="modal-body">

					<form method="POST" action="" class="form-horizontal" autocomplete="false">
						<div class="form-group">
							<label for="usr" class="control-label col-sm-3">User ID: </label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="usr" name="usr" placeholder="Enter user account">
							</div>
						</div>

						<div class="form-group">
							<label  for="pwd" class="control-label col-sm-3">Password:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
							</div>
							
						</div>

						<div class="form-group">							
							<label for="sname" class="control-label col-sm-3">Surname:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="sname" name="sname" placeholder="Dela Cruz" required>
							</div>
						</div>

						<div class="form-group">							
							<label for="gname" class="control-label col-sm-3">Given name:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="gname" name="gname" placeholder="John" required>
							</div>
						</div>

						<div class="form-group">							
							<label for="mname" class="control-label col-sm-3">Middle name<br>(if any):</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="mname" name="mname" placeholder="Advincula">
							</div>
						</div>


						<?php
						echo '<div class="form-group">';
						$result = $db->prepare("SELECT count(*) as total FROM users WHERE actype = ?");
						$result->execute(["Admin"]);

						foreach($result as $row){

							$abled = $row['total'];

							if($abled == "1"){


								echo '<label for="actype" class="control-label col-sm-3">Account Type:</label>';
								echo '<div class="col-sm-9">';
								echo '<select name="actype" id="actype" class="form-control">';

								echo '<option value="Guest" selected>Guest</option>';
								echo '</select>';
								echo '</div>';


							}
							else{


								echo '<label for="actype" class="control-label col-sm-3">Account Type:</label>';
								echo '<div class="col-sm-9">';
								echo '<option value="Admin">Admin</option>';
								echo '<option value="Guest" selected>Guest</option>';
								echo '</select>';
								echo '</div>';										
							}




						}
						echo '</div>';
						?>

						<div class="form-group">
							<label for="office" class="control-label col-sm-3">Office Assignment:</label>
							<div class="col-sm-9">
								<select name="office" class="form-control" id="office">
									
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
						</div>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" name="addAccount">Add Account</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="delAccount" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete User Account</h4>
				</div>
				<form action="" method="POST">
					<div class="modal-body">
						<div class="edit-data"></div> 
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" name="delete_account" class="btn btn-danger">Confirm</button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="home">Livestock Control</a>
			</div>





			<ul class="nav navbar-nav navbar-right">
				<li><a href="#" data-toggle="modal" data-target="#addAccount"><span class="glyphicon glyphicon-plus"></span></a></li>
				<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp;<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#" style="color:gray; pointer-events: none; border-bottom: 1px solid #ddd" tabindex="-1"><?PHP echo $_SESSION['isLoginName']; ?></a></li>
						<li><a href="year">Insurance Year</a></li>
						<li><a href="locations">Locations</a></li>
						<li><a href="farmers">Farmers List</a></li>
						<li><a href="accounts">Accounts</a></li>
						<li><a href="logmeOut">Log Out</a></li>
					</ul>




				</div>
			</nav>

			<div class="container">
				<div style="margin-top:100px;">



					<table class="table table-condensed table-hover table-bordered">
						<thead>
							<tr>
								<th>Account ID</th>
								<th>Password (Encrypted)</th>
								<th>Account Name</th>
								<th>Account Type</th>
								<th></th>
							</tr>
						</thead>	

						<?PHP
		# Perform database query
						$query = "SELECT * FROM `users` WHERE usrid != ? ORDER BY `usrid` ASC";
						$result = $db->prepare($query);
						$result->execute(["root"]);



						foreach($result as $row) {

							echo '<tr>';
							echo '<td>'.$row['usrid'].'</td>';
							echo '<td>'.$row['pswd'].'</td>';
							echo '<td>'.$row['firstname']."\n".$row['surname'].'</td>';
							echo '<td>'.$row['actype'].'</td>';
							echo '<td><button type="submit" class="btn btn-danger btn-xs" name="btn_delete" data-id="'.$row['usrid'].'" data-toggle="modal" data-target="#delAccount"><span class="glyphicon glyphicon-trash"></span></button>';
							echo '</tr>';

						}


						?>



					</table>


				</div>
			</div>
		</body>
		</html>