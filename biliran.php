<?PHP
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');

$success = '';
	

if(isset($_POST['submiter'])){
	
$yearNow = date("Y");	

	
	$getdate = date("Y-m-d", strtotime($_POST['rcv']));
	
	if($getdate == '1970-01-01'){

	$getdate = date("Y-m-d");
	}
	
	else {$getdate = date("Y-m-d", strtotime($_POST['rcv']));}




$ids = "RO8-".date("Y")."-".date("m");

if($_POST['animal-type']=="Carabao-Breeder" || $_POST['animal-type']=="Carabao-Draft" || $_POST['animal-type']=="Carabao-Dairy" || $_POST['animal-type']=="Carabao-Fattener"){
	
	$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."WB-";
	
}
else if($_POST['animal-type']=="Cattle-Breeder" || $_POST['animal-type']=="Cattle-Draft" || $_POST['animal-type']=="Cattle-Dairy" || $_POST['animal-type']=="Cattle-Fattener"){

$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."CA-";
}
else if($_POST['animal-type']=="Horse-Breeder" || $_POST['animal-type']=="Horse-Draft" || $_POST['animal-type']=="Horse-Working"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."HO-";	
}
else if($_POST['animal-type']=="Swine-Breeder"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."SB-";	
}
else if($_POST['animal-type']=="Swine-Fattener"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."SF-";	
}
else if($_POST['animal-type']=="Sheep-Fattener" || $_POST['animal-type']=="Sheep-Breeder"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."SH-";	
}
else if($_POST['animal-type']=="Poultry-Broilers"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."PM-";	
}
else if($_POST['animal-type']=="Poultry-Layers" || $_POST['animal-type']=="Poultry-Pullets"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."PE-";	
}
else if($_POST['animal-type']=="Goat-Breeder" || $_POST['animal-type']=="Goat-Fattener" || $_POST['animal-type'] == "Goat-Milking"){

$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."GO-";
}
$ids = "RO8-".date("Y")."-".date("m");
$program = "RSBSA";
$group = ucwords(htmlentities($_POST['group-name']));
$addresss = strtoupper(htmlentities($_POST['address']));
$assured = ucwords(htmlentities($_POST['assured-name']));

$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];

$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));


$result = $db->prepare("INSERT INTO control (
Year,
date_r,
program,
groupName,
ids1,
lsp,
address,
assured,
farmers,
heads,
animal,
premium,
amount_cover,
rate,
Dfrom,
Dto,
status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

$result->execute([
$yearNow,
$getdate,
$program,
$group,
$ids,
$LSP,
$addresss,
$assured,
$_POST['farmer-count'],
$_POST['head-count'],
$_POST['animal-type'],
$bpremium,
$_POST['cover'],
$_POST['rate'],
$fromDate,
$toDate,
"active"]);

$row=$result->rowCount();

if($row=='1'){
	
unset($_POST);
header('Location: '.$_SERVER['PHP_SELF']);	
exit();	
}

}




?>
<?PHP

if(isset($_GET['page']))
{
$pgnumber = $_GET['page'];


}
else{$pgnumber=1; 
}


?>

<?PHP 
$server = $_SERVER['SERVER_ADDR'];




?>


<?PHP

if(isset($_POST['submit_index_update'])){
	
	
if($_POST['animal-type']=="Carabao-Breeder" || $_POST['animal-type']=="Carabao-Draft" || $_POST['animal-type']=="Carabao-Dairy" || $_POST['animal-type']=="Carabao-Fattener"){
	
	$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."WB-";
	
}
else if($_POST['animal-type']=="Cattle-Breeder" || $_POST['animal-type']=="Cattle-Draft" || $_POST['animal-type']=="Cattle-Dairy" || $_POST['animal-type']=="Cattle-Fattener"){

$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."CA-";
}
else if($_POST['animal-type']=="Horse-Breeder" || $_POST['animal-type']=="Horse-Draft" || $_POST['animal-type']=="Horse-Working"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."HO-";	
}
else if($_POST['animal-type']=="Swine-Breeder"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."SB-";	
}
else if($_POST['animal-type']=="Swine-Fattener"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."SF-";	
}
else if($_POST['animal-type']=="Sheep-Fattener" || $_POST['animal-type']=="Sheep-Breeder"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."SH-";	
}
else if($_POST['animal-type']=="Poultry-Broilers"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."PM-";	
}
else if($_POST['animal-type']=="Poultry-Layers" || $_POST['animal-type']=="Poultry-Pullets"){
$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."PE-";	
}
else if($_POST['animal-type']=="Goat-Breeder" || $_POST['animal-type']=="Goat-Fattener" || $_POST['animal-type'] == "Goat-Milking"){

$LSP = "LI-RO8-".substr(date("Y"), -2)."-"."GO-";
}	
	
	
	
	
	
	
	$rs = $db->prepare("UPDATE control SET 
	groupName=?, 
	assured=?,
	address=?,
	farmers=?,
	heads=?,
	animal=?,
	lsp=?,
	premium=?,
	rate=?,
	amount_cover=?,
	Dfrom=?,
	Dto=?,
	status=?,
	lslb=? WHERE idsnumber=?");
	

	
$group = htmlentities($_POST['group-name']);
$addresss = strtoupper(htmlentities($_POST['address']));
$assured = strtoupper(htmlentities($_POST['assured-name']));

$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];

$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));








$rs->execute([
$group, 
$assured, 
$addresss, 
$_POST['farmer-count'], 
$_POST['head-count'], 
$_POST['animal-type'],
$LSP, 
$bpremium, 
$_POST['rate'],
$_POST['cover'],
$fromDate,
$toDate,
$_POST['stt'],
$_POST['lslb'],
$_POST['ids']]);	




	



$row=$rs->rowCount();

$getpage = "?page=".$pgnumber;


if($row=='1'){
	
unset($_POST);





$success = '<div class="alert alert-info alert-dismissable" id="flash-msg"><strong>Sucess!</strong></div>';

}
else $success = '<div class="alert alert-danger alert-dismissable" id="flash-msg">Record rejected for update.</div>';
}


	
	
?>
<?PHP
if(isset($_POST['delete_records'])){

$del =$_POST['recorded'];




$result = $db->prepare("DELETE FROM control WHERE idsnumber = ?");
$result->execute([$del]);

$result = $db->prepare("ALTER TABLE control AUTO_INCREMENT=1");
$result->execute();



//header("location: ".$_SERVER['PHP_SELF']);
}




?>



<!DOCTYPE html>
<html>

<head>

	<title>RSBSA | Livestock Control</title>
	
	<meta charset="utf8">
	<link rel="shortcut icon" href="favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="bootstrap/3.3.7-dist/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<script type = "text/javascript" language = "javascript">
	$(document).ready(function(){
		$('#infoModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
	
		$.ajax({
				type : 'post',
				url : 'details.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
		});
	});

	$(document).ready(function(){	 
		$('#editModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
										
		$.ajax({
				type : 'post',
				url : 'update.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
		});
	});

	$(document).ready(function(){	 
		$('#deleteModal').on('show.bs.modal', function (e) {
			var rowid = $(e.relatedTarget).data('id');
										
		$.ajax({
				type : 'post',
				url : 'delete.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
		});
	});


	window.onload = function() {
		var input = document.getElementById("group-name").focus();
	}


	function getch($val){
		if ($val == "Carabao-Draft" || $val == "Carabao-Breeder" || $val == "Carabao-Dairy" || $val == "Carabao-Fattener") {
			$('#rate').val('6.75');
		}
			else if ($val == "Cattle-Draft" || $val == "Cattle-Breeder" || $val == "Cattle-Dairy" || $val == "Cattle-Fattener"){
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
								else if ($val == "Goat-Milking"){	
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

	$(document).ready(function(){
		$('.dropdown-toggle').dropdown()
	});	
										
	$(document).ready(function () {
		$("#flash-msg").delay(3000).fadeOut("slow");
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
   
      <a class="navbar-brand" href="javascript(void);" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">Add Animal</a>
    </div>
	<div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
      <li><a href="edit.php"><span class="glyphicon glyphicon-pencil"></span>  Edit</a></li>
      <li><a href="count.php">Count</a></li>
     </ul>
	<form method="post" action="search.php" class="navbar-form navbar-right" target="_blank">
	 <div class="form-group">

<select name="programs" onchange="location = this.value;" class="form-control">

	<option name="Regular" value="index.php">--</option>
	<option name="Regular" value="indexR.php">Regular Program</option>
	<option name="RSBSA" value="index.php" selected="selected">RSBSA</option>
	<option name="APCP" value="apcp.php">APCP</option>
	
</select>
</div>
<div class="form-group">

<select name="address" onchange="location = this.value;" class="form-control">
	<option value="index.php">---</option>
	<option value="biliran.php" selected>Biliran</option>
	<option value="ws.php">Western Samar</option>
	<option value="ns.php">Northern Samar</option>
	<option value="es.php">Eastern Samar</option>
	<option value="1-2.php">Leyte 1 & 2</option>
	<option value="3-4.php">Leyte 3 & 4</option>
	<option value="5.php">Leyte 5</option>
	<option value="sl.php">Southern Leyte</option>
</select>
</div>
		<div class="input-group">
		
		<input type="text" name="srch" class="form-control" >
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

 

<?PHP 
$results_per_page = 100;

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page = 1; };
$start_from = ($page - 1) * $results_per_page;

$rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM control WHERE address LIKE ?");
$rs3->execute(['%biliran%']);
foreach($rs3 as $row){
$getcount = $row['total'];
}
$total_pages = ceil(round($getcount) / $results_per_page); // calculate total pages with results
?>




<div class="span3">
<div class="table-responsive">
<div style="overflow-x:auto;">
<table class="table table-condensed table-hover table-striped">

<?PHP
echo '<ul class="pager">';
if($page <=1){
echo "<li></li>";
}
else echo "<li class='previous' style='cursor:pointer'><a href='biliran.php?page=".($page-1)."' class='pager'>Previous</a></li>";

if($page < $total_pages){
echo "<li class='next' style='cursor:pointer'><a href='biliran.php?page=".($page+1)."' class='pager'>Next</a></li>";
}
else {};
echo '</ul>';




?>
<thead>
	<tr>
	<th>Date Received</th>
	<th>Lending Institution</th>
	<th>Livestock Policy Number</th>
	<th>Name Of Farmers / Assured</th>
	<th>Address</th>
	<th>Kind of Animal</th>
	<th>&nbsp;</th>
	</tr>
		
</thead>
<tbody>	





<?PHP

	$rs = $db->prepare("SELECT * FROM control WHERE address LIKE ? ORDER BY idsnumber DESC LIMIT ?, ?");
	$rs->execute(["%biliran%",$start_from, $results_per_page]);

		foreach($rs as $row){
	
			if ($row['status'] =="active"){
				echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td><a class="btn btn-default btn-xs" href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></a></td>';
					echo '<td>'.$row['assured'].'</td>';
					echo '<td>'.$row['address'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
				
						if (!$row['lslb']=="0") { echo '<td><a class="btn btn-success btn-xs" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-success btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
						if($server == "127.0.0.1"){	echo '<td><a class="btn btn-warning btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-pencil"/></span></a></td>';		
							 echo '<td><a class="btn btn-danger btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';} else {}
		
				echo '</tr>';
			}
			
			else if($row['status'] =="cancelled") {
				echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td><a class="btn btn-warning btn-xs" href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></a></td>';
					echo '<td>'.$row['assured'].'</td>';
					echo '<td>'.$row['address'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-success btn-xs" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-success btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
						if($server == "127.0.0.1"){	echo '<td><a class="btn btn-warning btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-pencil"/></span></a></td>';		
							 echo '<td><a class="btn btn-danger btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';} else {}
		
				echo '</tr>';
			}
		}
?>


</tbody>
</table>
</div>
</div>	
</div>
</div>
<div class="modal fade" id="deleteModal" role="dialog">
	<div class="modal-dialog">
	
		<div class="modal-content">
		
			<div class="modal-header">
			
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Delete Record</h4>
				
			</div>
			
			<div class="modal-body">
				<div class="fetched-data">


				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
			</div>
		
		</div>
	</div>
</div>

<div class="modal fade" id="editModal" role="dialog">
	<div class="modal-dialog">
	
		<div class="modal-content">
		 <form method="post" action="" class="form-horizontal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Details</h4>
			</div>
			
			<div class="modal-body">
				<div class="fetched-data">


				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" name="submit_index_update">Save Changes</button>
			</div>
		 </form>
		</div>
	</div>
</div>








<div class="modal fade" id="infoModal" role="dialog">
	<div class="modal-dialog" role="document">
	
		<div class="modal-content">
		
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Livestock Details</h4>
			</div>
			
			<div class="modal-body">
				<div class="fetched-data">


				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		
		</div>
	</div>
</div>










<!-- Modal -->

		<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Add Insurance</h4>
								</div>
									<div class="modal-body">
										<form method="POST" action="" class="form-horizontal">
											<div class="form-group">
													<label for="rcv" class="control-label col-sm-3">Received Date (optional):</label>
														<div class="col-sm-9">
														<input id="rcv" type="date" name="rcv" tabindex="1" class="form-control">
														</div>
											</div>	

											<div class="form-group">
													<label for="group-name" class="control-label col-sm-3">Group Name</label>
														<div class="col-sm-9">
															<input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al." required maxlength="200"  tabindex="5" class="form-control" autofocus>
															</div>	
											</div>	

											<div class="form-group">
													<label for="assured-name" class="control-label col-sm-3">Name of Assured</label>
														<div class="col-sm-9">
															<input type="text" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200"  tabindex="6" class="form-control">
															</div>
											</div>
											
											

											<div class="form-group">
													<label for="address" class="control-label col-sm-3">Address</label>
														<div class="col-sm-9">
															<input type="text" id="address" name="address" placeholder="Abuyog, Leyte" required maxlength="200"  tabindex="7"  class="form-control">
															</div>
											</div>

											<div class="form-group">
													<label for="farmer-count" class="control-label col-sm-3">Farmers</label>
														<div class="col-sm-9">
															<input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"  tabindex="8" class="form-control">
															</div>
											</div>

											<div class="form-group">
													<label for="head-count" class="control-label col-sm-3">Heads</label>
														<div class="col-sm-9">
															<input type="number" id="head-count" name="head-count" required min=0 step="any"  tabindex="9" class="form-control">
															</div>
											</div>

											<div class="form-group">
													<label for="animal-type" class="control-label col-sm-3">Kind of Animal: </label>
														<div class="col-sm-9">	
															<select name="animal-type" id="animal-type" onblur="getch(this.value);"  tabindex="10" class="form-control">
																<option name="animal" value="---------">&nbsp;</option>
																<option name="animal" value="Carabao-Breeder">Carabao Breeder</option>
																<option name="animal" value="Carabao-Draft">Carabao Draft</option>
																<option name="animal" value="Carabao-Dairy">Carabao Dairy</option>
																<option name="animal" value="Carabao-Fattener">Carabao Fattener</option>
																<option name="animal" value="Cattle-Breeder">Cattle Breeder</option>
																<option name="animal" value="Cattle-Draft">Cattle Draft</option>
																<option name="animal" value="Cattle-Dairy">Cattle Dairy</option>
																<option name="animal" value="Cattle-Fattener">Cattle Fattener</option>
																<option name="animal" value="Horse-Draft">Horse Draft</option>
																<option name="animal" value="Horse-Working">Horse Working</option>
																<option name="animal" value="Horse-Breeder">Horse Breeder</option>
																<option name="animal" value="Swine-Fattener">Swine Fattener</option>
																<option name="animal" value="Swine-Breeder">Swine Breeder</option>
																<option name="animal" value="Goat-Fattener">Goat Fattener</option>
																<option name="animal" value="Goat-Breeder">Goat Breeder</option>
																<option name="animal" value="Goat-Milking">Goat Milking</option>
																<option name="animal" value="Sheep-Fattener">Sheep Fattener</option>
																<option name="animal" value="Sheep-Breeder">Sheep Breeder</option>
																<option name="animal" value="Poultry-Broilers">Poultry-Broilers</option>
																<option name="animal" value="Poultry-Pullets">Poultry-Pullets</option>
																<option name="animal" value="Poultry-Layers">Poultry-Layers</option>
															</select>
														</div>
											</div>	
												
											<div class="form-group">		
													<label for="rate" class="control-label col-sm-3">Premium Rate</label>
															<div class="col-sm-9">
																<input type="number" min=0 step="any" name ="rate" id ="rate" required  placeholder="0.00"  tabindex="11" class="form-control">
																</div>
											</div>

											<div class="form-group">
													<label for="cover" class="control-label col-sm-3"><strong>Amount Cover</strong></label>
															<div class="col-sm-9">
																<input type="number" min=0 step="any" name="cover" id ="cover" required  placeholder="0.00"  tabindex="12" class="form-control">
																</div>
											</div>

											<div class="form-group">	
													<label for="datepicker1" class="control-label col-sm-3">Start of Cover</label>
															<div class="col-sm-9">
																<input type="date" name="effectivity-date"  tabindex="13" class="form-control" id="datepicker1">
																</div>
											</div>

											<div class="form-group">
													<label for="datepicker2" class="control-label col-sm-3">End of Cover</label>
															<div class="col-sm-9">
																<input type="date" name="expiry-date"  tabindex="14" class="form-control" id="datepicker2">	
															</div>
											</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" class="btn btn-primary" tabindex="15" name="submiter">Submit</button>
										</form>
									</div>
							</div>
					</div>
				</div>
</body>

</html>	