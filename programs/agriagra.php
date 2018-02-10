<?PHP
session_start();
require_once("../connection/conn.php");
include '../bin/class/rsbsaClass.php';
date_default_timezone_set('Asia/Manila');

$agri_agra = new Rsbsa();

if(!isset($_SESSION['isLogin']) || (!isset($_COOKIE["lx"]))) { header("location: logmeOut");}

	if(isset($_COOKIE['rrrrassdawds'])){	
		$table = "agriagra".$_COOKIE['rrrrassdawds'];	
	}
	else
	{
		header("location: logmeOut");
		exit();
	}
	if(isset($_POST['submiter'])){
		$yearNow = date("Y");	
		$getdate = date("Y-m-d", strtotime($_POST['rcv']));

		if($getdate == '1970-01-01'){
			$getdate = date("Y-m-d");
		}
		else {$getdate = date("Y-m-d", strtotime($_POST['rcv']));}

		$ids = "RO8-".date("Y")."-".date("m");
		
		$LSP = $agri_agra->lsp($_POST['animal-type']);
		$program = "AGRI-AGRA";

		$unwanted = array("&NTILDE;" => "Ñ");		
		$group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
		$iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)),$unwanted);
		$prepared = mb_strtoupper($_SESSION['isLoginName']);
		$assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
		$province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
		$town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

		
		
		$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
		$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
		$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
		$prem_loading = $_POST['prem_loading'];
		$prem_loading = htmlentities(implode(',', $prem_loading), ENT_QUOTES);

		
		//check office_assignment
		$office_assignment = $agri_agra->office_assignment($province,$town);
		

		$columns = array("Year","date_r","program","groupName","ids1","lsp","province","town","assured","farmers","heads","animal","premium","amount_cover","rate","Dfrom","Dto","status","office_assignment","loading","iu","prepared");
		$values = array($yearNow,$getdate,$program,$group,$ids,$LSP,$province,$town,$assured,$_POST['farmer-count'],
			$_POST['head-count'],$_POST['animal-type'],$bpremium,$_POST['cover'],$_POST['rate'],$fromDate,$toDate,"active",
			$office_assignment,$prem_loading,$iu,$prepared);
		$placeholders = substr(str_repeat('?,', sizeOf($columns)), 0, -1);


		$result = $db->prepare(
			sprintf(
				"INSERT INTO %s (%s) VALUES (%s)", 
				$table, 
				implode(',', $columns), 
				$placeholders
			)
		);

		$result->execute($values);

		if($result->rowCount()>0){
			header('Location: '.$_SERVER[REQUEST_URI]);	
			
		}
	}

	if(isset($_POST['submit_index_update'])){
// Update application form pdf
		if ($_FILES["fileUpload"]["type"] == "application/pdf" && $_FILES['fileUpload']['size'] != 0)
		{
  //do the error checking and upload if the check comes back OK
			switch ($_FILES['fileUpload'] ['error'])
			{  case 1:
				print '<p> The file is bigger than this PHP installation allows</p>';
				break;
				case 2:
				print '<p> The file is bigger than this form allows</p>';
				break;
				case 3:
				print '<p> Only part of the file was uploaded</p>';
				break;
				case 4:
				print '<p> No file was uploaded</p>';
				break;
			}

			$temp = explode(".",$_FILES['fileUpload']['name']);
			$newfilename = $_POST['ids'].'RSBSA'.'.'.end($temp);
			move_uploaded_file($_FILES["fileUpload"]["tmp_name"],
				"../uploads/RSBSA/".$_SESSION['insurance'].'/' . $newfilename);


			$path = "../uploads/RSBSA/".$_SESSION['insurance'].'/'.$newfilename;
			$result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
			$result->execute([$path,$_POST['ids']]);


		}
		else
		{
			echo "Files must be PDF or empty";
		}





		$LSP = $agri_agra->lsp($_POST['animal-type']);		




		$rs = $db->prepare("UPDATE $table SET 
			groupName=?, assured=?,	province=?,	town=?,	farmers=?,heads=?,	animal=?,lsp=?,	premium=?,	rate=?,	amount_cover=?,	Dfrom=?,
			Dto=?,	status=?, lslb=?, office_assignment = ?, loading = ?, iu=?, prepared=? WHERE idsnumber=?");

		$unwanted = array("&NTILDE;" => "Ñ");		
		$group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
		$iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)),$unwanted);
		$prepared = mb_strtoupper($_SESSION['isLoginName']);
		$assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
		$province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
		$town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

		
		//check office_assignment
		$office_assignment = $agri_agra->office_assignment($province,$town);

		$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
		$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
		$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
		$prem_loading = mb_strtoupper(htmlentities($_POST['loading']), 'UTF-8');

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
			$office_assignment,
			$prem_loading,
			$iu,
			$prepared,
			$_POST['ids']]);	
		

		if($rs->rowCount() > 0){
			header('location: '.$_SERVER[REQUEST_URI]);
		}



	}


	if(isset($_POST['delete_records'])){
		$del =$_POST['recorded'];
		$result = $db->prepare("DELETE FROM $table WHERE idsnumber = ?");
		$result->execute([$del]);
		$result = $db->prepare("ALTER TABLE $table AUTO_INCREMENT=1");
		$result->execute();
		header("location: ".$_SERVER[REQUEST_URI]);
	}
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>RSBSA | Livestock Control</title>	
		
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link rel="shortcut icon" href="../images/favicon.ico">

		<meta name="viewport" content="width=device-width, initial-scale=1">


		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../resources/bootswatch/sandstone/bootstrap.css">
		<link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="../resources/css/local.css">
		<link rel="stylesheet" href="../resources/multi-select/bootstrap-multiselect.css">
		<script src="../resources/bootstrap-4/js/jquery.js"></script>
		<script src="../resources/bootstrap-4/umd/js/popper.js"></script>
		<script src="../resources/bootstrap-4/js/bootstrap.js"></script>
		<script type="text/javascript" src="../resources/multi-select/bootstrap-multiselect.js"></script>
		<script type = "text/javascript" language = "javascript">
			$(document).ready(function(){
				$('#infoModal').on('show.bs.modal', function (e) {
					var rowid = $(e.relatedTarget).data('id');
					$.ajax({
						type : 'post',
				url : '../bin/details/details_agri.php', //Here you will fetch records 
				data :  'rowid='+ rowid, //Pass $id
				success : function(data){
					$('.fetched-data').html(data);//Show fetched data from database
				}
			});
				});
			});

			function address($val){
				$('#town').empty();
				var dropselect = $val;

				$.ajax({
					type: "POST",
					url: "selects.php",
					data: { 'id': dropselect  },
					success: function(data){
						$("#townbrgy").html(data); 
					}
				});
			}
			$(document).keypress(function(evt){
				if (evt.keyCode=="96"){
					$('#myModal').modal('show');
					$('#group-name').focus();

				}

			});
			$(document).ready(function(){	 
				$('#editModal').on('show.bs.modal', function (e) {
					var rowid = $(e.relatedTarget).data('id');

					$.ajax({
						type : 'post',
				url : '../bin/update/update_agri.php', //Here you will fetch records 
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
				url : '../bin/delete_agri.php', //Here you will fetch records 
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
				$('#submiter').button();

				$('#submiter').click(function(){

					$('#submiter').button('loading');

					/* perform processing then reset button when done */
					setTimeout(function() {
						$('#submiter').button('reset');
					}, 1000);

				});
			});	
			$(document).ready(function(){
				$('.dropdown-toggle').dropdown()
			});	

			$(document).ready(function () {
				$("#flash-msg").delay(3000).fadeOut("slow");
			});	

			$(document).ready(function(){
				$('[data-toggle="popover"]').popover({
					container: 'body'
				});
			});
			$(document).ready(function(){  

				$('.ajax_link').popover({  
					title:fetchData,  
					html:true,  
					placement:'right'  
				});  
				function fetchData(){  
					var fetch_data = '';  
					var element = $(this);  
					var id = element.attr("id");  
					$.ajax({  
						url:"ajax.php",  
						method:"POST",  
						async:false,  
						data:{id:id},  
						success:function(data){  
							fetch_data = data;  
						}  
					});  
					return fetch_data;  
				}  
			});  
		</script>
		<script>
			$(document).on('show.bs.modal', '.modal', function () {
				var zIndex = 1040 + (10 * $('.modal:visible').length);
				$(this).css('z-index', zIndex);
				setTimeout(function() {
					$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
				}, 0);
			});	

			function insertData() {
				var ids = $('#ids').val();
				var sn = $('#lname').val();
				var fn = $('#fname').val();
				var mn = $('#mname').val();
				var bd = $('#bday').val();
				var adr = $('#address').val();

				$.ajax({
					url: "insertfarmer.php",
					type:"POST",
					data:
					{
						'ids': ids,
						'snn': sn,
						'fnn': fn,
						'mnn': mn,
						'bdd': bd,
						'adres': adr
					},
					dataType: "JSON",
					success: function(sd) {
						console.log(sd); 
					},
					error: function(err) {
						alert(err); 
					}
				});



			}


			function typeAnimal($val){
				$('#purpose').empty();

				if($val == "Carabao" || $val == "Cattle")
				{

					var items = [ 

					{ "value": 'Breeder', "text": 'Breeder' },
					{ "value": 'Fattener', "text": 'Fattener' },
					{ "value": 'Draft', "text": 'Draft' },
					{ "value": 'Dairy', "text": 'Dairy' }

					]; 	


					$.each(items, function (i, item) {
						$('#purpose').append($('<option>', { 
							value: item.value,
							text : item.text 
						}));
					});




				}

				else if($val == "Horse")
				{

					var items = [ 


					{ "value": 'Draft', "text": 'Draft' }

					]; 	


					$.each(items, function (i, item) {
						$('#purpose').append($('<option>', { 
							value: item.value,
							text : item.text 
						}));
					});


				}

				else if($val == "Goat" || $val == "Sheep")
				{

					var items = [ 


					{ "value": 'Breeder', "text": 'Breeder' },
					{ "value": 'Fattener', "text": 'Fattener' },
					{ "value": 'Dairy', "text": 'Dairy' }

					]; 	


					$.each(items, function (i, item) {
						$('#purpose').append($('<option>', { 
							value: item.value,
							text : item.text 
						}));
					});


				}

				else if($val == "Swine")
				{

					var items = [ 


					{ "value": 'Breeder', "text": 'Breeder' },
					{ "value": 'Fattener', "text": 'Fattener' }

					]; 	


					$.each(items, function (i, item) {
						$('#purpose').append($('<option>', { 
							value: item.value,
							text : item.text 
						}));
					});


				}

				else if($val == "Poultry")
				{

					var items = [ 


					{ "value": 'Broilers', "text": 'Broilers' },
					{ "value": 'Layers', "text": 'Layers' },
					{ "value": 'Pullets', "text": 'Pullets' }

					]; 	


					$.each(items, function (i, item) {
						$('#purpose').append($('<option>', { 
							value: item.value,
							text : item.text 
						}));
					});


				}

			}


		</script>
		<script>
			function getaddress($x){
				var i = $x;
				$('#town').empty();

				$.ajax({
					type : 'post',
					url : '../ajax_address.php', 
					data :  { id:i }, /*$('#farmersform').serialize(), */
					success : function(data){
						$('#town').html(data);


					}
				});


			}	



			function find_ids($val){
				var xz = $val;

				$('#displaydata > tbody').empty();

				$.ajax({
					type: 'POST',
					url: '../search.php',
					data: 'ids='+ xz,
					success: function(e){
						$('#displaydata > tbody').html(e);

					},
					error: function(d){
						alert("ERROR: " + d);
					}
				});

			}

			
		</script>	
		<script>
			$(document).ready(function() {
				$('#prem_loading').multiselect({
					nonSelectedText: 'Additional Premium Loading',
					enableFiltering: true,
					includeSelectAllOption: true,
					maxHeight: 400,
					dropUp: true	
				});
			});

		</script>

	</head>

	<body>

		<div class="container-fluid">


			<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
				<!-- Brand -->
				<div class="container">
					<a class="navbar-brand" href="../home">
						Livestock Control</a>

						<!-- Toggler/collapsibe Button -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
							<span class="navbar-toggler-icon"></span>
						</button>

						<!-- Navbar links -->
						<div class="collapse navbar-collapse" id="collapsibleNavbar">

							<ul class="navbar-nav mr-auto">

								<li class="nav-item">
									<a class="nav-link" href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i></a>
								</li>
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
										Programs
									</a>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="rsbsa">RSBSA</a>
										<a class="dropdown-item" href="regular">Regular Program</a>
										<a class="dropdown-item" href="apcp">APCP</a>
										<a class="dropdown-item" href="acpc">Punla</a>
										<a class="dropdown-item" href="agriagra">AGRI-AGRA</a>
										<a class="dropdown-item" href="#">SAAD</a>
									</div>
								</li>

								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
										<span class="fa fa-gears" style="font-size:15px"></span>
									</a>
									<div class="dropdown-menu">

										<?php 
										if($_SESSION['stat']=="Admin") { ?>
										<a class="dropdown-item" href="year">Insurance Year</a>

										<a class="dropdown-item" href="farmers">Farmers List</a>
										<a class="dropdown-item" href="accounts">Accounts</a>
										<a class="dropdown-item" href="../checkbox" target="_blank">Checklist</a>
										<?php 
									}
									?>
									<a class="dropdown-item" href="comments">Comments</a>
									<a class="dropdown-item" href="../locations">Locations</a>
								</div>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="../logmeOut"><i class="fa fa-sign-out" style="font-size:15px"></i></a></li>  
							</ul>

							<form class="form-inline my-2 my-lg-0">
								<input type="text" id="srch" name="srch" class="form-control" placeholder="Search" oninput="find_ids(this.value);" >							
							</form>

						</div>
					</div>
				</nav> 

				<div class="page-header" style="margin-top:150px;">


					<h2>AGRI-AGRA</h2>
				</div>

				<?PHP 
				$results_per_page = 25;

				if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page = 1; };
				$start_from = ($page - 1) * $results_per_page;

				if($_SESSION['office']=="Regional Office") 
				{
					$rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table");
					$rs3->execute();
				}
				else
				{
					$rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table WHERE office_assignment = ?");
					$rs3->execute([$_SESSION['office']]);	
				}
				foreach($rs3 as $row){
					$getcount = $row['total'];
				}
				// calculate total pages with results
				$total_pages = ceil(round($getcount) / $results_per_page); 
				?>




				<div class="table-responsive">
					<div style="overflow-x:auto;">
						<span id="addfarmers"></span>
						<?PHP

						echo '<ul class="pagination pull-right">';

						if($page <=1){
							echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
						}
						else echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='rsbsa?page=".($page-1)."'>Previous</a></li>";
							for ($x=max($page-5, 1); $x<=max(1, min($total_pages,$page+5)); $x++)
							{

								if($page == $x){ echo '<li class="page-item active"><a class="page-link" href="rsbsa?page='.$x.'">'.$x.'</a></li>';} 
								else { echo '<li class="page-item"><a class="page-link" href="rsbsa?page='.($x).'">'.$x.'</a></li>';}
							}
							if($page < $total_pages){
								echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='rsbsa?page=".($page+1)."'>Next</a></li>";

							}
							else echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
							echo '</ul>';




							?>
							<form method="post" action="../printbatchProcessingslipAGRI" target="_blank">
								<table class="table table-hover table-striped" id="displaydata">


									<thead>
										<tr>
											<th><input type="submit" class="btn btn-outline-primary btn-sm" name="printBtn" value="print"></th>
											<th>Date Received</th>
											<th>Livestock Policy Number</th>
											<th>Name Of Farmers / Assured</th>

											<th>Address</th>
											<th>Kind of Animal</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
											<th>&nbsp;</th>
										</tr>

									</thead>
									<tbody>	





										<?PHP

										if($_SESSION['office']=="Regional Office") 	 
										{
											$rs = $db->prepare("SELECT * FROM $table ORDER BY idsnumber DESC LIMIT ?, ?");
											$rs->execute([$start_from, $results_per_page]);
										}
										else
										{
											$rs = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? ORDER BY idsnumber DESC LIMIT ?, ?");
											$rs->execute([$_SESSION['office'], $start_from, $results_per_page]);	
										}



										foreach($rs as $row){

											if ($row['status'] =="active"){
												echo '<tr>';
												echo '<td><input type="checkbox" name="chkPrint[]" value="'.$row['idsnumber'].'"></td>';
												echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
												echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
												echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
												echo '<td>'.$row['town'].', '.$row['province'].'</td>';
												echo '<td>'.$row['animal'].'</td>';

												if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="../policy/policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
												echo '<td><a class="btn btn-outline-primary btn-sm" href="../processingslip?ids='.$row['idsnumber'].'AGRI" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
												echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';		
												echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';

												echo '</tr>';
											}

											else if($row['status'] =="cancelled") {
												echo '<tr>';
												echo '<td><input type="checkbox" name="chkPrint[]" value="'.$row['idsnumber'].'"></td>';
												echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
												echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
												echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
												echo '<td>'.$row['town'].', '.$row['province'].'</td>';
												echo '<td>'.$row['animal'].'</td>';
												if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
												echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';		
												echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';

												echo '</tr>';
											}
										}
										?>


									</tbody>
								</table>
							</form>
						</div>
					</div>	
				</div>
			</div>

			<div class="modal fade" id="deleteModal">
				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">
							<h4 class="modal-title">Delete Record</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>


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

			<div class="modal fade" id="editModal">
				<div class="modal-dialog">

					<div class="modal-content">
						<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
							<div class="modal-header">
								<h4 class="modal-title">Edit Details</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>

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
							<h4 class="modal-title">Livestock Details</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>

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


			<div class="modal fade" id="ids" role="dialog">
				<div class="modal-dialog" role="document">

					<div class="modal-content">
						<form method="post" id="farmersform">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">ADD FARMERS</h4>
							</div>

							<div class="modal-body">

								<table class="table borderless" id="farmeradd">
									<tbody>
										<tr>
											<td style="border: none;"><label for="frmrid">Farmer ID:</label></td>
											<td style="border: none;" colspan="3"><input type="number" class="form-control" name="frmrid" id="frmrid" placeholder="436158"></td>
										</tr>
										<tr>	
											<td style="border: none;"><label for="agem">Age(M)</label></td>
											<td style="border: none;"><input type="text" class="form-control" name="agem" id="agem" placeholder="3 Yrs Old"></td>
											<td style="border: none;"><label for="hdsm">Heads</label></td>
											<td style="border: none;"><input type="number" class="form-control" name="hdsm" id="hdsm" step="any" min="0" placeholder="0"></td>
										</tr>

										<tr>	
											<td style="border: none;"><label for="agef">Age(F)</label></td>
											<td style="border: none;"><input type="text" class="form-control" name="agef" id="agef" placeholder="3 Yrs Old"></td>
											<td style="border: none;"><label for="hdsf">Heads</label></td>
											<td style="border: none;"><input type="number" class="form-control" name="hdsf" id="hdsf"  step="any" min="0" placeholder="0"></td>
										</tr>

										<tr>
											<td style="border: none;"><label for="breed">Brand / Breed</label></td>
											<td style="border: none;" colspan="3"><input type="text" class="form-control" name="breed" id="breed" placeholder="Native"></td>
										</tr>

										<tr>
											<td style="border: none;"><label for="tagn">Ear Tag No.</label></td>
											<td style="border: none;" colspan="3"><input type="text" class="form-control" name="tagn" id="tagn"></td>
										</tr>

										<tr>
											<td style="border: none;"><label for="certt">Certificate No.</label></td>
											<td style="border: none;" colspan="3"><input type="number" class="form-control" name="certt" id="certt" step="any" min="0"></td>
										</tr>
										<tr>
											<td style="border: none;"><label for="aCover">Amount Cover</label></td>
											<td style="border: none;" colspan="3"><input type="number" class="form-control" name="aCover" id="aCover" step="any" min="0"></td>
										</tr>
										<tr>
											<td style="border: none;"><label for="apremium">Premium</label></td>
											<td style="border: none;" colspan="3"><input type="number" class="form-control" name="apremium" id="apremium" step="any" min="0"></td>
										</tr>

									</table>





								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary" name="submitfrmrs" id="submitfrmrs" onclick="verifyFarmers();">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>







				<!-- Modal -->

				<!-- Modal -->
				<div class="modal fade" id="myModal">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Add Insurance</h4>
								<button type="button" class="close" data-dismiss="modal">&times;</button>

							</div>
							<div class="modal-body">
								<form method="POST" action="" autocomplete="false">
									<div class="form-group">
										<label for="rcv">Received Date (optional):</label>

										<input id="rcv" type="date" name="rcv" tabindex="1" class="form-control">

									</div>	

									<div class="form-group">
										<label for="group-name">Group Name</label>

										<input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al." required maxlength="200"  tabindex="2" class="form-control" autofocus>

									</div>	

									<div class="form-group">
										<label for="assured-name">Name of Assured</label>

										<input type="text" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200"  tabindex="3" class="form-control">

									</div>


									<?php
									if($_SESSION['office']=="Regional Office") 
									{
										?>	
										<div class="form-group">
											<label for="address">Province</label>

											<select id="province" name="province" placeholder="Leyte" class="form-control" tabindex="4" onchange="getaddress(this.value);">
												<option value="--">--</option>
												<option value="Leyte">LEYTE</option>
												<option value="Southern Leyte">SOUTHERN LEYTE</option>
												<option value="Biliran">BILIRAN</option>
												<option value="Northern Samar">NORTHERN SAMAR</option>
												<option value="Eastern Samar">EASTERN SAMAR</option>
												<option value="Western Samar">WESTERN SAMAR</option>
											</select>

										</div>
										<?php
									}
									else
									{

										?>
										<div class="form-group">
											<label for="address">Province</label>

											<select id="province" name="province" placeholder="Leyte" class="form-control" tabindex="4" onfocus="getaddress(this.value);">
												<?php 
												$result = $db->prepare("SELECT province FROM location WHERE office = ? LIMIT 1");
												$result->execute([$_SESSION['office']]);
												foreach($result as $row){

													echo '<option value="'.$row['province'].'" selected>'.$row['province'].'</option>'; 
												} 

												?>

											</select>

										</div>
										<?php
									}
									?>


									<div class="form-group">
										<label for="address">Town</label>

										<select id="town" name="town" class="form-control" tabindex="5">
											<option value=""></option>
										</select>


									</div>

									<div class="form-group">
										<label for="farmer-count">Farmers</label>

										<input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"  tabindex="6" class="form-control">

									</div>

									<div class="form-group">
										<label for="head-count">Heads</label>

										<input type="number" id="head-count" name="head-count" required min=0 step="any"  tabindex="7" class="form-control">

									</div>

									<div class="form-group">
										<label for="animal-type">Kind of Animal: </label>

										<select name="animal-type" id="animal-type" onblur="getch(this.value);"  tabindex="8" class="form-control">
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

									<div class="form-group">		
										<label for="rate">Premium Rate</label>

										<input type="number" min=0 step="any" name ="rate" id ="rate" required  placeholder="0.00"  tabindex="9" class="form-control">

									</div>

									<div class="form-group">
										<label for="cover">Amount Cover</label>

										<input type="number" min=0 step="any" name="cover" id ="cover" required  placeholder="0.00"  tabindex="10" class="form-control">

									</div>

									<div class="form-group">	
										<label for="datepicker1">Start of Cover</label>

										<input type="date" name="effectivity-date"  tabindex="11" class="form-control" id="datepicker1">

									</div>

									<div class="form-group">
										<label for="datepicker2">End of Cover</label>

										<input type="date" name="expiry-date"  tabindex="12" class="form-control" id="datepicker2">	

									</div>

									<div class="form-group">
										<label for="loading">Premium Loading</label>

										<select id="prem_loading" name="prem_loading[]" multiple>
											<?php
											$result = $db->prepare("SELECT premium_loading,percentage FROM premload_list ORDER BY prem_id DESC");
											$result->execute();

											foreach($result as $row)
											{

												echo '<option value="'.$row['premium_loading'].'-'.$row['percentage'].'">'.$row['premium_loading'].' - '.$row['percentage'].'</option>';
											}

											?>

										</select>

									</div>
									<div class="form-group">
										<label for="iu">IU/Solicitor</label>

										<input type="text" name="iu" id ="iu" tabindex="14" class="form-control">

									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="submit" id="submiter" class="btn btn-primary" tabindex="14" name="submiter" data-loading-text="Adding Data..">Submit</button>
								</form>
							</div>
						</div>
					</div>
				</div>







			</body>

			</html>	