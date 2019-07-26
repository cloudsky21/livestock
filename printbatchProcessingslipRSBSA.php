<?php
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');


if(isset($_POST['printBtn']))
{


	if(!empty($_POST['chkPrint']))
	{

$row = $_POST['chkPrint'];
foreach ($row as $key => $value) {
	
	
	$table = "control".$_SESSION['insurance'];
	$used_program = "RSBSA";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$value]);
	foreach ($result as $row) {
		$assured = strtoupper($row['assured']);
		$address = strtoupper($row['town']).', '.strtoupper($row['province']);
		$animal = strtoupper($row['animal']);
		$lsp = strtoupper($row['lsp']).''.sprintf("%04d",$row['idsnumber']).'-'.$row['idsprogram'];
		$premium_loading = strtoupper($row['loading']);
		$d_rcv = date("m-d-Y",strtotime($row['date_r']));
		$groupname = strtoupper($row['groupName']);
		$lender = "";
		$dfrom = date('F j, Y', strtotime($row['Dfrom']));
		$dto = date('F j, Y', strtotime($row['Dto']));
		$sum_insured = number_format($row['amount_cover'],2);
		$rate = number_format($row['rate'],2);
		$premium = number_format($row['premium'],2);
		$heads = number_format($row['heads']);
		$farmers = number_format($row['farmers']);
		$lslb = $row['lslb'];
		$iu = $row['iu'];
		$prepared = $row['prepared'];

	}	

	$rcount = $result->rowCount();
	if($rcount > 0) {
		if($lslb == '0') { $lslb = ""; } else {$lslb = $lslb;}

		$displaydata = '

		<table class="table table-condensed table-bordered font-md">
		<tr>
		<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>	
		<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>('.$used_program.')</strong></h5></td>
		</tr>
		<tr>
		<td><label>NAME</label></td>
		<td colspan="3"><strong>'.$assured.'</strong></td>
		</tr>
		<tr>
		<td><label>ADDRESS</label></td>
		<td>'.$address.'</td>
		<td><label>LOGBOOK</label></td>
		<td>'.$lslb.'</td>
		</tr>
		<tr>
		<td><label>KIND OF ANIMAL + PURPOSE</label></td>
		<td>'.$animal.'</td>
		<td><label>POLICY NO.</label></td>
		<td><h4><strong>'.$lsp.'</strong></h4></td>
		</tr>
		<tr>
		<td><label>GROUP</label></td>
		<td><strong>'.$groupname.'</strong></td>	
		<td><label>DATE RECEIVED</label></td>
		<td>'.$d_rcv.'</td>
		</tr>
		<tr>
		<td><label>PREMIUM LOADING</label></td>
		<td colspan="3">'.$premium_loading.'</td>
		</tr>

		<tr>
		<td><label>EFFECTIVITY DATE</label></td>
		<td>'.$dfrom.'</td>
		<td><label>EXPIRY DATE</label></td>
		<td>'.$dto.'</td>	
		</tr>	
		<tr>
		<td><label>OR NO.</label></td>
		<td>&nbsp;</td>
		<td><label>BASIC PREMIUM</label></td>
		<td><strong>'.$premium.'</strong></td>
		</tr>
		<tr>
		<td><label>TOTAL SUM INSURED</label></td>
		<td>'.$sum_insured.'</td>
		<td><label>PREMIUM RATE</label></td>
		<td>'.$rate.' %</td>
		</tr>
		
		<tr>
		<td><label>FARMERS</label></td>
		<td>'.$farmers.'</td>
		<td><label>HEADS</label></td>
		<td>'.$heads.'</td>
		</tr>

		</table>';


	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>PROCESSING SLIP</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="shortcut icon" href="images/favicon.ico">
	
	<link rel="stylesheet" href="resources/bootstrap-3.3.7-dist/css/bootstrap.css">
	<link rel="stylesheet" href="resources/css/local.css">

</head>
<body>
	

	<?php echo $displaydata ?>
	<div class="container">
		<p class="col-xs-4">RONELO D. PESQUERA <br><small>CHIEF, Marketing and Sales Division</small></p>
		<p class="col-xs-4"><?php echo $prepared ?> <br><small>Prepared By</small></p>
		<p class="col-xs-4"><?php echo $iu ?> <br><small>IU/Solicitor/AT</small></p>
	</div>

	<p class="text-center">__________________________________________________________________________________________________________________________________________________________________________________________</p>

	


	
</body>
</html>	

<?php
}



	}

}



?>