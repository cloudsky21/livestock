<?php
session_start();
require 'add-ons/mpdf/mpdf.php';
require "connection/conn.php";
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

if(isset($_POST['submit'])) {
	/* SWITCH FOR PROGRAM TYPE */
	switch ($_POST['program']) {
		case 'rsbsa':
		$objtable = $obj->rsbsa();
		$result = $db->prepare("SELECT * FROM `$objtable` WHERE office_assignment = ? and status = ?");
		$program = "RSBSA Reports (".ucwords($_POST['stats']).") <br>".$_POST['office']."";
		break;

		case 'agri':
		$objtable = $obj->agriagra();
		$result = $db->prepare("SELECT * FROM `$objtable` WHERE office_assignment = ? and status = ?");
		$program = 'AGRI-AGRA Reports ('.ucwords($_POST['stats']).') <br>'.$_POST['office'].'';
		break;
		
		default:
			# code...
		break;
	}
	/*-------------------*/

	$html .= '<!DOCTYPE html>';
	$html .= '<html>';
	$html .= '<head>';
	$html .= '<link rel="stylesheet" href="resources/css/media.css">';
	$html .= '<style>@page {
     margin: 50px;
    }</style>';
	$html .= '</head>';
	$html .= '<body style="font-size: 10pt;">';
	$html .= '<h2 class="text-center">'.$program.'</h2>';
	$html .= '<table class="table table-condensed table-sm table-bordered">';
	/* HEADERS */
	$html .='<thead>';
	$html .='<tr>';
	$html .='<th>Logbook</th>';	
	$html .='<th>LIP</th>';
	$html .='<th>Farmer ID</th>';
	$html .='<th>Assured</th>';
	$html .='<th>Animal</th>';	
	$html .='<th>Head</th>';	
	$html .='<th>Note</th>';
	$html .='</tr>';
	$html .='</thead>';
	/*----*/

	/* BODY */
	$html .='<tbody>';

	
	$result->execute([$_POST['office'], $_POST['stats']]);

	$count = $result->rowcount();

	if($count > 0) {

		foreach ($result as $value) {
			$html .='<tr>';
			$html .='<td align="left">'.$value['lslb'].'</td>';			
			$html .='<td align="left">'.$value['lsp'].sprintf("%04d", $value['idsnumber']).'-'.$value['idsprogram'].'</td>';
			if($value['f_id']!='0'){$html .='<td align="left">'.$value['f_id'].'</td>';} else {$html .='<td>&nbsp;</td>';}
			$html .='<td align="left">'.$value['assured'].'</td>';
			$html .='<td align="left">'.$value['animal'].'</td>';	
			$html .='<td align="left">'.$value['heads'].'</td>';			
			$html .='<td align="left">'.$value['comments'].'</td>';
			$html .='</tr>';
		}		

	}

	$html .='</tbody>';

	/*----*/

	$html .= '</table>';
	$html .= '</body>';
	$html .= '</html>';


	$mpdf = new mPDF('','A4');
	
	$mpdf->WriteHTML($html);
	$mpdf->Output();
	exit();




}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reports LIPs | Livestock Control</title>	

	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link rel="shortcut icon" href="images/favicon.ico">

	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css">
	<link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="resources/css/local.css">
	<link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
	<link rel="stylesheet" href="resources/jquery-ui-1.12.1.custom/jquery-ui.css">
	<script src="resources/bootstrap-4/js/jquery.js"></script>
	<script src="resources/bootstrap-4/umd/js/popper.js"></script>
	<script src="resources/bootstrap-4/js/bootstrap.js"></script>
	<script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
	<script type="text/javascript" src="resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
	
</head>
<body>
	<div class="container">
		<div class="jumbotron" style="margin-top: 50px;">
			<h1 class="display-4">LIP Status</h1>
			<hr class="my-4">
			<form method="post" action="" target="_blank" autocomplete="off">
				<div class="form-group">
					<div style="margin-top: -10px; margin-bottom: -30px;" class="col-centered">			
						<table class="table table-condensed table-sm">
							<tr>
								<th scope="row">Program</th>
								<td>
									<select name="program" class="form-control form-control-sm">
										<option value="rsbsa">RSBSA</option>
										<option value="agri">AGRI-AGRA</option>
										<option value="acpc">ACPC - PUNLA</option>
										<option value="apcp">APCP</option>
										<option value="regular">REGULAR</option>
										<option value="saad">SAAD</option>
										<option value="yrrp">YRRP</option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row">Office</th>
								<td>
									<select name="office" class="form-control form-control-sm">
										<!--<option value="*" selected>All (Default)</option>-->
										<option value="PEO Tacloban">Tacloban Extension</option>
										<option value="PEO Biliran">Biliran Extension</option>
										<option value="PEO Ormoc">Ormoc Extension</option>
										<option value="PEO Abuyog">Abuyog Extension</option>
										<option value="PEO Hilongos">Hilongos Extension</option>
										<option value="PEO Sogod">Sogod Extension</option>
										<option value="PEO W-Samar">Western Samar Extension</option>
										<option value="PEO E-Samar">Eastern Samar Extension</option>
										<option value="PEO N-Samar">Northern Samar Extension</option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row">Status</th>
								<td>
									<select name="stats" class="form-control form-control-sm" required>
										<option value="active" selected>Active / For Encoding</option>
										<option value="evaluated">Evaluated</option>
										<option value="hold">Hold</option>
										<option value="cancelled">Cancelled</option>															
									</select>
								</td>
							</tr>										
						</table>		
						<input type="submit" name="submit" value="Extract" class="form-control btn btn-primary">
					</div>
				</div>
			</form>			
		</div><!-- End JUMBOTRON -->		
	</div><!-- End Container -->
</body>
</html>