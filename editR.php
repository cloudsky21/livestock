<?PHP
session_start();
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');

if($_SERVER["REQUEST_METHOD"]=="POST"){
	
$yearNow = date("Y");	

if (strtotime($_POST['rcv']) != '0000-00-00'){

$get_date = date("Y-m-d", strtotime($_POST['rcv']));


}
else {
$get_date = date("Y-m-d");
	
}

//$ids = "RO8-".date("Y")."-".date("m");
$ids = "RO8-".date("Y")."- 02";
$programcode = "PPPP";
$program = "RSBSA";
$group = htmlentities($_POST['group-name']);
$addresss = htmlentities($_POST['address']);
$assured = htmlentities($_POST['assured-name']);

$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];

$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));

$result = $db->prepare("INSERT INTO controlr (
Year,
date_r,
program,
groupName, 
ids1, 
idsprogram,
address, 
assured, 
farmers, 
heads, 
animal, 
premium,
rate, 
amount_cover, 
Dfrom, 
Dto) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$result->execute([$yearNow, $get_date, 
$program, 
$group, 
$ids, 
$programcode, 
$addresss, 
$assured, 
$_POST['farmer-count'], 
$_POST['head-count'],
$_POST['animal-type'],
$bpremium,
$_POST['rate'],
$_POST['cover'],
$fromDate,
$toDate]);

$row=$result->rowCount();

if($row=='1'){
	
unset($_POST);
header('Location: '.$_SERVER['PHP_SELF']);	
	
}



}

	
	
	
	




?>
<!DOCTYPE html>
<html lang="en">

<head>

	<title>Edit Regular | Livestock Control</title>
	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script src="js/jquery-1.7.2.js" type="text/javascript"></script>
	<script src="js/jquery-1.9.1.min" type="text/javascript"></script>
	<script type = "text/javascript" language = "javascript">

$(document).ready(function() {
            
		$("#hide").click(function(){
        $("#tbup").hide();
		$("#wrap-tbl").style.marginTop = "0";
		});
		$("#show").click(function(){
	    $("#tbup").show();
		$("#wrap-tbl").style.marginTop = "430px";
    
	});
    });
	
	
	
function getch($val){
 if ($val == "Carabao-Draft" || $val == "Carabao-Breeder" || $val == "Carabao-Dairy" || $val == "Carabao-Fattener") {
	$('#rate').val('6.75');
 }
	else if ($val == "Cattle-Draft" || $val == "Cattle-Breeder" || $val == "Catte-Dairy" || $val == "Catte-Fattener"){
	$('#rate').val('6.75');	
	}
	else if ($val == "Horse-Draft" || $val == "Horse-Breeder" || $val == "Horse-Working"){	
	$('#rate').val('6.75');	
	}
	else if ($val == "Swine-Breeder"){	
	$('#rate').val('7');	
	}
	else if ($val == "Swine-Fattener"){	
	$('#rate').val('4');	
	}
	else if ($val == "Goat-Fattener"){	
	$('#rate').val('10');	
	}
	else if ($val == "Goat-Breeder"){	
	$('#rate').val('10');	
	}
	else if ($val == "Sheep-Fattener"){	
	$('#rate').val('10');	
	}
	else if ($val == "Sheep-Breeder"){	
	$('#rate').val('10');	
	}
	else if ($val == "Poultry-Layers"){	
	$('#rate').val('2.54');	
	}
	else if ($val == "Poultry-Pullets"){	
	$('#rate').val('2.54');	
	}
	else {
	$('#rate').val('0.00');	
	}
 }
 
	
</script>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
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
   
      <a class="navbar-brand" href="javascript(void);" data-toggle="modal" data-target="#myModal">Add Animal</a>
    </div>
	<div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
      <li class="active"><a href="editR.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
      <li><a href="countR.php">Count</a></li>
     </ul>
	<form method="post" action="search.php" class="navbar-form navbar-right">
	 <div class="form-group">

<select name="programs" onchange="location = this.value;" class="form-control">

	<option name="Regular" value="index.php">--</option>
	<option name="Regular" value="editR.php" selected="selected">Regular Program</option>
	<option name="RSBSA" value="edit.php">RSBSA</option>
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




<span class="span3">
<div id = "tbl-wrap">
<div class="table-responsive">
<table class = "table table-condensed table-hover">
<thead>
	<tr>
	<th rowspan=2>Date Received</th>
	<th rowspan=2>Lending Institution</th>
	<th rowspan=2>Logbook No.</th>
	<th rowspan=2>IDS <br> Number</th>
	<th rowspan=2>Status</th>
	<th>Name Of</th>
	<th rowspan=2>Address</th>
	<th rowspan=2>Kind of <br> Animal</th>
	<th rowspan=2>Basic <br> Premium</th>
	<th colspan=2>Number OF</th>
	<th rowspan=2>Amount Cover</th>
	<th rowspan=2>Premium Rate</th>
	<th colspan=2>Date Of Effectivity</th>
	</tr>
	
	<tr>
		<th>Assured / Coop</th>
		<th>Farmers</th>
		<th>Heads</th>
		<th>FROM</th>
		<th>TO</th>
	</tr>
</thead>	
<?PHP 
$rs = $db->prepare("SELECT * FROM controlr ORDER BY idsnumber DESC");
$rs->execute();

foreach($rs as $row){
	
	echo '<tr>';
		echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
		echo '<td>'.$row['groupName'].'</td>';
		echo '<td style="text-align: center;">'.$row['lslb'].'</td>';
		echo '<td>'.$row['ids1'].'- <strong><a href="updater.php?ids='.$row['idsnumber'].'">'.sprintf("%04d", $row['idsnumber']).'</a></strong> </td>';
		echo '<td>'.$row['status'].'</td>';
		echo '<td>'.$row['assured'].'</td>';
		echo '<td>'.$row['address'].'</td>';
		echo '<td>'.$row['animal'].'</td>';
		echo '<td>'.number_format($row['premium'],2).'</td>';
		echo '<td>'.$row['farmers'].'</td>';
		echo '<td>'.$row['heads'].'</td>';
		echo '<td>'.number_format($row['amount_cover'],2).'</td>';
		echo '<td>'.$row['rate'].'</td>';
		echo '<td>'.date("m/d/Y", strtotime($row['Dfrom'])).'</td>';
		echo '<td>'.date("m/d/Y", strtotime($row['Dto'])).'</td>';
	echo '</tr>';
	
}



?>



	
</table>
</div>
</div>
</div>
</span>
</body>

</html>	