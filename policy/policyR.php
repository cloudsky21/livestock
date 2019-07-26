<?PHP
include("convert.php");
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');


$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

$lslb = htmlentities($_GET['lslb']);
$result = $db->prepare("SELECT * FROM controlr WHERE lslb = ?");
$result->execute([$lslb]);
foreach ($result as $row){
	
	$policy_num = $row['lsp'].''.sprintf("%04d",$row['idsnumber']);
	$owner = $row['assured'];
	$address = $row['address'];
	$policy_reference = "Logbook No.: ".$row['lslb'];
	$convertDate = date("Y/m/d", strtotime($row['Dfrom']));
	$convertDto = date("Y/m/d", strtotime($row['Dto']));
	$heads = $row['heads'];
	$sumInsured = $row['amount_cover'];
	$bprem = $row['premium'];
	$rate = $row['rate'];
	$tax = ($row['premium'] ) * (5 / 100);
	$stamp = ($row['premium'] ) * (12.5 / 100);
	$day = date("jS", strtotime($row['Dfrom']));
	$month = date("F, Y", strtotime($row['Dfrom']));
	$animal = $row['animal'];
	
	
	

	
	
	$convertDate2 = date("Y/m/d", strtotime($row['second_from']));
	$convertDto2 = date("Y/m/d", strtotime($row['second_to']));
	
	$convertDate3 = date("Y/m/d", strtotime($row['third_from']));
	$convertDto3 = date("Y/m/d", strtotime($row['third_to']));
}

$totalcharges = $bprem + $tax + $stamp;
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
else if($animal=="Goat-Breeder" || $animal=="Goat-Fattener" || $animal=="Sheep-Fattener" || $animal=="Sheep-Breeder" || $animal=="Sheep-Dairy"){

$deduct = "20%";
}



?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Policy Printing</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="bootstrap/3.3.7-dist/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
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
!-->
</head>


<body>
<div id = "border">
<div class="container-fluid">


	<div class="row vertical-align">
		<div class="col-md-4"><img src="images/logo2.jpg" width="150px" height="120px" class="img-responsive" style="vertical-align:bottom;"></div>
		<div class="col-md-4"><span>Republic of the Philippines<br>Department of Agriculture<br>PHILIPPINE CROP INSURANCE CORPORATION</span></div>
	</div>
	
	<div class="row">
		<div class="col-md-12"><h3 class="text-center">Livestock Insurance Policy</h3></div>
	</div>	
	
	<table id="table2" class="table table-condensed">	
		
		<tr>
			<td style="width: 30%; border-top: 2px solid black;"><strong>POLICY NO.</td>
			<td colspan=3 style="border-top: 2px solid black;"><h4><?PHP echo $policy_num; ?></h4></td>
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
			<td><?PHP echo number_format($tax,2); ?></td>
		</tr>
		<tr>
			<td>Documentary Stamp:</td>
			<td><?PHP echo number_format($stamp,2); ?></td>
		</tr>
		<tr>
			<td  style="border-bottom: 2px solid black;">TOTAL PREMIUM</td>
			<td  style="border-bottom: 2px solid black;"><?PHP echo number_format($totalcharges,2); ?></td>
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
			<td style="border: none !important; text-align:center;"><h5>RONELO D. PESQUERA</h5></td>
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
