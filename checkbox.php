<?php 
session_start();
include ('mympdf.php');
require_once 'connection/conn.php';
date_default_timezone_set('Asia/Manila');
$vale = "";

if(!isset($_SESSION['isLogin']) || (!isset($_COOKIE["lx"]))) { header("location: logmeOut");}

if(isset($_POST['submit'])){


	
	if(isset($_POST['range'])){
	/*checkbox clicked*/
		$vale = "clicked";
		$getdate = date("Y-m-d", strtotime($_POST['date1']));

		checklist($getdate, $db);

	}
	else {

		$vale = "not clicked";
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Checklist | Livestock Control</title>	

	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="shortcut icon" href="images/favicon.ico">

	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="resources/bootstrap-3.3.7-dist/css/bootstrap.css">
	<link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="resources/css/local.css">
	<link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
	<script src="resources/bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="resources/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#range").click(function() {
				$("#date2").attr('disabled', !$("#date2").attr('disabled'));
			});
			
		});
	</script>

</head>
<body>
	<?php echo $vale ?>
	<div class="container">
		<div class="login col-centered">
			<h1 class="text-center">Checklist</h1>

			<form method="post" action="" target = "_blank">
				<ul class="list-group">

					<li class="list-group-item">
						<div class="checkbox">
							<label><input type="checkbox" id="range" name="range"> Disable/enable</label>
						</div></li>
						<li class="list-group-item">
							<div class="form-group">
								<label>FROM</label>
								<input type="date" name="date1" id="date1" class="form-control">
							</div></li>

							<li class="list-group-item">
								<div class="form-group">
									<label>TO</label>
									<input type="date" name="date2" id="date2" class="form-control disabled">
								</div></li>

								<li class="list-group-item">
									<input type="submit" name="submit" class="form-control btn-primary"  value="Submit">
								</li>

							</ul>

						</form>
					</div>
				</div>

			</body>
			</html>
