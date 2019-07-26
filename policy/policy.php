<?PHP
session_start();
include("../convert.php");
require_once("../connection/conn.php");
date_default_timezone_set('Asia/Manila');
$table = 'control'.$_SESSION['insurance'];
$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
$lslb = htmlentities($_GET['lslb']);
$result = $db->prepare("SELECT * FROM $table WHERE lslb = ?");
$result->execute([$lslb]);
foreach ($result as $row){
	$policy_num = $row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'];
	$owner = $row['assured'];
	$address = $row['town'].', '.$row['province'];
	$policy_reference = "Logbook No.: ".$row['lslb'];
	$convertDate = date("Y/m/d", strtotime($row['Dfrom']));
	$convertDto = date("Y/m/d", strtotime($row['Dto']));
	$heads = $row['heads'];
	$sumInsured = $row['amount_cover'];
	$bprem = $row['premium'];
	$day = date("jS", strtotime($row['Dfrom']));
	$month = date("F, Y", strtotime($row['Dfrom']));
	$animal = $row['animal'];
}
if($animal=="Carabao-Breeder" || $animal=="Carabao-Draft" || $animal=="Carabao-Dairy" || $animal=="Carabao-Fattener"){	
	$deduct = "20%";	
}
else if($animal=="Cattle-Breeder" || $animal=="Cattle-Draft" || $animal=="Cattle-Dairy" || $animal=="Cattle-Fattener"){
	$deduct = "20%";
}
else if($animal=="Horse-Breeder" || $animal=="Horse-Draft" || $animal=="Horse-Working"){
	$deduct = "20%";
}
else if($animal=="Swine-Breeder"){
	$deduct = "20%";
}
else if($animal=="Swine-Fattener"){
	$deduct = "10%";	
}
else if($animal=="Poultry-Broilers"){
	$deduct = "2.45% - For Normal Cover".'<br>'."10% - For Extraneous Perils";
}
else if($animal=="Poultry-Layers" || $animal=="Poultry-Pullets"){
	$deduct = "2.45% - For Normal Cover".'<br>'."10% - For Extraneous Perils";	
}
else if($animal=="Goat-Breeder" || $animal=="Goat-Fattener"){
	$deduct = "20%";
}
?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Policy Printing <?PHP echo $lslb ?></title>
	<link rel="apple-touch-icon" sizes="57x57" href="../images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="../images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="../images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="../images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="../images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="../images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="../images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="stylesheet" href="../resources/bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<!--
	<link href="mypdf.css" type="text/css" rel="stylesheet" media="mpdf" />
-->
<script src="../resources/bootstrap-3.3.7-dist/js/jquery.min.js"></script>
<script src="../resources/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<!--
	<script language="javascript" type="text/javascript">
  /* <![CDATA[ */
    document.write('<a href="makepdf.php?url=' + encodeURIComponent(location.href) +'">');
    document.write('Create PDF file of this page');
    document.write('</a>');
	
  /* ]]> */
</script>
-->
<!---
<style>
@page {
  size: A4;
  margin: 1in;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;
	
  }
  

	 
  
}
body, html {
	margin: 0;
	font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
}

#border {
	border: 1px solid black;
	width: 100%;
	
}
#img-holder {
	width: 100%;
	
}

#table1 td { 
padding: 5px;
}

#table1 {
border-collapse: collapse;	
}
#table2 {
width: 100%;
vertical-align: bottom;
border-collapse: collapse;	
}

#table2 td {
padding-top: 15px;
padding-left: 5px;
border-bottom: 1px solid #ddd;
}


</style>
-->
</head>
<body>
	<div id = "border">
		<div class="container-fluid">
			<div class="row vertical-align">
				<div class="col-md-4"><img src="../images/logo2.jpg" width="125px" height="100px" class="img-responsive" style="vertical-align:bottom;"></div>
				<div class="col-md-4"><span>Republic of the Philippines<br>Department of Agriculture<br>PHILIPPINE CROP INSURANCE CORPORATION</span></div>
			</div>	
			<div class="row">
				<div class="col-md-12"><h4 class="text-center">Livestock Insurance Policy</h4></div>
			</div>	
			<table id="table2" class="table table-condensed">			
				<tr>
					<td style="width: 30%; border-top: 2px solid black;"><strong>POLICY NO.</td>
						<td colspan=3 style="border-top: 2px solid black;"><h5><?PHP echo $policy_num; ?></h5></td>
					</tr>		
					<tr>
						<td style="width: 30%"><strong>POLICY OWNER</td>
							<td colspan=3><?PHP echo $owner; ?></td>
						</tr>		
						<tr>
							<td style="width: 30%"><strong>ADDRESS</td>
								<td colspan=3><?PHP echo $address; ?></td>
							</tr>		
							<tr>
								<td style="width: 30%"><strong>POLICY REFERENCE</strong></td>
								<td colspan=3><strong><?PHP echo $policy_reference; ?></strong></td>
							</tr>
							<tr>
								<td style="width: 30%"><strong>DATE ISSUED: </td>
									<td colspan=3><?PHP echo date('F j, Y', strtotime($convertDate)); ?></td>
								</tr>		
								<tr>
									<td><strong>START OF COVERAGE</td>
										<td><?PHP echo date('F j, Y', strtotime($convertDate)); ?></td>
										<td><strong>END OF COVERAGE</td>
											<td><?PHP echo date('F j, Y', strtotime($convertDto)); ?></td>
										</tr>		
										<tr>
											<td style="border-bottom: 2px solid black;">&nbsp;</td>
											<td style="border-bottom: 2px solid black;">12:00 NOON</td>
											<td style="border-bottom: 2px solid black;">&nbsp;</td>
											<td style="border-bottom: 2px solid black;">12:00 NOON</td>
										</tr>		
										<tr>
											<td style="border-bottom: 2px solid black;"><label><strong>NUMBER OF HEADS</strong></label></td>
											<td style="border-bottom: 2px solid black;" colspan=3><?PHP echo $heads; ?></td>
										</tr>	
										<tr>
											<td rowspan=3 style="border-bottom: 2px solid black;"><label><strong>SUM INSURED</strong></label></td>
										</tr>
										<tr>	
											<td colspan=2><?PHP echo strtoupper($f->format($sumInsured)); ?> PESOS ONLY</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<td style="border-bottom: 2px solid black;">&nbsp;</td>	
											<td style="border-bottom: 2px solid black;">&nbsp;</td>
											<td style="border-bottom: 2px solid black;"><strong>Php </strong> (<?PHP echo number_format($sumInsured,2); ?>)</td>
										</tr>
										<tr>
											<td rowspan=4 style="vertical-align: bottom; border-bottom: 2px solid black;" ><label>PREMIUM DUE</label></td>
											<td>Basic Premium: </td>
											<td><?PHP echo number_format($bprem,2); ?></td>
										</tr>
										<tr>
											<td>Premium Tax:</td>
											<td>0.00</td>
										</tr>
										<tr>
											<td>Documentary Stamp:</td>
											<td>0.00</td>
										</tr>
										<tr>
											<td  style="border-bottom: 2px solid black;">TOTAL PREMIUM</td>
											<td  style="border-bottom: 2px solid black;"><?PHP echo number_format($bprem,2); ?></td>
											<td  style="border-bottom: 2px solid black;">&nbsp;</td>
										</tr>
										<tr>
											<td rowspan=2 style="border-bottom: none;">DEDUCTIBLE</td>
										</tr>
										<tr>
											<td><?PHP echo $deduct; ?></td>
											
											
										</tr>
										<tr>
											<td  style="border-bottom: 2px solid black;">&nbsp;</td>
											<td  style="border-bottom: 2px solid black;">&nbsp;</td>
											<td  style="border-bottom: 2px solid black;">&nbsp;</td>
										</tr>
										<tr>
											<td colspan=4 style="border: none;">The undersigned as the duly authorized signatory of the Philippines Crop Insurance Corporation for the Policy hereby grants this coverage to the above declared policy holder subject to all terms and condictions on the attached sheets this <strong><?PHP echo $day; ?></strong> of <strong><?PHP echo $month; ?></strong>.</td>
										</tr>
										
										<tr>
											<td style="border: none !important;">&nbsp;</td>
											<td style="border: none !important;">&nbsp;</td>
											<td colspan=2 style="border: none;">PHILIPPINE CROP INSURANCE CORPORATION</td>
										</tr>
										<tr>
											<td style="border: none;"></td>
											<td style="border: none;"></td>
											<td colspan=2 style="border: none;">By authority of the President</td>
										</tr>
										
										<tr>
											<td style="border: none !important;">&nbsp;</td>
											<td style="border: none !important;">&nbsp;</td>
											<td style="border: none !important; text-align:center;"><h5>DOMINICO S. DIGAMON</h5></td>
										</tr>
										<tr>
											<td style="border: none !important;">&nbsp;</td>
											<td style="border: none !important;">&nbsp;</td>
											<td style="text-align: center; border-top: 1px solid black;">Authorized Signatory</td>
										</tr>		
									</table>
								</div>
							</div>
						</body>
						</html>
						<?php
						exec('wkhtmltopdf policy.php google.pdf');
						?>