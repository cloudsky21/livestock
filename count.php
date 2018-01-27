<?PHP
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>COUNT | Livestock</title>
	<meta charset="utf8">
	<link rel="shortcut icon" href="favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
   
      <a class="navbar-brand" href="javascript(void);" data-toggle="modal" data-target="#myModal">Add Animal</a>
    </div>
	<div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
       <li class="active"><a href="count.php">Count</a></li>
     </ul>
	<form method="post" action="search.php" class="navbar-form navbar-right">
	 <div class="form-group">
		<select name="programs" onchange="location = this.value;" class="form-control">
			
			<option name="Regular" value="index.php">--</option>
			<option name="Regular" value="countR.php">Regular Program</option>
			<option name="RSBSA" value="count.php" selected="selected">RSBSA</option>
			<option name="APCP" value="apcp.php">APCP</option>
	
		</select>
	</div>
		
	 
	 
	 
	 </form> 
  </div>
 </div> 
</nav>




<div class="container-fluid">
<div id="tbl-wrap">
	<form method="POST" action="">
		
				<div class="form-group row">
					<div class="col-xs-3">
						<label for="datepicker">Date FROM:</label>
						<input type="date" name="datepicker" id="datepicker" class="form-control">
					</div>	
					
				
				
					<div class="col-xs-3">
						<label for="datepicker2">Date TO:</label>
						<input type="date" name="datepicker2" id="datepicker2" class="form-control">
					</div>
				
				</div>	
					
					<button type="submit" name="submit" class="btn btn-default">Submit</button>
					
		
	</form>
</div>
	
<div id="tbl-wrap">	
<div class="table-responsive">	
	<table class="table table-hover table-condensed">
	
		<thead>
			<tr>
				<th>Farmer Count</th>
				<th>Head Count</th>
				<th>Total IDS</th>
			</tr>	
		</thead>
		<tbody>
<?PHP

		if($_SERVER["REQUEST_METHOD"]=="POST"){

			$yearfrom = date("Y-m-d", strtotime($_POST['datepicker']));
			$yearto = date("Y-m-d", strtotime($_POST['datepicker2']));

				$result = $db->prepare("SELECT sum(farmers), sum(heads), COUNT(idsnumber) FROM control2017 WHERE date_r BETWEEN ? AND ?");
				$result->execute([$yearfrom, $yearto]);

					foreach($result as $row){
	
					echo '<tr>';
						echo '<td>'.$row['sum(farmers)'].'</td>';
						echo '<td>'.$row['sum(heads)'].'</td>';
						echo '<td>'.$row['COUNT(idsnumber)'].'</td>';
					echo '</tr>';
	
											}





												}

?>
		</tbody>
	</table>
</div>
</div>
</div>
</body>
</html>	
