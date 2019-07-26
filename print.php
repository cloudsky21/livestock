<?PHP
session_start();
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');

?>

<html>

<head>

	<title>RSBA | Policy Printing</title>
	<link rel="stylesheet" type="text/css" href="css/css.css">
<style>
.sidenav {
    height: 100%; /* 100% Full-height */
    width: 0; /* 0 width - change this with JavaScript */
    position: fixed; /* Stay in place */
    z-index: 1; /* Stay on top */
    top: 0;
    left: 0;
    background-color: #005960; /* Black*/
    overflow-x: hidden; /* Disable horizontal scroll */
    padding-top: 220px; /* Place content 60px from the top */
    transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}
/* The navigation menu links */
.sidenav a {
    
	padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 20px;
    color: white;
    display: block;
    transition: 0.3s
}

/* When you mouse over the navigation links, change their color */
.sidenav a:hover, .offcanvas a:focus{
    color: #f1f1f1;
}

/* Position and style the close button (top right corner) */
.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

/* Style page content - use this if you want to push the page content to the right when you open the side navigation */
#main {
    transition: margin-left .5s;
    padding: 25px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}

</style>	
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



<div id="container">
<form method="POST" action="" autocomplete="off">
<table id="tbup">
<tr>
<td><label><strong>Programs</strong></label></td>

</tr>
<tr>
<td><select name="programs" onchange="location: this.value;">

	<option name="Regular" value="index.php">--</option>
	<option name="Regular" value="regular.php">Regular Program</option>
	<option name="RSBSA" value="rsbsa.php" selected="selected">RSBSA</option>
	<option name="APCP" value="apcp.php">APCP</option>
	
</select>
</td>
</tr>
	</table>
</form>
</div>

<div id="wrap-tbl">
<table id = "tbl">
	<tr>
	<th rowspan=2>Date Received</th>
	<th rowspan=2>Lending Institution</th>
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
	
<?PHP 
$rs = $db->prepare("SELECT * FROM control ORDER BY idsnumber DESC");
$rs->execute();

foreach($rs as $row){
	
	echo '<tr>';
		echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
		echo '<td>'.$row['groupName'].'</td>';
		echo '<td>'.$row['ids1'].'- <strong><a href="policy.php?ids='.$row['idsnumber'].'">'.sprintf("%04d", $row['idsnumber']).'</a></strong> '.$row['idsprogram'].'</td>';
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
</body>

</html>	