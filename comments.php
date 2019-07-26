<?php
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');

if(!isset($_SESSION['isLogin']) || (!isset($_COOKIE["lx"]))) { header("location: logmeOut");}

	if(isset($_COOKIE['rrrrassdawds'])){	
		$table = "control".$_COOKIE['rrrrassdawds'];	
	}
	else
	{
		header("location: logmeOut");
		exit();
	}


	?>

	<?php

	if($_SERVER['REQUEST_METHOD'] == "POST"){


		$message = ucwords(htmlentities($_POST['msgbox']));
		$user = $_SESSION['isLoginID'];
		$time = date("Y-m-d H:i:s");


		$result = $db->prepare("INSERT INTO comments (message,user,time) VALUES(?,?,?)");
		$result->execute([$message,$user,$time]);

		header('location:'.$_SERVER[REQUEST_URI]);
	}


	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>COMMENTS | Livestock Control</title>	
		
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link rel="shortcut icon" href="images/favicon.ico">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="bootswatch/solar/bootstrap.min.css">
		<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
		<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function(){
				$("#msgbox").keypress(function (e) {
					if(e.which == 13 && !e.shiftKey) {        
						$(this).closest("form").submit();
						e.preventDefault();
						return false;
					}
				});
			});
		</script>
	</head>
	<body>
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
								?>
								<li><a href="comments">Comments</a></li>
								<li><a href="locations">Locations</a></li>
								<li><a href="logmeOut">Log Out</a></li>
							</ul>
						</li>      
					</ul>				
				</div>
			</div> 
		</nav>
		<div style="margin-top: 100px">
			
				<form method="post" action="" class="form-horizontal" id="message">
					<div class="form-group">
						<label for="message" class="control-label col-xs-3">Message</label>
						<div class="col-xs-9">
							<textarea class="form-control" name="msgbox" id="msgbox" maxlength="2000"></textarea> <br>	

						</div>

					</form>
					<?PHP 
			$results_per_page = 15;

			if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page = 1; };
			$start_from = ($page - 1) * $results_per_page;

				$rs3 = $db->prepare("SELECT COUNT(message) AS total FROM comments");
				$rs3->execute();	
		
			foreach($rs3 as $row){
				$getcount = $row['total'];
			}
				// calculate total pages with results
			$total_pages = ceil(round($getcount) / $results_per_page); 
		

			echo '<ul class="pagination">';

			if($page <=1){
				echo "<li class='disabled'><a href='#'>Previous</a></li>";
			}
			else echo "<li style='cursor:pointer'><a href='comments?page=".($page-1)."'>Previous</a></li>";
				for ($x=max($page-5, 1); $x<=max(1, min($total_pages,$page+5)); $x++)
				{

					if($page == $x){ echo '<li class="active"><a href="comments?page='.$x.'">'.$x.'</a></li>';} 
					else { echo '<li><a href="comments?page='.($x).'">'.$x.'</a></li>';}
				}
				if($page < $total_pages){
					echo "<li style='cursor:pointer'><a href='comments?page=".($page+1)."'>Next</a></li>";

				}
				else echo '<li class="disabled"><a href="#">Next</a></li>';
				echo '</ul>';




				?>
					<table class="table">
						<thead>
							<tr>
								<th>USER</th>
								<th>MESSAGE</th>
								<th>TIME</th>
							</tr>

						</thead>

						<?php

						$result = $db->prepare("
							SELECT * FROM comments 
							INNER JOIN users 
							ON users.usrid = comments.user 
							ORDER BY time DESC LIMIT ?, ?
							");
						$result->execute([$start_from, $results_per_page]);

						foreach ($result as $row)
						{

							echo '<tr>';
							echo '<td><strong>'.$row['firstname'].'</strong></td>';
							echo '<td>'.$row['message'].'</td>';
							echo '<td>'.$row['time'].'</td>';
							echo '</tr>';
						}

						?>

					</table>
				</div>
			</div>
		</body>
		</html>