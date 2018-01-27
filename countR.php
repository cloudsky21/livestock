<?PHP
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>COUNT Regular | Livestock</title>
	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
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
   
      <a class="navbar-brand" href="javascript(void);">Add Animal</a>
    </div>
	<div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li><a href="indexR.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
      <li><a href="editR.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
      <li class="active"><a href="countR.php">Count</a></li>
     </ul>
	<form method="post" action="search.php" class="navbar-form navbar-right">
	 <div class="form-group">

<select name="programs" onchange="location = this.value;" class="form-control">

	<option name="Regular" value="index.php">--</option>
	<option name="Regular" value="countR.php" selected="selected">Regular Program</option>
	<option name="RSBSA" value="count.php">RSBSA</option>
	<option name="APCP" value="apcp.php">APCP</option>
	
</select>
</div>
		<div class="input-group">
		
		<input type="text" name="srch" class="form-control">
			<div class="input-group-btn">
				<button class="btn btn-default" type="submit" name="searchbtn">
					<i class="glyphicon glyphicon-search"></i>
				 </button>
			</div>	
		</div>
	 
	 
	 
	 </form> 
  </div>
 </div> 
</nav>


<div id="tbl-wrap">
<form method="POST" action="">

	<div class="form-group row">
	<div class="col-xs-3">
	<label for="datepicker">Date:</label>
	<input type="date" name="datepicker" id="datepicker" class="form-control"><br>
	<button type="submit" class="btn btn-default">Submit</button>
	</div>
</form>
</div>

<div id="tbl-wrap" class="table-responsive">
<table class="table table-condensed table-hover">
<thead>
<tr>
	<th>Farmer Count</th>
	<th>Head Count</th>
	<th>Total IDS</th>
</thead>	
<?PHP
if($_SERVER["REQUEST_METHOD"]=="POST"){

$year = date("Y-m-d", strtotime($_POST['datepicker']));


$result = $db->prepare("SELECT sum(farmers), sum(heads), COUNT(idsnumber) FROM controlr WHERE date_r = ?");
$result->execute([$year]);

foreach($result as $row){
	
	echo '<tr>';
	echo '<td>'.$row['sum(farmers)'].'</td>';
	echo '<td>'.$row['sum(heads)'].'</td>';
	echo '<td>'.$row['COUNT(idsnumber)'].'</td>';
	echo '</tr>';
	
}

}

?>
</table>
</div>
</div>
</body>
</html>	
