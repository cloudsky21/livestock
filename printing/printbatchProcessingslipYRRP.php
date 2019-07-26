<?php
session_start();
require_once "../connection/conn.php";
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

$table = $obj->yrrp();


if(isset($_POST['printBtn']))
{


	if(!empty($_POST['chkPrint']))
	{

$row = $_POST['chkPrint'];
foreach ($row as $key => $value) {
	
	
	
	$used_program = "YRRP";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$value]);
	foreach ($result as $row) {
		$assured = strtoupper($row['assured']);
		$address = strtoupper($row['town']).', '.strtoupper($row['province']);
		$animal = strtoupper($row['animal']);
		$lsp = strtoupper($row['lsp']).''.sprintf("%04d",$row['idsnumber']).'-'.$row['idsprogram'];
		$premium_loading = strtoupper($row['loading']);
		$d_rcv = date("F j, Y",strtotime($row['date_r']));
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
		$f_id = $row['f_id'];
		$tag = $row['tag'];
		$status = $row['status'];
		$or = 'Y99999-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-L';

	}	

	$rcount = $result->rowCount();
			if($rcount > 0) {
				if($lslb == '0') { $lslb = ""; } else {$lslb = $lslb;}
				switch ($status) {
					case 'active':
						# active
					$displaystat = "Note: Subject to possible changes.";
					break;

					case 'cancelled':
						# cancelled
					$displaystat = "Note: Cancelled Application.";
					break;
					
					default:
						# Evaluated
					$displaystat = "Note: Evaluated";
					break;
				}

				$displaydata = '

				<table class="table table-condensed table-bordered font-md">
					<tr>
						<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>	
						<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>('.$used_program.')</strong></h5></td>
					</tr>
					<tr>
						<th scope="row"><label>NAME</label></th>
							<td><strong>'.$assured.'</strong> <small>(ID: '.$f_id.')</small></td>
						<td><small>'.$displaystat.'</small></td>
						<td></td>
					</tr>
					<tr>
						<th scope="row"><label>ADDRESS</label></th>
							<td>'.$address.'</td>
						<th scope="row"><label>LOGBOOK</label></th>
							<td style="font-size: 14pt;"><strong>'.$lslb.'</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>KIND OF ANIMAL + PURPOSE</label></th>
							<td><strong>'.$animal.'</strong></td>
						<th scope="row"><label>POLICY NO.</label></th>
							<td style="font-size: 14pt;"><strong>'.$lsp.'</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>GROUP</label></th>
							<td><strong>'.$groupname.'</strong></td>	
						<th scope="row"><label>DATE RECEIVED</label></th>
							<td>'.$d_rcv.'</td>
					</tr>
					<tr>
						<th scope="row"><label>PREMIUM LOADING</label></th>
							<td>'.$premium_loading.'</td>
						<th scope="row"><label>COLC/CTC/TAG</label></th>	
							<td>'.$tag.'</td>
					</tr>
					<tr>
						<th scope="row"><label>EFFECTIVITY DATE</label></th>
							<td>'.$dfrom.'</td>
						<th scope="row"><label>EXPIRY DATE</label></th>
							<td>'.$dto.'</td>	
					</tr>	
					<tr>
						<th scope="row"><label>OR NO.</label></th>
							<td><strong>'.$or.'</strong></td>
						<th scope="row"><label>BASIC PREMIUM</label></th>
							<td><strong>'.$premium.'</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>TOTAL SUM INSURED</label></th>
							<td>'.$sum_insured.'</td>
						<th scope="row"><label>PREMIUM RATE</label></th>
							<td>'.$rate.' %</td>
					</tr>
					<tr>
						<th scope="row"><label>FARMERS</label></th>
							<td>'.$farmers.'</td>
						<th scope="row"><label>HEADS</label></th>
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
				<link rel="shortcut icon" href="../images/favicon.ico">	
				<link rel="stylesheet" href="../resources/bootswatch-3/solar/bootstrap.css">
				<link rel="stylesheet" href="../resources/css/local.css">

			</head>
			<body>


				<?php echo $displaydata ?>
				<div class="container">
					<div class="row">
						<p class="col-xs-4"><strong>BENITA M. ALBERTO</strong> <br><small>OIC-CHIEF, Marketing and Sales Division</small></p>
						<p class="col-xs-4"><strong><?php echo $prepared ?></strong> <br><small>Prepared By</small></p>
						<p class="col-xs-4"><strong><?php echo $iu ?></strong> <br><small>IU/Solicitor/AT</small></p>
					</div>
				</div>

				<p class="text-center">__________________________________________________________________________________________________________________________________________________________________________________________</p>





			</body>
			</html>	

			<?php
		}



	}
	else
	{
		echo 'Use checbox to select policy for processing slip. This tab will close after 3 seconds..';
		echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';
	}

}



?>