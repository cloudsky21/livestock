<?PHP
session_start();
require_once("../connection/conn.php");
date_default_timezone_set('Asia/Manila');



$server = $_SERVER['SERVER_ADDR'];





if(isset($_POST['submiter']))
{
	
	$yearNow = date("Y");	
	$pattern = "^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$^";

//if(!preg_match($pattern, $_POST['rcv'])){
	$get_date = date("Y-m-d", strtotime($_POST['rcv']));
	
	if($get_date == '1970-01-01'){

		$get_date = date("Y-m-d");
	}
	
	else {$get_date = date("Y-m-d", strtotime($_POST['rcv']));}

//}	
	







	if($_POST['animal-type']=="Carabao-Breeder" || $_POST['animal-type']=="Carabao-Draft" || $_POST['animal-type']=="Carabao-Dairy" || $_POST['animal-type']=="Carabao-Fattener"){
		
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."WB-";
		
	}
	else if($_POST['animal-type']=="Cattle-Breeder" || $_POST['animal-type']=="Cattle-Draft" || $_POST['animal-type']=="Cattle-Dairy" || $_POST['animal-type']=="Cattle-Fattener"){

		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."CA-";
	}
	else if($_POST['animal-type']=="Horse-Breeder" || $_POST['animal-type']=="Horse-Draft" || $_POST['animal-type']=="Horse-Working"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."HO-";	
	}
	else if($_POST['animal-type']=="Swine-Breeder"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SB-";	
	}
	else if($_POST['animal-type']=="Swine-Fattener"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SF-";	
	}
	else if($_POST['animal-type']=="Poultry-Broilers"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PM-";	
	}
	else if($_POST['animal-type']=="Poultry-Layers" || $_POST['animal-type']=="Poultry-Pullets"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PE-";	
	}
	else if($_POST['animal-type']=="Goat-Breeder" || $_POST['animal-type']=="Goat-Fattener"){

		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."GO-";
	}
	$ids = "RO8-".date("Y")."-".date("m");

	$programcode = "APCP";
	$program = "APCP";

	$unwanted = array("&NTILDE;" => "Ñ");		
	$group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
	$assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
	$province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
	$town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted); 
	


	$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];

	$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
	$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));

	$result = $db->prepare("INSERT INTO controla (
		Year,
		date_r,
		program,
		groupName, 
		ids1, 
		idsprogram,
		lsp,
		province,
		town, 
		assured, 
		farmers, 
		heads, 
		animal, 
		premium,
		rate, 
		amount_cover, 
		Dfrom, 
		Dto,
		status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

	$result->execute([
		$yearNow, 
		$get_date, 
		$program, 
		$group, 
		$ids, 
		$programcode,
		$LSP, 
		$province,
		$town, 
		$assured, 
		$_POST['farmer-count'], 
		$_POST['head-count'],
		$_POST['animal-type'],
		$bpremium,
		$_POST['rate'],
		$_POST['cover'],
		$fromDate,
		$toDate,
		"active"]);

	$row=$result->rowCount();

	if($row=='1'){
		
		unset($_POST);
		header('Location: '.$_SERVER[REQUEST_URI]);	
		
	}

}
if(isset($_POST['submit_index_update'])){	
	if($_POST['animal-type']=="Carabao-Breeder" || $_POST['animal-type']=="Carabao-Draft" || $_POST['animal-type']=="Carabao-Dairy" || $_POST['animal-type']=="Carabao-Fattener"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."WB-";
	}
	else if($_POST['animal-type']=="Cattle-Breeder" || $_POST['animal-type']=="Cattle-Draft" || $_POST['animal-type']=="Cattle-Dairy" || $_POST['animal-type']=="Cattle-Fattener"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."CA-";
	}
	else if($_POST['animal-type']=="Horse-Breeder" || $_POST['animal-type']=="Horse-Draft" || $_POST['animal-type']=="Horse-Working"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."HO-";	
	}
	else if($_POST['animal-type']=="Swine-Breeder"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SB-";	
	}
	else if($_POST['animal-type']=="Swine-Fattener"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SF-";	
	}
	else if($_POST['animal-type']=="Sheep-Fattener" || $_POST['animal-type']=="Sheep-Breeder"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."SH-";	
	}
	else if($_POST['animal-type']=="Poultry-Broilers"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PM-";	
	}
	else if($_POST['animal-type']=="Poultry-Layers" || $_POST['animal-type']=="Poultry-Pullets"){
		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."PE-";	
	}
	else if($_POST['animal-type']=="Goat-Breeder" || $_POST['animal-type']=="Goat-Fattener" || $_POST['animal-type'] == "Goat-Milking"){

		$LSP = "LI-RO8-".substr($_SESSION['insurance'],-2)."-"."GO-";
	}		
	$rs = $db->prepare("UPDATE controla SET 
		groupName=?, assured=?,	province=?,	town=?,	farmers=?,heads=?,	animal=?,lsp=?,	premium=?,	rate=?,	amount_cover=?,	Dfrom=?,
		Dto=?,	status=?, lslb=? WHERE idsnumber=?");

	$unwanted = array("&NTILDE;" => "Ñ");		
	$group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
	$assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
	$province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
	$town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

	
	
	
	
	$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
	$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
	$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
	$rs->execute([
		$group, 
		$assured, 
		$province, 
		$town,
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

	if($row > 0){
		header('location: '.$_SERVER[REQUEST_URI]);
	}
}
?>
<!DOCTYPE html>
<html>
<head>

	<title>APCP | Livestock Control</title>
	
	<link rel="shortcut icon" href="../images/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" href="../resources/bootswatch/solar/bootstrap.css">
	<link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="../resources/css/local.css">
	<script src="../resources/bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="../resources/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script type = "text/javascript" language = "javascript">
		$(document).ready(function(){
			$('#infoModal').on('show.bs.modal', function (e) {
				var rowid = $(e.relatedTarget).data('id');

				$.ajax({
					type : 'post',
				url : '../bin/detailsapcp.php', //Here you will fetch records 
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
				url : 'updateapcp.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
			});
		});


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

		function find_ids($val){
			var xz = $val;

			$('#displaydata > tbody').empty();

			$.ajax({
				type: 'POST',
				url: 'searchapcp.php',
				data: 'ids='+ xz,
				success: function(e){
					$('#displaydata > tbody').html(e);
				}
			});

		}

	</script>
	<script>
		$(document).on('show.bs.modal', '.modal', function () {
			var zIndex = 1040 + (10 * $('.modal:visible').length);
			$(this).css('z-index', zIndex);
			setTimeout(function() {
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			}, 0);
		});	

		function getaddress($x){
			var i = $x;
			$('#town').empty();

			$.ajax({
				type : 'post',
				url : 'ajax_address.php', 
				data :  { id:i }, /*$('#farmersform').serialize(), */
				success : function(data){
					$('#town').html(data);

				}
			});


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

					<a class="navbar-brand" href="../home">Livestock Control</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-right">
						
						<li><a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i></a></li>
						<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i>
							<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="rsbsa">RSBSA</a></li>
								<li><a href="regular">Regular Program</a></li>
								<li class="active"><a href="#">APCP</a></li>
								<li><a href="acpc">Punla</a></li>
								<li><a href="#">AGRI-AGRA</a></li>
								<li><a href="#">SAAD</a></li>
							</ul>
						</li>
						<li class="navbar-form"><input type="text" id="srch" name="srch" class="form-control" placeholder="Search" oninput="find_ids(this.value);" ></li>	
						<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-gears"></span> <span class="caret"></span></a>
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
							
						</ul>								
					</li>    
					<li><a href="logmeOut"><i class="fa fa-sign-out"></i></a></li>  
				</ul>
						<!--
						<ul class="nav navbar-nav side-nav">
							<li>aaaaa</li>
							<li>aaaaa</li>

						</ul>				
					-->
				</div>
			</div> 
		</nav>


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



							<?php
							if($_SESSION['office']=="Regional Office") 
							{
								?>	
								<div class="form-group">
									<label for="address" class="control-label col-sm-3">Province</label>
									<div class="col-sm-9">
										<select id="province" name="province" placeholder="Leyte" class="form-control" tabindex="7" onchange="getaddress(this.value);">
											<option value="--">--</option>
											<option value="Leyte">LEYTE</option>
											<option value="Southern Leyte">SOUTHERN LEYTE</option>
											<option value="Biliran">BILIRAN</option>
											<option value="Northern Samar">NORTHERN SAMAR</option>
											<option value="Eastern Samar">EASTERN SAMAR</option>
											<option value="Western Samar">WESTERN SAMAR</option>
										</select>
									</div>
								</div>
								<?php
							}
							else
							{

								?>
								<div class="form-group">
									<label for="address" class="control-label col-sm-3">Province</label>
									<div class="col-sm-9">
										<select id="province" name="province" placeholder="Leyte" class="form-control" tabindex="7" onfocus="getaddress(this.value);">
											<?php echo '<option value="'.$_SESSION['office'].'" selected>'.$_SESSION['office'].'</option>'; ?>

										</select>
									</div>
								</div>
								<?php
							}
							?>


							<div class="form-group">
								<label for="address" class="control-label col-sm-3">Town</label>
								<div class="col-sm-9">
									<select id="town" name="town" class="form-control" tabindex="8">
										<option value=""></option>
									</select>

								</div>
							</div>

							<div class="form-group">
								<label for="farmer-count" class="control-label col-sm-3">Farmers</label>
								<div class="col-sm-9">
									<input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"  tabindex="9" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label for="head-count" class="control-label col-sm-3">Heads</label>
								<div class="col-sm-9">
									<input type="number" id="head-count" name="head-count" required min=0 step="any"  tabindex="10" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label for="animal-type" class="control-label col-sm-3">Kind of Animal: </label>
								<div class="col-sm-9">	
									<select name="animal-type" id="animal-type" onblur="getch(this.value);"  tabindex="11" class="form-control">
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
									<input type="number" min=0 step="any" name ="rate" id ="rate" required  placeholder="0.00"  tabindex="12" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label for="cover" class="control-label col-sm-3"><strong>Amount Cover</strong></label>
								<div class="col-sm-9">
									<input type="number" min=0 step="any" name="cover" id ="cover" required  placeholder="0.00"  tabindex="13" class="form-control">
								</div>
							</div>

							<div class="form-group">	
								<label for="datepicker1" class="control-label col-sm-3">Start of Cover</label>
								<div class="col-sm-9">
									<input type="date" name="effectivity-date"  tabindex="14" class="form-control" id="datepicker1">
								</div>
							</div>

							<div class="form-group">
								<label for="datepicker2" class="control-label col-sm-3">End of Cover</label>
								<div class="col-sm-9">
									<input type="date" name="expiry-date"  tabindex="15" class="form-control" id="datepicker2">	
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






		<div class="page-header" style="margin-top:100px;">


			<h2>APCP(Landbank)</h2>
		</div>

		<?PHP 
		$results_per_page = 10;

		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page = 1; };
		$start_from = ($page - 1) * $results_per_page;

		$rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM controla");
		$rs3->execute();
		foreach($rs3 as $row){
			$getcount = $row['total'];
		}
$total_pages = ceil(round($getcount) / $results_per_page); // calculate total pages with results
?>




<div class="span3">
	<div class="table-responsive">
		<div style="overflow-x:auto;">
			<span id="addfarmers"></span>

			<table class="table table-condensed table-hover" id="displaydata">

				<?PHP
				echo '<ul class="pagination pull-right">';

				if($page <=1){
					echo "<li class='disabled'><a href='#'>Previous</a></li>";
				}
				else echo "<li style='cursor:pointer'><a href='apcp?page=".($page-1)."'>Previous</a></li>";
					for ($x=max($page-5, 1); $x<=max(1, min($total_pages,$page+5)); $x++)
					{

						if($page == $x){ echo '<li class="active"><a href="apcp?page='.$x.'">'.$x.'</a></li>';} 
						else { echo '<li><a href="apcp?page='.($x).'">'.$x.'</a></li>';}
					}
					if($page < $total_pages){
						echo "<li style='cursor:pointer'><a href='apcp?page=".($page+1)."'>Next</a></li>";

					}
					else echo '<li class="disabled"><a href="#">Next</a></li>';
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

						$rs = $db->prepare("SELECT * FROM controla ORDER BY idsnumber DESC LIMIT ?, ?");
						$rs->execute([$start_from, $results_per_page]);

						foreach($rs as $row){
							
							if ($row['status'] =="active"){
								echo '<tr>';
								echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
								echo '<td style="word-wrap: break-word; min-width: 160px;max-width: 160px;">'.$row['groupName'].'</td>';
								echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
								echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
								echo '<td>'.$row['town'].', '.$row['province'].'</td>';
								echo '<td>'.$row['animal'].'</td>';
								
								if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policya.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
								if($server == "127.0.0.1"){	echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-edit"/></span></a></td>';		
								echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';} else {}
								
								echo '</tr>';
							}
							
							else if($row['status'] =="cancelled") {
								echo '<tr>';
								echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
								echo '<td style="word-wrap: break-word; min-width: 160px;max-width: 160px;">'.$row['groupName'].'</td>';
								echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
								echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
								echo '<td>'.$row['town'].', '.$row['province'].'</td>';
								echo '<td>'.$row['animal'].'</td>';
								if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policya.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
								if($server == "127.0.0.1"){	echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-edit"/></span></a></td>';		
								echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';} else {}
								
								echo '</tr>';
							}
						}
						?>




					</table>
				</div>
			</div>
		</body>

		</html>	
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