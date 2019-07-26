<?PHP
session_start();
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');

?>
<!DOCTYPE html>
<html>

<head>

	<title>Edit RSBA | Livestock Control</title>
	<meta charset="utf8">
	<link rel="shortcut icon" href="favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
  <script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
  <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	
	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	

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
<!--
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="index.php">Add livestock</a>
 
 
  
 </div>
<div id="main">
<span style="font-size:20px;cursor:pointer" onclick="openNav()">&#9776; Settings</span></div>

<div id="toggle-wrap">
<button id="hide">Hide</button>
<button id="show">Show</button>
</div>


-->
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
      <li class="active"><a href="edit.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
      <li><a href="count.php">Count</a></li>
     </ul>
	<form method="post" action="search.php" class="navbar-form navbar-right">
	 <div class="form-group">
		<select name="programs" onchange="location = this.value;" class="form-control">
			
			<option name="Regular" value="index.php">--</option>
			<option name="Regular" value="editR.php">Regular Program</option>
			<option name="RSBSA" value="edit.php" selected="selected">RSBSA</option>
			<option name="APCP" value="apcp.php">APCP</option>
	
		</select>
</div>
		<div class="input-group">
		
		<input type="text" name="srch" class="form-control" placeholder="Search">
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


<div class="tbl-wrap">

<table class = "table table-hover">
	<thead>
	<tr>
	<th rowspan=2><p class="text-center">Date Received</p></th>
	<th rowspan=2><p class="text-center">Lending Institution</p></th>
	<th rowspan=2><p class="text-center">Logbook No.</p></th>
	<th rowspan=2><p class="text-center">Livestock Policy</p></th>
	<th rowspan=2><p class="text-center">Status</p></th>
	<th><p class="text-center">Name Of</p></th>
	<th rowspan=2><p class="text-center">Address</p></th>
	<th rowspan=2><p class="text-center">Kind of <br> Animal</p></th>
	<th rowspan=2><p class="text-center">Basic <br> Premium</p></th>
	<th colspan=2><p class="text-center">Number OF</p></th>
	<th rowspan=2><p class="text-center">Amount Cover</p></th>
	<th rowspan=2><p class="text-center">Premium Rate</p></th>
	<th colspan=2><p class="text-center">Date Of Effectivity</p></th>
	
	</tr>

	<tr>
		<th><p class="text-center">Assured / Coop</p></th>
		<th><p class="text-center">Farmers</p></th>
		<th><p class="text-center">Heads</p></th>
		<th><p class="text-center">FROM</p></th>
		<th><p class="text-center">TO</p></th>
	</tr>

</thead>
<tbody>	
<?PHP 
$rs = $db->prepare("SELECT * FROM control ORDER BY idsnumber DESC");
$rs->execute();

foreach($rs as $row){
	
	echo '<tr>';
		echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
		echo '<td>'.$row['groupName'].'</td>';
		echo '<td style="text-align: center;">'.$row['lslb'].'</td>';
		echo '<td>'.$row['ids1'].'- <strong><a href="update.php?ids='.$row['idsnumber'].'">'.sprintf("%04d", $row['idsnumber']).'</a></strong> '.$row['idsprogram'].'</td>';
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


</tbody>
	
</table>


</div>
</div>
</body>

</html>	