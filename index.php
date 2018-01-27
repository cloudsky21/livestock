<?PHP
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');


if(isset($_COOKIE["lx"]) && isset($_COOKIE["lp"]) && isset($_COOKIE["rrrrassdawds"])){
	
	$result = $db->prepare("SELECT * FROM users WHERE usrid = ? && pswd = ?");
	$result->execute([$_COOKIE["lx"],$_COOKIE["lp"]]);
	$count = $result->rowCount();
	
	if($count > 0){
		

		
		foreach($result as $row){


			$name_account = $row['firstname'].' '.$row['middlename'].' '.$row['surname'];
			$id = $row['usrid'];
			$stat = $row['actype'];
			$officeDes = $row['office'];

		}
		
		
		$_SESSION['isLogin'] = 1;
		$_SESSION['isLoginID'] = $id;
		$_SESSION['isLoginName'] = $name_account;
		$_SESSION['office'] = $officeDes;
		$_SESSION['stat'] = $stat;
		$_SESSION['insurance'] = $_COOKIE['rrrrassdawds'];
		
		
		
		header("location: home");
		
	}
	
	
	
}
else if(isset($_SESSION['isLogin'])){

	/*Set Cookie*/
	$cookie_name = "lx";
	$cookie_value = $_SESSION['xValue'];
	$cookie_p = $_SESSION['pValue'];
	$cookie_rrs = $_SESSION['insurance'];



	setcookie($cookie_name, $cookie_value,  time()+86400);
	setcookie("lp", $cookie_p,  time()+86400);
	setcookie("rrrrassdawds", $cookie_rrs,  time()+86400);



	header("location: home");

}



?>


<?PHP
if($_SERVER["REQUEST_METHOD"]=="POST"){

	/*Converts to Code*/
	$userid = htmlentities($_POST['name'],ENT_QUOTES);

	/*Encrypts Password*/
	$userpas = sha1($_POST['password']);
	
	/*Checks if Year is not null*/
	

	if(!empty($_POST['i_year'])){
		$_SESSION['insurance'] = $_POST['i_year'];
	}
	
	
	/*Checks username and password in database*/
	$result = $db->prepare("SELECT * FROM users WHERE usrid = ? && pswd = ? LIMIT 1");
	$result->execute([$userid, $userpas]);

	if($result->rowcount() > 0) {
		
		
		
		foreach($result as $row){


			$name_account = $row['firstname'].' '.$row['middlename'].' '.$row['surname'];
			$id = $row['usrid'];
			$stat = $row['actype'];
			$officeDes = $row['office'];
			
		}

		$_SESSION['office'] = $officeDes;
		$_SESSION['isLogin'] = 1;
		$_SESSION['isLoginID'] = $id;
		$_SESSION['stat'] = $stat;
		$_SESSION['isLoginName'] = $name_account;

		

		/*Set Cookie*/
		$cookie_name = "lx";
		$cookie_value = $userid;
		$cookie_p = $userpas;
		$cookie_rrs = $_SESSION['insurance'];
		
		
		$_SESSION['xValue'] = $userid;
		$_SESSION['pValue'] = $cookie_p;
		setcookie($cookie_name, $cookie_value,  time()+86400);
		setcookie("lp", $cookie_p,  time()+86400);
		setcookie("rrrrassdawds", $cookie_rrs,  time()+86400);
		
		
		
		//header("location: home");
	}
	

	else
	{
		
		$get_result = '<div id="flash-msg" class="alert alert-danger">Account Not Found!</div>';
		echo sha1('chen');
		unset($_POST);
	}
	

}
?>


<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Livestock | Control System</title>
	<link rel="shortcut icon" href="images/favicon.ico"/>
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function () {
			$("#flash-msg").delay(3000).fadeOut("slow");
		});	
	</script>
</head>


<body>
	<div class="container">
		<div class="login col-centered">
			<?php if($_SERVER["REQUEST_METHOD"]=="POST"){ echo $get_result;} ?>
			<form action="" Method="POST" class="form-horizontal" role="form"> 
				<div class="form-group">
					<label for="usr" class="control-label col-sm-2">Username:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="usr" name="name" required placeholder="Username">
					</div>
				</div>					
				<div class="form-group">
					<label for="pwd" class="control-label col-sm-2">Password:</label>
					<div class="col-sm-10">
						<input type="password" id="pwd" name="password" class="form-control" required placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<label for="i_year" class="control-label col-sm-2 color">Year:</label>
					<div class="col-sm-10">
						<select id="i_year" name="i_year" class="form-control">
							<?php
							$sql = "SELECT year FROM year GROUP BY year ASC";
							$result = $db->prepare($sql);
							$result->execute();
							while($sqlrow = $result->fetch(PDO::FETCH_ASSOC))
								{
									echo "<option name ='myYear' value='{$sqlrow['year']}' selected = 'selected'";			
									echo ">{$sqlrow['year']}</option>";
								}
								?>
							</select>
						</div>
					</div>



					<button type="submit" class="btn btn-primary btn-large form-control" name="letmein">Let me in.</button>
				</form>

			</div>
		</div>
	</body>
	</html>
	
	