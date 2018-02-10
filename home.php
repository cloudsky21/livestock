<?PHP 
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');


if(!isset($_SESSION['isLogin']) || (!isset($_COOKIE["lx"]))) {

	header("location: logmeOut");
}



?>



<!DOCTYPE html>
<html>
<head>
	<title>Livestock Control <?php echo $_SESSION['insurance'] ?></title>
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta http-equiv="refresh" content="30">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="resources/bootswatch/materia/bootstrap.css">
	<link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="resources/css/local.css">
	<link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
	<script src="resources/bootstrap-4/js/jquery.js"></script>
	<script src="resources/bootstrap-4/umd/js/popper.js"></script>
	<script src="resources/bootstrap-4/js/bootstrap.js"></script>
	<script type="text/javascript" src="resources/multi-select/bootstrap-multiselect.js"></script>
	<meta http-equiv="content-type" content="text/html; charset=utf8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
</head>
<body>


	<div class="container-fluid">
		<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
				<!-- Brand -->
				<div class="container">
					<a class="navbar-brand" href="home">
						<img src="images/android-icon-48x48-1.png" alt="Logo" style="width:40px;"> Livestock Control</a>

					<!-- Toggler/collapsibe Button -->
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
						<span class="navbar-toggler-icon"></span>
					</button>

					<!-- Navbar links -->
					<div class="collapse navbar-collapse" id="collapsibleNavbar">
						
						<ul class="navbar-nav ml-auto">
							
							
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" id="navbardrop" data-toggle="dropdown">
									Programs 
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="programs/rsbsa">RSBSA</a>
									<a class="dropdown-item" href="programs/regular">Regular Program</a>
									<a class="dropdown-item" href="programs/apcp">APCP</a>
									<a class="dropdown-item" href="programs/acpc">Punla</a>
									<a class="dropdown-item" href="programs/agriagra">AGRI-AGRA</a>
									<a class="dropdown-item" href="#">SAAD</a>
								</div>
							</li>

							<li class="nav-item dropdown">

								<a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" data-toggle="dropdown">
									<span class="fa fa-gears"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									
									<?php 
									echo '<a class="dropdown-item disabled" href="#">'.$_SESSION['isLoginName'].'</a>';
									echo '<div class="dropdown-divider"></div>';
									if($_SESSION['stat']=="Admin") { ?>
									<a class="dropdown-item" href="year">Insurance Year</a>

									<a class="dropdown-item" href="farmers">Farmers List</a>
									<a class="dropdown-item" href="accounts">Accounts</a>
									<?php 
								}
								?>
								<a class="dropdown-item" href="comments">Comments</a>
								<a class="dropdown-item" href="locations">Locations</a>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="logmeOut"><i class="fa fa-sign-out" style="font-size:20px"></i></a></li>  
					</ul>

					

				</div>
			</div>
		</nav> 
	<?php
// control variable
	$rsbsa_cnt = "control".$_SESSION['insurance'];
	$regular_cnt = "controlr".$_SESSION['insurance'];
	$apcp_cnt = "controla".$_SESSION['insurance'];
	$pnl_cnt = "controlacpc".$_SESSION['insurance'];

	$query = "SELECT 
	(SELECT COUNT(*) FROM $rsbsa_cnt) as RSBSA,
	(SELECT COUNT(*) FROM $regular_cnt) as REGULAR,
	(SELECT COUNT(*) FROM $apcp_cnt) as APCP,
	(SELECT COUNT(*) FROM $pnl_cnt) as PUNLA,
	(SELECT SUM(premium) FROM $rsbsa_cnt) as RSBSAPREMIUM,
	(SELECT SUM(amount_cover) FROM $rsbsa_cnt) as RSBSAAC,
	(SELECT SUM(premium) FROM $regular_cnt) as REGPREMIUM,
	(SELECT SUM(amount_cover) FROM $regular_cnt) as REGAC,
	(SELECT SUM(premium) FROM $apcp_cnt) as APCPPREMIUM,
	(SELECT SUM(amount_cover) FROM $apcp_cnt) as APCPAC,
	(SELECT SUM(premium) FROM $pnl_cnt) as PNLPREMIUM,
	(SELECT SUM(amount_cover) FROM $pnl_cnt) as PNLAC,
	(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'Leyte1-2' ) as RSBSAL,
	(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'Leyte1-2' ) as REGL,
	(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'Leyte1-2' ) as APCPL,
	(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'Leyte1-2' ) as PNLL,
	(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO Ormoc' ) as RSBSAO,
	(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO Ormoc' ) as REGO,
	(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO Ormoc' ) as APCPO,
	(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO Ormoc' ) as PNLO,
	(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO Abuyog' ) as RSBSAA,
	(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO Abuyog' ) as REGA,
	(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO Abuyog' ) as APCPA,
	(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO Abuyog' ) as PNLA,
	(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO Sogod' ) as RSBSAS,
	(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO Sogod' ) as REGS,
	(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO Sogod' ) as APCPS,
	(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO Sogod' ) as PNLS,
	(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO W-Samar' ) as RSBSAWS,
	(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO W-Samar' ) as REGWS,
	(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO W-Samar' ) as APCPWS,
	(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO W-Samar' ) as PNLWS,
	(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO E-Samar' ) as RSBSAES,
	(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO E-Samar' ) as REGES,
	(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO E-Samar' ) as APCPES,
	(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO E-Samar' ) as PNLES,
	(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO N-Samar' ) as RSBSANS,
	(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO N-Samar' ) as REGNS,
	(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO N-Samar' ) as APCPNS,
	(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO N-Samar' ) as PNLNS,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Carabao%' ) as CARBRSBSA,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Cattle%' ) as CATRSBSA,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Horse%' ) as HORSBSA,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Goat%' ) as GORSBSA,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Sheep%' ) as SHRSBSA,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Swine%' ) as SWRSBSA,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal = 'Poultry-Broilers' ) as PMRSBSA,
	(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal = 'Poultry-Layers' ) as PERSBSA,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Carabao%' ) as CARBREG,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Cattle%' ) as CATREG,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Horse%' ) as HOREG,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Goat%' ) as GOREG,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Sheep%' ) as SHREG,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Swine%' ) as SWREG,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal = 'Poultry-Broilers' ) as PMREG,
	(SELECT SUM(heads) FROM $regular_cnt WHERE animal = 'Poultry-Layers' ) as PEREG,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Carabao%' ) as CARBAPCP,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Cattle%' ) as CATAPCP,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Horse%' ) as HOAPCP,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Goat%' ) as GOAPCP,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Sheep%' ) as SHAPCP,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Swine%' ) as SWAPCP,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal = 'Poultry-Broilers' ) as PMAPCP,
	(SELECT SUM(heads) FROM $apcp_cnt WHERE animal = 'Poultry-Layers' ) as PEAPCP,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Carabao%' ) as CARBPNL,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Cattle%' ) as CATPNL,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Horse%' ) as HOPNL,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Goat%' ) as GOPNL,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Sheep%' ) as SHPNL,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Swine%' ) as SWPNL,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal = 'Poultry-Broilers' ) as PMPNL,
	(SELECT SUM(heads) FROM $pnl_cnt WHERE animal = 'Poultry-Layers' ) as PEPNL";
	$result = $db->prepare($query);
	$result->execute();

	foreach ($result as $row) {
		
		$TRsbsa = number_format($row['RSBSA']);
		$TReg = number_format($row['REGULAR']);
		$TApcp = number_format($row['APCP']);
		$TPnl = number_format($row['PUNLA']);
	//PREMIUM
		$RSBSA_prem = number_format($row['RSBSAPREMIUM'],2);
		$REG_prem = number_format($row['REGPREMIUM'],2);
		$APCP_prem = number_format($row['APCPPREMIUM'],2);
		$PNL_prem = number_format($row['PNLPREMIUM'],2);
	//AC
		$RSBSA_ac = number_format($row['RSBSAAC'],2);
		$REG_ac = number_format($row['REGAC'],2);
		$APCP_ac = number_format($row['APCPAC'],2);
		$PNL_ac = number_format($row['PNLAC'],2);
	//Leyte 1 - 2
		$LRsbsa = number_format($row['RSBSAL']);
		$LReg = number_format($row['REGL']);
		$LApcp = number_format($row['APCPL']);
		$LPnl = number_format($row['PNLL']);
	//PEO Ormoc
		$ORsbsa = number_format($row['RSBSAO']);
		$OReg = number_format($row['REGO']);
		$OApcp = number_format($row['APCPO']);
		$OPnl = number_format($row['PNLO']);
	//PEO Abuyog
		$ARsbsa = number_format($row['RSBSAA']);
		$AReg = number_format($row['REGA']);
		$AApcp = number_format($row['APCPA']);
		$APnl = number_format($row['PNLA']);
	//PEO Sogod
		$SRsbsa = number_format($row['RSBSAS']);
		$SReg = number_format($row['REGS']);
		$SApcp = number_format($row['APCPS']);
		$SPnl = number_format($row['PNLS']);
	//PEO Western Samar
		$WSRsbsa = number_format($row['RSBSAWS']);
		$WSReg = number_format($row['REGWS']);
		$WSApcp = number_format($row['APCPWS']);
		$WSPnl = number_format($row['PNLWS']);
	//PEO Eastern Samar
		$ESRsbsa = number_format($row['RSBSAES']);
		$ESReg = number_format($row['REGES']);
		$ESApcp = number_format($row['APCPES']);
		$ESPnl = number_format($row['PNLES']);
	//PEO Western Samar
		$WSRsbsa = number_format($row['RSBSAWS']);
		$WSReg = number_format($row['REGWS']);
		$WSApcp = number_format($row['APCPWS']);
		$WSPnl = number_format($row['PNLWS']);

	//Animal Count
		$RSBSA_WB = number_format($row['CARBRSBSA']);
		$RSBSA_CA = number_format($row['CATRSBSA']);
		$RSBSA_HO = number_format($row['HORSBSA']);
		$RSBSA_GO = number_format($row['GORSBSA']);
		$RSBSA_SH = number_format($row['SHRSBSA']);
		$RSBSA_SW = number_format($row['SWRSBSA']);
		$RSBSA_PM = number_format($row['PMRSBSA']);
		$RSBSA_PE = number_format($row['PERSBSA']);

		$REG_WB = number_format($row['CARBREG']);
		$REG_CA = number_format($row['CATREG']);
		$REG_HO = number_format($row['HOREG']);
		$REG_GO = number_format($row['GOREG']);
		$REG_SH = number_format($row['SHREG']);
		$REG_SW = number_format($row['SWREG']);
		$REG_PM = number_format($row['PMREG']);
		$REG_PE = number_format($row['PEREG']);

		$APCP_WB = number_format($row['CARBAPCP']);
		$APCP_CA = number_format($row['CATAPCP']);
		$APCP_HO = number_format($row['HOAPCP']);
		$APCP_GO = number_format($row['GOAPCP']);
		$APCP_SH = number_format($row['SHAPCP']);
		$APCP_SW = number_format($row['SWAPCP']);
		$APCP_PM = number_format($row['PMAPCP']);
		$APCP_PE = number_format($row['PEAPCP']);

		$PNL_WB = number_format($row['CARBPNL']);
		$PNL_CA = number_format($row['CATPNL']);
		$PNL_HO = number_format($row['HOPNL']);
		$PNL_GO = number_format($row['GOPNL']);
		$PNL_SH = number_format($row['SHPNL']);
		$PNL_SW = number_format($row['SWPNL']);
		$PNL_PM = number_format($row['PMPNL']);
		$PNL_PE = number_format($row['PEPNL']);
		

	}



	?>	
	<div style="margin-top: 100px;">
		<h3 class="text-center">Detailed Information<small> as of <?php echo $_SESSION['insurance'] ?></small></h3>
		<table class="table table-bordered table-condensed">
			<thead>
				<tr>
					<th>Program</th>
					<th>Leyte 1 -2</th>
					<th>Ormoc</th>
					<th>Abuyog</th>
					<th>Sogod</th>
					<th>WS</th>
					<th>ES</th>
					<th>NS</th>
					<th>TOTAL</th>
					<th>AMOUNT COVER</th>
					<th>PREMIUM</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>RSBSA</td>
					<td><?php echo $LRsbsa; ?></td>
					<td><?php echo $ORsbsa; ?></td>
					<td><?php echo $ARsbsa; ?></td>
					<td><?php echo $SRsbsa; ?></td>
					<td><?php echo $WSRsbsa; ?></td>
					<td><?php echo $ESRsbsa; ?></td>
					<td><?php echo $WSRsbsa; ?></td>
					<td><?php echo $TRsbsa; ?></td>
					<td><?php echo $RSBSA_ac; ?></td>
					<td><?php echo $RSBSA_prem; ?></td>
				</tr>

				<tr>
					<td>REGULAR PROGRAM</td>
					<td><?php echo $LReg; ?></td>
					<td><?php echo $OReg; ?></td>
					<td><?php echo $AReg; ?></td>
					<td><?php echo $SReg; ?></td>
					<td><?php echo $WSReg; ?></td>
					<td><?php echo $ESReg; ?></td>
					<td><?php echo $WSReg; ?></td>
					<td><?php echo $TReg; ?></td>
					<td><?php echo $REG_ac; ?></td>
					<td><?php echo $REG_prem; ?></td>
				</tr>

				<tr>
					<td>APCP</td>
					<td><?php echo $LApcp; ?></td>
					<td><?php echo $OApcp; ?></td>
					<td><?php echo $AApcp; ?></td>
					<td><?php echo $SApcp; ?></td>
					<td><?php echo $WSApcp; ?></td>
					<td><?php echo $ESApcp; ?></td>
					<td><?php echo $WSApcp; ?></td>
					<td><?php echo $TApcp; ?></td>
					<td><?php echo $APCP_ac; ?></td>
					<td><?php echo $APCP_prem; ?></td>
				</tr>

				<tr>
					<td>PUNLA</td>
					<td><?php echo $LPnl; ?></td>
					<td><?php echo $OPnl; ?></td>
					<td><?php echo $APnl; ?></td>
					<td><?php echo $SPnl; ?></td>
					<td><?php echo $WSPnl; ?></td>
					<td><?php echo $ESPnl; ?></td>
					<td><?php echo $WSPnl; ?></td>
					<td><?php echo $TPnl; ?></td>
					<td><?php echo $PNL_ac; ?></td>
					<td><?php echo $PNL_prem; ?></td>
				</tr>
			</tbody>
		</table>

		<!-- Table two -->
		<h3 class="text-center">Head Count</h3>
		<table class="table table-bordered table-condensed">
			<thead>
				<tr>
					<th>PROGRAM</th>
					<th>CARABAO</th>
					<th>CATTLE/COW</th>
					<th>HORSE</th>
					<th>GOAT</th>
					<th>SHEEP</th>
					<th>SWINE</th>
					<th>POULTRY - BROILERS</th>
					<th>POULTRY - LAYERS</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td>RSBSA</td>
					<td><?php echo $RSBSA_WB ?></td>
					<td><?php echo $RSBSA_CA ?></td>
					<td><?php echo $RSBSA_HO ?></td>
					<td><?php echo $RSBSA_GO ?></td>
					<td><?php echo $RSBSA_SH ?></td>
					<td><?php echo $RSBSA_SW ?></td>
					<td><?php echo $RSBSA_PM ?></td>
					<td><?php echo $RSBSA_PE ?></td>
				</tr>
				<tr>
					<td>REGULAR</td>
					<td><?php echo $REG_WB ?></td>
					<td><?php echo $REG_CA ?></td>
					<td><?php echo $REG_HO ?></td>
					<td><?php echo $REG_GO ?></td>
					<td><?php echo $REG_SH ?></td>
					<td><?php echo $REG_SW ?></td>
					<td><?php echo $REG_PM ?></td>
					<td><?php echo $REG_PE ?></td>
				</tr>
				<tr>
					<td>APCP</td>
					<td><?php echo $APCP_WB ?></td>
					<td><?php echo $APCP_CA ?></td>
					<td><?php echo $APCP_HO ?></td>
					<td><?php echo $APCP_GO ?></td>
					<td><?php echo $APCP_SH ?></td>
					<td><?php echo $APCP_SW ?></td>
					<td><?php echo $APCP_PM ?></td>
					<td><?php echo $APCP_PE ?></td>
				</tr>
				<tr>
					<td>PUNLA</td>
					<td><?php echo $PNL_WB ?></td>
					<td><?php echo $PNL_CA ?></td>
					<td><?php echo $PNL_HO ?></td>
					<td><?php echo $PNL_GO ?></td>
					<td><?php echo $PNL_SH ?></td>
					<td><?php echo $PNL_SW ?></td>
					<td><?php echo $PNL_PM ?></td>
					<td><?php echo $PNL_PE ?></td>
				</tr>
			</tbody>

		</table>
	</div>
</div>
</body>
</html>