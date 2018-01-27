<?php
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');

$idsnumber = htmlentities($_GET['ids'], ENT_QUOTES);
$get_program = substr($idsnumber, -4);


#check the type of Program PPPP->RSBSA, RRRR->REGULAR, etc....
switch ($get_program) {
	case 'PPPP':
		# code...
	$table = "control".$_SESSION['insurance'];
	$used_program = "RSBSA";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
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
		<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <small>('.$used_program.')</small></h5></td>
		</tr>
		<tr>
		<td><label>NAME</label></td>
		<td colspan="3">'.$assured.'</td>
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
		<td><strong>'.$lsp.'</strong></td>
		</tr>
		<tr>
		<td><label>GROUP</label></td>
		<td>'.$groupname.'</td>	
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
		<td>'.$premium.'</td>
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
	break;

	case "RRRR":
	#code...
	$table = "controlr";
	$used_program = "REGULAR";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
	foreach ($result as $row) {
		$assured = strtoupper($row['assured']);
		$address = strtoupper($row['town']).', '.strtoupper($row['province']);
		$animal = strtoupper($row['animal']);
		$lsp = strtoupper($row['lsp']).''.sprintf("%04d",$row['idsnumber']);
		$premium_loading = strtoupper($row['loading']);
		$d_rcv = date("m-d-Y",strtotime($row['date_r']));
		$groupname = strtoupper($row['groupName']);
		$lender = "";
		$dfrom = date('F j, Y', strtotime($row['Dfrom']));
		$dto = date('F j, Y', strtotime($row['Dto']));
		$sum_insured = number_format($row['amount_cover'],2);
		$rate = number_format($row['rate'],2);
		$premium = number_format($row['premium'],2);
		$doc_stamp = number_format(($row['premium'] * (12.5 / 100)),2);
		$tax = number_format(($row['premium'] * (5 / 100)),2); 

		$gpremium = number_format(floatval($premium) + floatval($doc_stamp) + floatval($tax) ,2);
		$heads = number_format($row['heads']);
		$farmers = number_format($row['farmers']);
		$lslb = $row['lslb'];
		$or_num = $row['receiptNumber'];
		$or_amt = number_format($row['receiptAmt'],2);
		$s_charge = number_format($row['s_charge'],2);
		$remit = number_format($gpremium - $s_charge,2);
		$iu = $row['iu'];
		$prepared = $row['prepared'];
	}	

	$rcount = $result->rowCount();
	if($rcount > 0) {
		if($lslb == '0') { $lslb = ""; } else {$lslb = $lslb;}
		$displaydata = '

		<table class="table table-condensed table-bordered">
		<tr>
		<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>	
		<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <small>('.$used_program.')</small></h5></td>
		</tr>
		<tr>
		<td><label>NAME</label></td>
		<td colspan="3">'.$assured.'</td>
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
		<td>'.$lsp.'</td>
		</tr>
		<tr>
		<td><label>GROUP</label></td>
		<td>'.$groupname.'</td>	
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
		<td>'.$or_num.'</td>
		<td><label>OR AMOUNT</label></td>
		<td>'.$or_amt.'</td>
		</tr>
		<tr>
		<td><label>TOTAL SUM INSURED</label></td>
		<td>'.$sum_insured.'</td>
		<td><label>PREMIUM RATE</label></td>
		<td>'.$rate.' %</td>
		</tr>
		
		<tr>
		<td><label>BASIC PREMIUM</label></td>
		<td>'.$premium.'</td>
		<td><label>GROSS PREMIUM</label></td>
		<td>'.$gpremium.'</td>		
		</tr>

		<tr>
		<td><label>DOC. STAMP</label></td>
		<td>'.$doc_stamp.'</td>
		<td><label>TAX</label></td>
		<td>'.$tax.'</td>		
		</tr>

		<tr>
		<td><label>SERVICE CHARGE</label></td>
		<td>'.$s_charge.'</td>
		<td><label>AMOUNT REMITTED</label></td>
		<td><strong>'.$remit.'</strong></td>
		</tr>
		
		<tr>
		<td><label>FARMERS</label></td>
		<td>'.$farmers.'</td>
		<td><label>HEADS</label></td>
		<td>'.$heads.'</td>
		</tr>

		</table>';


	}

	break;
	
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>PROCESSING SLIP</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="shortcut icon" href="images/favicon.ico">
	
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.css">
	<link rel="stylesheet" href="css/local.css">
	<script src="bootstrap-3.3.7-dist/js/jquery.min.js"></script>
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>
<body>
	

	<?php echo $displaydata ?>
	<div class="container">
		<p class="col-xs-4">RONELO D. PESQUERA <br><small>CHIEF, Marketing and Sales Division</small></p>
		<p class="col-xs-4"><?php echo $prepared ?> <br><small>Prepared By</small></p>
		<p class="col-xs-4"><?php echo $iu ?> <br><small>IU/Solicitor/AT</small></p>
	</div>

	<p class="text-center">__________________________________________________________________________________________________________________________________________________________________________________________</p>

	<?php echo $displaydata ?>
	<div class="container">
		<p class="col-xs-4">RONELO D. PESQUERA <br><small>CHIEF, Marketing and Sales Division</small></p>
		<p class="col-xs-4"><?php echo $prepared ?> <br><small>Prepared By</small></p>
		<p class="col-xs-4"><?php echo $iu ?> <br><small>IU/Solicitor/AT</small></p>
	</div>

	<p class="text-center">__________________________________________________________________________________________________________________________________________________________________________________________</p>


	<?php echo $displaydata ?>
	<div class="container">
		<p class="col-xs-4">RONELO D. PESQUERA <br><small>CHIEF, Marketing and Sales Division</small></p>
		<p class="col-xs-4"><?php echo $prepared ?> <br><small>Prepared By</small></p>
		<p class="col-xs-4"><?php echo $iu ?> <br><small>IU/Solicitor/AT</small></p>
	</div>
	
</body>
</html>	

