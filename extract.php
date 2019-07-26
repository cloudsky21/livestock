<?php
session_start();

require "connection/conn.php";
require 'myload.php';
date_default_timezone_set('Asia/Manila');


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Extraction | Livestock Control</title>	

	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="shortcut icon" href="images/favicon.ico">

	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css">
	<link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="resources/css/local.css">
	<link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
	<link rel="stylesheet" href="resources/jquery-ui-1.12.1.custom/jquery-ui.css">
	<script src="resources/bootstrap-4/js/jquery.js"></script>
	<script src="resources/bootstrap-4/umd/js/popper.js"></script>
	<script src="resources/bootstrap-4/js/bootstrap.js"></script>
	<script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
	
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h5 class="display-3">Extract Policies</h5>
			<hr>
		</div>
		<form method="post" action="extractPDF" target="_blank">
			<div class="form-group">
				<div class="login col-centered">			
					<table class="table table-condensed table-sm">						
						<tr>
							<th scope="row">Office</th>
							<td>
								<select name="office" class="form-control form-control-sm">
									<option value="PEO Tacloban" selected>Tacloban Extension</option>
									<option value="PEO Biliran">Biliran Extension</option>
									<option value="PEO Ormoc">Ormoc Extension</option>
									<option value="PEO Abuyog">Abuyog Extension</option>
									<option value="PEO Hilongos">Hilongos Extension</option>
									<option value="PEO Sogod">Sogod Extension</option>
									<option value="PEO W-Samar">Western Samar Extension</option>
									<option value="PEO E-Samar">Eastern Samar Extension</option>
									<option value="PEO N-Samar">Northern Samar Extension</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">FROM</th>
							<td>
								<input type="date" name="date_from" class="form-control form-control-sm" min="<?php echo $_SESSION['insurance']; ?>-01-01" max="<?php echo date("Y-m-d"); ?>" required>
							</td>
						</tr>
						<tr>
							<th scope="row">TO</th>
							<td>
								<input type="date" name="date_to" class="form-control form-control-sm" min="<?php echo $_SESSION['insurance']; ?>-01-01" max="<?php echo date("Y-m-d"); ?>" required>
							</td>
						</tr>					
					</table>		
					<input type="submit" name="submit" value="Extract" class="form-control btn btn-primary">
				</div>
			</div>
		</form>
	</div>
</body>
</html>