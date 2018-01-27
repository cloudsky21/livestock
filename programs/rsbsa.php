<?PHP
session_start();
require_once("../connection/conn.php");
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
	if(isset($_POST['submiter'])){
		$yearNow = date("Y");	
		$getdate = date("Y-m-d", strtotime($_POST['rcv']));
		if($getdate == '1970-01-01'){
			$getdate = date("Y-m-d");
		}
		else {$getdate = date("Y-m-d", strtotime($_POST['rcv']));}
		$ids = "RO8-".date("Y")."-".date("m");
		if($_POST['animal-type']=="Carabao-Breeder" || $_POST['animal-type']=="Carabao-Draft" || $_POST['animal-type']=="Carabao-Dairy" || $_POST['animal-type']=="Carabao-Fattener"){
			$LSP = "LI-RO8-".substr($_SESSION['insurance'], -2)."-"."WB-";
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
		$ids = "RO8-".date("Y")."-".date("m");
		$program = "RSBSA";

		$unwanted = array("&NTILDE;" => "Ñ");		
		$group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
		$iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)),$unwanted);
		$prepared = mb_strtoupper($_SESSION['isLoginName']);
		$assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
		$province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
		$town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

		
		$barangay = strtr(mb_strtoupper(htmlentities($_POST['barangay'], ENT_QUOTES)), $unwanted);
		$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
		$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
		$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
		$prem_loading = $_POST['prem_loading'];
		$prem_loading = htmlentities(implode(',', $prem_loading), ENT_QUOTES);

		//check office_assignment
		if($province == "BILIRAN")
		{
			$office_assignment = "PEO Biliran";
		}
		elseif ($province == "LEYTE") {
			// Check if what district
			switch ($town) {
				case 'TACLOBAN CITY':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'ALANGALANG':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'BABATNGON':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'PALO':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'SAN MIGUEL':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'SANTA FE':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'STA. FE':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TANAUAN':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TOLOSA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'BARUGO':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'BURAUEN':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'CAPOOCAN':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'CARIGARA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'DAGAMI':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'DULAG':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'JARO':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'JULITA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'LA PAZ':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'PASTRANA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TABONTABON':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TUNGA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'CALUBIAN':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'LEYTE':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'SAN ISIDRO':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'TABANGO':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'VILLABA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'ORMOC CITY':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'ALBUERA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'ISABEL':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'KANANGA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'MATAG-OB':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'MERIDA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'PALOMPON':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'BAYBAY CITY':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'ABUYOG':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'BATO':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'HILONGOS':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'HINDANG':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'INOPACAN':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'JAVIER':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'MAHAPLAG':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'MATALOM':
					# code...
				$office_assignment = "PEO Abuyog";
				break;
				
			}
		}
		elseif($province == "NORTHERN SAMAR")
		{
			$office_assignment = "PEO N-Samar";
		}
		elseif($province == "WESTERN SAMAR")
		{
			$office_assignment = "PEO W-Samar";
		}
		elseif($province == "EASTERN SAMAR")
		{
			$office_assignment = "PEO E-Samar";
		}
		else
		{
			$office_assignment = "PEO Sogod";
		}


		$result = $db->prepare("INSERT INTO $table (
			Year,
			date_r,
			program,
			groupName,
			ids1,
			lsp,
			province,
			town,
			barangay,
			assured,
			farmers,
			heads,
			animal,
			premium,
			amount_cover,
			rate,
			Dfrom,
			Dto,
			status,
			office_assignment,
			loading,
			iu,
			prepared) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$result->execute([
			$yearNow,
			$getdate,
			$program,
			$group,
			$ids,
			$LSP,
			$province,
			$town,
			$barangay,
			$assured,
			$_POST['farmer-count'],
			$_POST['head-count'],
			$_POST['animal-type'],
			$bpremium,
			$_POST['cover'],
			$_POST['rate'],
			$fromDate,
			$toDate,
			"active",
			$office_assignment,
			$prem_loading,
			$iu,
			$prepared]);
		$row=$result->rowCount();
		if($row=='1'){
			unset($_POST);
			header('Location: '.$_SERVER[REQUEST_URI]);	
			exit();	
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
				"../L/uploads/RSBSA/".$_SESSION['insurance'].'/' . $newfilename);


			$path = "../L/uploads/RSBSA/".$_SESSION['insurance'].'/'.$newfilename;
			$result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
			$result->execute([$path,$_POST['ids']]);


		}
		else
		{
			echo "Files must be PDF or empty";
		}





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
		if($province == "BILIRAN")
		{
			$office_assignment = "PEO Biliran";
		}
		elseif ($province == "LEYTE") {
			// Check if what district
			switch ($town) {
				case 'TACLOBAN CITY':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'ALANGALANG':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'BABATNGON':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'PALO':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'SAN MIGUEL':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'SANTA FE':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'STA. FE':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TANAUAN':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TOLOSA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'BARUGO':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'BURAUEN':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'CAPOOCAN':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'CARIGARA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'DAGAMI':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'DULAG':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'JARO':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'JULITA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'LA PAZ':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'PASTRANA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TABONTABON':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'TUNGA':
					# code...
				$office_assignment = "Leyte1-2";
				break;

				case 'CALUBIAN':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'LEYTE':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'SAN ISIDRO':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'TABANGO':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'VILLABA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'ORMOC CITY':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'ALBUERA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'ISABEL':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'KANANGA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'MATAG-OB':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'MERIDA':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'PALOMPON':
					# code...
				$office_assignment = "PEO Ormoc";
				break;

				case 'BAYBAY CITY':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'ABUYOG':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'BATO':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'HILONGOS':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'HINDANG':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'INOPACAN':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'JAVIER':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'MAHAPLAG':
					# code...
				$office_assignment = "PEO Abuyog";
				break;

				case 'MATALOM':
					# code...
				$office_assignment = "PEO Abuyog";
				break;
				
			}
		}
		elseif($province == "NORTHERN SAMAR")
		{
			$office_assignment = "PEO N-Samar";
		}
		elseif($province == "WESTERN SAMAR")
		{
			$office_assignment = "PEO W-Samar";
		}
		elseif($province == "EASTERN SAMAR")
		{
			$office_assignment = "PEO E-Samar";
		}
		else
		{
			$office_assignment = "PEO Sogod";
		}

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
		$row=$rs->rowCount();

		if($row > 0){
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
			
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="../resources/bootswatch/lumen/bootstrap.css">
		<link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
		<link rel="stylesheet" href="../resources/css/local.css">
		<link rel="stylesheet" href="../resources/multi-select/bootstrap-multiselect.css">
		<script src="../resources/bootstrap-3.3.7-dist/js/jquery.min.js"></script>
		<script src="../resources/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../multi-select/bootstrap-multiselect.js"></script>
		<script type = "text/javascript" language = "javascript">
			$(document).ready(function(){
				$('#infoModal').on('show.bs.modal', function (e) {
					var rowid = $(e.relatedTarget).data('id');
					$.ajax({
						type : 'post',
				url : '../bin/details.php', //Here you will fetch records 
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
				url : '../update.php', //Here you will fetch records 
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
					url : 'ajax_address.php', 
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
					}
				});

			}

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
			<nav class="navbar navbar-inverse navbar-fixed-top">
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
							
							<li><a href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i></a></li>
							<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i>
								<span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li class="active"><a href="rsbsa">RSBSA</a></li>
									<li><a href="regular">Regular Program</a></li>
									<li><a href="apcp">APCP</a></li>
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

		<div class="page-header" style="margin-top:100px;">


			<h2>Registry System on Basic Sectors in Agriculture (RSBSA)</h2>
		</div>

		<?PHP 
		$results_per_page = 10;

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
					echo "<li class='disabled'><a href='#'>Previous</a></li>";
				}
				else echo "<li style='cursor:pointer'><a href='rsbsa?page=".($page-1)."'>Previous</a></li>";
					for ($x=max($page-5, 1); $x<=max(1, min($total_pages,$page+5)); $x++)
					{

						if($page == $x){ echo '<li class="active"><a href="rsbsa?page='.$x.'">'.$x.'</a></li>';} 
						else { echo '<li><a href="rsbsa?page='.($x).'">'.$x.'</a></li>';}
					}
					if($page < $total_pages){
						echo "<li style='cursor:pointer'><a href='rsbsa?page=".($page+1)."'>Next</a></li>";

					}
					else echo '<li class="disabled"><a href="#">Next</a></li>';
					echo '</ul>';




					?>
					<table class="table table-condensed table-hover" id="displaydata">

						
						<thead>
							<tr>
								<th>Date Received</th>
								<th>Livestock Policy Number</th>
								<th>Name Of Farmers / Assured</th>

								<th>Address</th>
								<th>Kind of Animal</th>
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
									echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
									echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
									echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
									echo '<td>'.$row['town'].', '.$row['province'].'</td>';
									echo '<td>'.$row['animal'].'</td>';

									if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
									echo '<td><a class="btn btn-default btn-xs" href="processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="glyphicon glyphicon-list"> </span></a></td>';
									echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';		
									echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';

									echo '</tr>';
								}

								else if($row['status'] =="cancelled") {
									echo '<tr>';
									echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
									echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
									echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
									echo '<td>'.$row['town'].', '.$row['province'].'</td>';
									echo '<td>'.$row['animal'].'</td>';
									if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
									echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';		
									echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';

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
				<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
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
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Insurance</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action="" class="form-horizontal" autocomplete="false">
							<div class="form-group">
								<label for="rcv" class="control-label col-sm-3">Received Date (optional):</label>
								<div class="col-sm-9">
									<input id="rcv" type="date" name="rcv" tabindex="1" class="form-control">
								</div>
							</div>	

							<div class="form-group">
								<label for="group-name" class="control-label col-sm-3">Group Name</label>
								<div class="col-sm-9">
									<input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al." required maxlength="200"  tabindex="2" class="form-control" autofocus>
								</div>	
							</div>	

							<div class="form-group">
								<label for="assured-name" class="control-label col-sm-3">Name of Assured</label>
								<div class="col-sm-9">
									<input type="text" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200"  tabindex="3" class="form-control">
								</div>
							</div>


							<?php
							if($_SESSION['office']=="Regional Office") 
							{
								?>	
								<div class="form-group">
									<label for="address" class="control-label col-sm-3">Province</label>
									<div class="col-sm-9">
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
								</div>
								<?php
							}
							else
							{

								?>
								<div class="form-group">
									<label for="address" class="control-label col-sm-3">Province</label>
									<div class="col-sm-9">
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
								</div>
								<?php
							}
							?>


							<div class="form-group">
								<label for="address" class="control-label col-sm-3">Town</label>
								<div class="col-sm-9">
									<select id="town" name="town" class="form-control" tabindex="5">
										<option value=""></option>
									</select>

								</div>
							</div>

							<div class="form-group">
								<label for="farmer-count" class="control-label col-sm-3">Farmers</label>
								<div class="col-sm-9">
									<input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"  tabindex="6" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label for="head-count" class="control-label col-sm-3">Heads</label>
								<div class="col-sm-9">
									<input type="number" id="head-count" name="head-count" required min=0 step="any"  tabindex="7" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label for="animal-type" class="control-label col-sm-3">Kind of Animal: </label>
								<div class="col-sm-9">	
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
							</div>	

							<div class="form-group">		
								<label for="rate" class="control-label col-sm-3">Premium Rate</label>
								<div class="col-sm-9">
									<input type="number" min=0 step="any" name ="rate" id ="rate" required  placeholder="0.00"  tabindex="9" class="form-control">
								</div>
							</div>

							<div class="form-group">
								<label for="cover" class="control-label col-sm-3">Amount Cover</label>
								<div class="col-sm-9">
									<input type="number" min=0 step="any" name="cover" id ="cover" required  placeholder="0.00"  tabindex="10" class="form-control">
								</div>
							</div>

							<div class="form-group">	
								<label for="datepicker1" class="control-label col-sm-3">Start of Cover</label>
								<div class="col-sm-9">
									<input type="date" name="effectivity-date"  tabindex="11" class="form-control" id="datepicker1">
								</div>
							</div>

							<div class="form-group">
								<label for="datepicker2" class="control-label col-sm-3">End of Cover</label>
								<div class="col-sm-9">
									<input type="date" name="expiry-date"  tabindex="12" class="form-control" id="datepicker2">	
								</div>
							</div>

							<div class="form-group">
								<label for="loading" class="control-label col-sm-3">Premium Loading</label>
								<div class="col-sm-9">
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
							</div>
							<div class="form-group">
								<label for="iu" class="control-label col-sm-3">IU/Solicitor</label>
								<div class="col-sm-9">
									<input type="text" name="iu" id ="iu" tabindex="14" class="form-control">
								</div>
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