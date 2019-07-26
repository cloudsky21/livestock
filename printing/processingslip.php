<?php
session_start();
require_once("../connection/conn.php");
require '../myload.php';

date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$idsnumber = urldecode(htmlentities($_GET['ids'], ENT_QUOTES));
$get_program = substr($idsnumber, -4);
if($get_program == '-ARB') {
	$get_program = substr($idsnumber, -8, 4);
}
$obj = new programtables();


#check the type of Program PPPP->RSBSA, RRRR->REGULAR, etc....
switch ($get_program) {

	# ======================== AGRI-AGRA PROGRAM ==============================
		case 'AGRI':
		
		

	$table = $obj->agriagra();
	$used_program = "AGRI-AGRA";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
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
		if($row['idsprogram'] == 'AGRI') { 
			$or = 'AA2018-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-L';
		} else {
			$or = 'AARB18-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-L';
		}
		
		$status = $row['status'];
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
				<td><label>NAME</label></td>
				<td colspan="2"><strong>'.$assured.'</strong></td>
				<td><small>'.$displaystat.'</small></td>
			</tr>

			<tr>
				<td><label>ADDRESS</label></td>
				<td>'.$address.'</td>
				<td><label>LOGBOOK</label></td>
				<td><h4><strong>'.$lslb.'</strong></h4></td>
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
				<td><strong>'.$or.'</strong></td>
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
	break;
	# ============== END AGRI-AGRA PROGRAM =====================

	# ======================== SAAD PROGRAM ==============================
		case 'SAAD':		

	$table = $obj->saad();
	$used_program = "SAAD";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
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
		$or = '222222-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-SAAD-L';
		$status = $row['status'];

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
				<td><label>NAME</label></td>
				<td colspan="2"><strong>'.$assured.'</strong></td>
				<td><small>'.$displaystat.'</small></td>
			</tr>

			<tr>
				<td><label>ADDRESS</label></td>
				<td>'.$address.'</td>
				<td><label>LOGBOOK</label></td>
				<td><h4><strong>'.$lslb.'</strong></h4></td>
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
				<td><strong>'.$or.'</strong></td>
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
	break;
	# ============== END SAAD PROGRAM =====================

	# ============== END APCP PROGRAM =========================
	case 'APCP':
		
	
	$table = $obj->apcp();

	$used_program = "APCP";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
	foreach ($result as $row) {
		$assured = strtoupper($row['assured']);
		$address = strtoupper($row['town']).', '.strtoupper($row['province']);
		$animal = strtoupper($row['animal']);
		$lsp = strtoupper($row['lsp']).''.sprintf("%04d",$row['idsnumber']).'-'.$row['idsprogram'];
		//$premium_loading = strtoupper($row['loading']);
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
		$or = 'A99999-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-L';
		$status = $row['status'];

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
				<td><label>NAME</label></td>
				<td colspan="2"><strong>'.$assured.'</strong></td>
				<td><small>'.$displaystat.'</small></td>
			</tr>

			<tr>
				<td><label>ADDRESS</label></td>
				<td>'.$address.'</td>
				<td><label>LOGBOOK</label></td>
				<td><strong style="color:red;">'.$lslb.'</strong></td>
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
				<td colspan="3"></td>
			</tr>

			<tr>
				<td><label>EFFECTIVITY DATE</label></td>
				<td>'.$dfrom.'</td>
				<td><label>EXPIRY DATE</label></td>
				<td>'.$dto.'</td>	
			</tr>	
			
			<tr>
				<td><label>OR NO.</label></td>
				<td><strong>'.$or.'</strong></td>
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
	break;
	# ============================== END APCP PROGRAM ==============================

	# ============================== RSBSA PROGRAM ==============================
	case 'PPPP':
	
			
	$table = $obj->rsbsa();
	$used_program = "RSBSA";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
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
		if($row['idsprogram'] == 'PPPP') { 
			$or = '222222-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-L';
		} else {
			$or = '222ARB-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-L';
		}
		
		$status = $row['status'];

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
				<td><label>NAME</label></td>
				<td colspan="2"><strong>'.$assured.'</strong></td>
				<td><small>'.$displaystat.'</small></td>
			</tr>

			<tr>
				<td><label>ADDRESS</label></td>
				<td>'.$address.'</td>
				<td><label>LOGBOOK</label></td>
				<td><strong><h4>'.$lslb.'</h4></strong></td>
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
				<td><strong>'.$or.'</strong></td>
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
	break;

	case 'YRRP':
		# code...
	$table = $obj->yrrp();
	$used_program = "YRRP";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
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
		$or = 'Y99999-'.substr($_SESSION['insurance'], -2).'-'.sprintf("%04d",$row['idsnumber']).'-L';
		$status = $row['status'];

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

		<table class="table table-condensed table-bordered font-md table-sm">
		<tr>
		<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>	
		<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>('.$used_program.')</strong></h5></td>
		</tr>
		<tr>
		<td><label>NAME</label></td>
		<td colspan="2"><strong>'.$assured.'</strong></td>
		<td><small>'.$displaystat.'</small></td>
		</tr>
		<tr>
		<td><label>ADDRESS</label></td>
		<td>'.$address.'</td>
		<td><label>LOGBOOK</label></td>
		<td><h4><strong>'.$lslb.'</strong></h4></td>
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
		<td><strong><strong>'.$or.'</strong></td>
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
	break;

	case "RRRR":
	#code...
	$table = $obj->regular();
	$used_program = "REGULAR";
	$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
	$result->execute([$idsnumber]);
	foreach ($result as $row) {
		$assured = strtoupper($row['assured']);
		$address = strtoupper($row['town']).', '.strtoupper($row['province']);
		$animal = strtoupper($row['animal']);
		$lsp = strtoupper($row['lsp']).''.sprintf("%04d",$row['idsnumber']);
		$premium_loading = strtoupper($row['loading']);
		$d_rcv = date("F j, Y",strtotime($row['date_r']));
		$groupname = strtoupper($row['groupName']);
		$lender = "";
		$dfrom = date('F j, Y', strtotime($row['Dfrom']));
		$dto = date('F j, Y', strtotime($row['Dto']));
		$sum_insured = number_format($row['amount_cover'],2);
		$rate = number_format($row['rate'],2); 
		$premium = $row['premium']; /* premium  - fetch from db */ 
		$doc_stamp = ($row['premium'] * (12.5 / 100)); /* Doc Stamp */ 
		$tax = ($row['premium'] * (5 / 100)); /* Tax */
		
		$total_gpremium = $premium + $doc_stamp + $tax; /* Total premium */
		

		
		$heads = $row['heads']; /* number of heads */
		$farmers = $row['farmers']; /* number of farmers */
		$lslb = $row['lslb']; 
		$or_num = $row['receiptNumber'];
		$or_amt = number_format($row['receiptAmt'],2);
		$s_charge = number_format($row['s_charge'],2);
		$remit = $total_gpremium - $s_charge;
		$iu = $row['iu'];
		$prepared = $row['prepared'];
		$status = $row['status'];
		
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

		<table class="table table-condensed table-bordered">
		<tr>
		<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>	
		<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>('.$used_program.')</strong></h5></td>
		</tr>
		<tr>
		<td><label>NAME</label></td>
		<td colspan="2"><strong>'.$assured.'</strong></td>
		<td><small>'.$displaystat.'</small></td>
		</tr>
		<tr>
		<td><label>ADDRESS</label></td>
		<td>'.$address.'</td>
		<td><label>LOGBOOK</label></td>
		<td><h4><strong>'.$lslb.'</strong></h4></td>
		</tr>
		<tr>
		<td><label>KIND OF ANIMAL + PURPOSE</label></td>
		<td>'.$animal.'</td>
		<td><label>POLICY NO.</label></td>
		<td><h4><strong>'.$lsp.'</strong></h4></td>
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
		<td>'.number_format($total_gpremium,2).'</td>		
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
		<td><strong>'.number_format($remit,2).'</strong></td>
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
	default:
		echo '<div class="page-header">No data found</div>';
	break;		
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


	
<?php if(isset($displaydata)) { 
	echo $displaydata 
	?>
	<div class="container">
		<p class="col-xs-4"><strong>BENITA M. ALBERTO</strong> <br><small>OIC-CHIEF, Marketing and Sales Division</small></p>
		<p class="col-xs-4"><?php echo $prepared ?> <br><small>Prepared By</small></p>
		<p class="col-xs-4"><?php echo $iu ?> <br><small>IU/Solicitor/AT</small></p>
	</div>

	<p class="text-center">__________________________________________________________________________________________________________________________________________________________________________________________</p>

	


	
</body>
</html>	

<?php
}
	
	else
	{
		echo 'Use checbox to select policy for processing slip. This tab will close after 3 seconds..';
		echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';
	}

?>

	
</body>
</html>	

