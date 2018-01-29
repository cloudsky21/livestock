<?php
session_start();
require_once("../connection/conn.php");
date_default_timezone_set('Asia/Manila');
$table = "controlr";


if(!isset($_SESSION['isLogin']) && (!isset($_COOKIE["lx"]))) { header("location: logmeOut");}
	if(isset($_POST['submit_index'])){

		$yearNow = date("Y");	


		$getdate = date("Y-m-d", strtotime($_POST['rcv']));

		if($getdate == '1970-01-01'){

			$getdate = date("Y-m-d");
		}

		else {$getdate = date("Y-m-d", strtotime($_POST['rcv']));}



		$ids = "RO8-".date("Y")."-".date("m");

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
		$ids = "RO8-".date("Y")."-".date("m");
		$program = "RSBSA";

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


		$rC_num = htmlentities($_POST['rcnum']);
		$rC_amt = htmlentities($_POST['rcAmt']);
		$s_charge = htmlentities($_POST['scharge']);
		$rcdget = "none";
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
			receiptNumber,
			receiptAmt,
			rcd,
			groupName, 
			ids1, 
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
			status,
			office_assignment,
			s_charge,
			iu,
			prepared) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		$result->execute([
			$yearNow,
			$getdate,
			$rC_num,
			$rC_amt,
			$rcdget,
			$group, 
			$ids, 
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
			"active",
			$office_assignment,
			$s_charge,
			$iu,
			$prepared]);

		$row=$result->rowCount();

		if($row=='1'){

			unset($_POST);
			header('Location: '.$_SERVER[REQUEST_URI]);	
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
	if(isset($_POST['submit_update'])){
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
			$newfilename = $_POST['ids'].'REGULAR'.'.'.end($temp);
			move_uploaded_file($_FILES["fileUpload"]["tmp_name"],
				"../L/uploads/REGULAR/".$_SESSION['insurance'].'/' . $newfilename);


			$path = "../L/uploads/REGULAR/".$_SESSION['insurance'].'/'.$newfilename;
			$result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
			$result->execute([$path,$_POST['ids']]);


		}
		else
		{
			echo "Files must be PDF or empty";
		}


		$rs = $db->prepare("UPDATE $table SET 
			groupName=?, 
			assured=?,
			province=?,
			town=?,
			farmers=?,
			heads=?,
			animal=?,
			premium=?,
			rate=?,
			amount_cover=?,
			Dfrom=?,
			Dto=?,
			status=?,
			receiptNumber=?,
			receiptAmt=?,
			lsp=?,
			lslb=?, office_assignment = ?, s_charge = ?, iu=?, prepared=?	WHERE idsnumber=?");


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

		$unwanted = array("&NTILDE;" => "Ñ");		
		$group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)),$unwanted);
		$assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)),$unwanted);
		$iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)),$unwanted);
		$prepared = mb_strtoupper($_SESSION['isLoginName']);
		$province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
		$town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);
		
		

		$getrcd = strtoupper(htmlentities($_POST['rcd']));

		$bpremium = ($_POST['rate'] / 100) * $_POST['cover'];

		$fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
		$toDate = date("Y-m-d", strtotime($_POST['expiry-date']));

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

		$s_charge = htmlentities($_POST['scharge']);
		$rs->execute([
			$group, 
			$assured, 
			$province,
			$town, 
			$_POST['farmer-count'], 
			$_POST['head-count'], 
			$_POST['animal-type'], 
			$bpremium, 
			$_POST['rate'],
			$_POST['cover'],
			$fromDate,
			$toDate,
			$_POST['stt'],
			$_POST['rcnum'],
			$_POST['rcAmt'],
			$LSP,
			$_POST['lslb'],
			$office_assignment,
			$s_charge,
			$iu,
			$prepared,
			$_POST['ids']]);	


		$row=$rs->rowCount();

		$getpage = "?page=".$pgnumber;


		if($row=='1'){

			unset($_POST);
			header("location: ".$_SERVER[REQUEST_URI]);

		}
		else $success = '<div class="alert alert-danger alert-dismissable" id="flash-msg">Record rejected for update.</div>';

	}



	?>



	<!DOCTYPE html>
	<html>

	<head>

		<title>Regular | Livestock Control</title>

		<meta charset="utf8">
		<link rel="shortcut icon" href="../images/favicon.ico">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta charset="utf8">		
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
            url : '../bin/detailsr.php', //Here you will fetch records 
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
            url : 'updater.php', //Here you will fetch records 
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
            url : 'deleter.php', //Here you will fetch records 
            data :  'rowid='+ rowid, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
        }
    });
				});
			});



			window.onload = function () {
				var input = document.getElementById("rcnum").focus();
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

			function find_ids($val){
				var xz = $val;

				$('#displaydata > tbody').empty();

				$.ajax({
					type: 'POST',
					url: 'searchR.php',
					data: 'ids='+ xz,
					success: function(e){
						$('#displaydata > tbody').html(e);
					}
				});

			}
			$(document).keypress(function(evt){
				if (evt.keyCode=="96"){
					$('#myModal').modal('show');
					$('#group-name').focus();

				}

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
										<li class="active"><a href="#">Regular Program</a></li>
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
					<h2>Regular Program</h2>
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




				<div class="span3">
					<div class="table-responsive">
						<div style="overflow-x:auto;">
							<table class="table table-condensed table-hover" id='displaydata'>

								<?PHP

								echo '<ul class="pagination pull-right">';

								if($page <=1){
									echo "<li class='disabled'><a href='#'>Previous</a></li>";
								}
								else echo "<li style='cursor:pointer'><a href='regular?page=".($page-1)."'>Previous</a></li>";
									for ($x=max($page-5, 1); $x<=max(1, min($total_pages,$page+5)); $x++)
									{

										if($page == $x){ echo '<li class="active"><a href="regular?page='.$x.'">'.$x.'</a></li>';} 
										else { echo '<li><a href="regular?page='.($x).'">'.$x.'</a></li>';}
									}
									if($page < $total_pages){
										echo "<li style='cursor:pointer'><a href='regular?page=".($page+1)."'>Next</a></li>";

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
												echo '<td>'.$row['groupName'].'</td>';
												echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" data-keyboard="false"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'</strong></td>';
												echo '<td>'.$row['assured'].'</td>';
												echo '<td>'.$row['town'].', '.$row['province'].'</td>';
												echo '<td>'.$row['animal'].'</td>';
												if($row['lslb'] != "0") { echo '<td><a class="btn btn-default btn-xs" href="policyR.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>'; } else {echo '<td><a class="btn btn-default btn-xs disabled" href="policyR.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}
												echo '<td><a class="btn btn-default btn-xs" href="processingslip?ids='.$row['idsnumber'].'RRRR" target="_blank"><span class="fa fa-list"> </span></a></td>';
												echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" data-keyboard="false"><span class="fa fa-edit"></span></a></td>';
												echo '<td><a class="btn btn-default btn-xs" href="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" data-keyboard="false"><span class="fa fa-trash"></span></a></td>';

												echo '</tr>';
											}
											else if($row['status'] =="cancelled") {
												echo '<tr>';
												echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
												echo '<td>'.$row['groupName'].'</td>';
												echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" data-keyboard="false"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
												echo '<td>'.$row['assured'].'</td>';
												echo '<td>'.$row['town'].', '.$row['province'].'</td>';
												echo '<td>'.$row['animal'].'</td>';
												if($row['lslb'] != "0") { echo '<td><a class="btn btn-default btn-xs" href="policyR.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>'; } else {echo '<td><a class="btn btn-default btn-xs disabled" href="policyR.php?lslb='.$row['lslb'].'" target="_blank" readonly>'.$row['lslb'].'</a></td>';}
												echo '<td><a class="btn btn-default btn-xs" href="processingslip?ids='.$row['idsnumber'].'RRRR" target="_blank"><span class="fa fa-list"> </span></a></td>';
												echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" data-keyboard="false"><span class="fa fa-edit"></span></a></td>';
												echo '<td><a class="btn btn-default btn-xs" href="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" data-keyboard="false"><span class="fa fa-trash"></span></a></td>';

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
							<form action="" method="post" class="form-horizontal">
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
									<button type="submit" class="btn btn-primary" name="submit_update">Save Changes</button>
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
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog modal-lg">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Add Insurance</h4>
							</div>
							<div class="modal-body">
								<form method="POST" action="" autocomplete="off">


									<div class="form-group row">
										<div class="col-xs-3">
											<label for="rcv">Received Date (optional):</label>
											<input id="rcv" type="date" name="rcv" tabindex="1" class="form-control">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-xs-3">
											<label for="rcnum">Receipt No.</label>
											<input id="rcnum" type="number" name="rcnum" tabindex="2" placeholder="0000000" required step="any" class="form-control" autofocus>
										</div>

										<div class="col-xs-3">
											<label for="rcAmt">Receipt Amount</label>
											<input id="rcAmt" type="number" name="rcAmt" tabindex="3" placeholder="0000" required step="any" class="form-control">
										</div>
									</div>

									<div class="form-group row">

										<div class="col-xs-4">
											<label for="group-name">Group Name</label>
											<input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al." required maxlength="200"  tabindex="4" class="form-control">
										</div>

										<div class="col-xs-4">
											<label for="assured-name">Name of Assured</label>
											<input type="text" name="assured-name" id="assured-name" placeholder="Juan Dela Cruz et. al." required maxlength="200"  tabindex="5" class="form-control">
										</div>
									</div>

									<div class="form-group row">
										<div class="col-xs-4">
											<label for="address">Province</label>
											<select id="province" name="province" placeholder="Leyte" class="form-control" onfocus="getaddress(this.value);" tabindex="6">
												<option value="Leyte">LEYTE</option>
												<option value="Southern Leyte">SOUTHERN LEYTE</option>
												<option value="Biliran">BILIRAN</option>
												<option value="Northern Samar">NORTHERN SAMAR</option>
												<option value="Eastern Samar">EASTERN SAMAR</option>
												<option value="Western Samar">WESTERN SAMAR</option>
											</select>
										</div>



										<div class="form-group row">
											<div class="col-xs-4">
												<label for="address">Town</label>
												<select id="town" name="town" class="form-control" tabindex="7">
													<option value=""></option>
												</select>
											</div>
										</div>

										<div class="col-xs-2">
											<label for="farmer-count">Farmers</label>
											<input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"  tabindex="8" class="form-control">
										</div>

										<div class="col-xs-2">
											<label for="head-count">Heads</label>
											<input type="number" id="head-count" name="head-count" required min=0 step="any"  tabindex="9" class="form-control">
										</div>




										<div class="col-xs-4">
											<label for="animal-type">Kind of Animal: </label>
											<select name="animal-type" id="animal-type" onchange="getch(this.value);"  tabindex="10" class="form-control">

												<option name="animal" value="--------">---------</option>
												<option name="animal" value="Carabao-Breeder">Carabao Breeder</option>
												<option name="animal" value="Carabao-Draft">Carabao Draft</option>
												<option name="animal" value="Carabao-Dairy">Carabao Dairy</option>
												<option name="animal" value="Carabao-Fattener">Carabao Fattener</option>
												<option name="animal" value="--------">---------</option>
												<option name="animal" value="Cattle-Breeder">Cattle Breeder</option>
												<option name="animal" value="Cattle-Draft">Cattle Draft</option>
												<option name="animal" value="Cattle-Dairy">Cattle Dairy</option>
												<option name="animal" value="Cattle-Fattener">Cattle Fattener</option>
												<option name="animal" value="--------">---------</option>
												<option name="animal" value="Horse-Draft">Horse Draft</option>
												<option name="animal" value="Horse-Working">Horse Working</option>
												<option name="animal" value="Horse-Breeder">Horse Breeder</option>
												<option name="animal" value="--------">---------</option>
												<option name="animal" value="Swine-Fattener">Swine Fattener</option>
												<option name="animal" value="Swine-Breeder">Swine Breeder</option>
												<option name="animal" value="--------">---------</option>
												<option name="animal" value="Goat-Fattener">Goat Fattener</option>
												<option name="animal" value="Goat-Breeder">Goat Breeder</option>
												<option name="animal" value="Goat-Milking">Goat Milking</option>
												<option name="animal" value="--------">---------</option>
												<option name="animal" value="Sheep-Fattener">Sheep Fattener</option>
												<option name="animal" value="Sheep-Breeder">Sheep Breeder</option>
												<option name="animal" value="--------">---------</option>
												<option name="animal" value="Poultry-Broilers">Poultry-Broilers</option>
												<option name="animal" value="Poultry-Pullets">Poultry-Pullets</option>
												<option name="animal" value="Poultry-Layers">Poultry-Layers</option>
											</select>

										</div>
									</div>
									<div class="form-group row">
										<div class="col-xs-3">
											<label for="rate">Premium Rate</label>
											<input type="number" min=0 step="any" name ="rate" id ="rate" required value="0.00" placeholder="0.00"  tabindex="11" class="form-control">
										</div>

										<div class="col-xs-3">
											<label for="cover"><strong>Amount Cover</strong></label>
											<input type="number" min=0 step="any" name="cover" id ="cover" required value="0.00" placeholder="0.00"  tabindex="12" class="form-control">
										</div>
									</div>

									<div class="form-group row">
										<div class="col-xs-4">
											<label for="scharge">Service Charge</label>
											<input type="number" min=0 step="any" name ="scharge" id ="scharge" value="0.00" placeholder="0.00"  tabindex="13" class="form-control">
										</div>
									</div>	
									<div class="form-group row">

										<div class="col-xs-4">	
											<label for="datepicker1">Start of Cover</label>
											<input type="date" name="effectivity-date"  tabindex="14" class="form-control" id="datepicker1">
										</div>

										<div class="col-xs-4">
											<label for="datepicker2">End of Cover</label>
											<input type="date" name="expiry-date"  tabindex="15" class="form-control" id="datepicker2">	
										</div>
									</div>
									<div class="form-group row">

										<div class="col-xs-4">
											<label for="iu">IU/Solicitpr</label>
											<input type="text" id="iu" name="iu" tabindex="16" class="form-control">
										</div>
									</div>








								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary" tabindex="15" name="submit_index">Submit</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</body>

			</html>	