<?php
session_start();

require_once "connection/conn.php";
require 'myload.php';

date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

$rsbsa_cnt = $obj->rsbsa();
$regular_cnt = $obj->regular();
$apcp_cnt = $obj->apcp();
$pnl_cnt = $obj->acpc();
$agri_cnt = $obj->agriagra();
$saad = $obj->saad();
$yrrp = $obj->yrrp();

if (!isset($_SESSION['token'])) {
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
    <link rel="stylesheet"
        href="resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css?v=<?= filemtime('resources/bootswatch/' . $_SESSION['mode'] . '/bootstrap.css') ?>"
        media="screen">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/local.css">
    <link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
    <script src="resources/bootstrap-4/js/jquery.js"></script>
    <script src="resources/bootstrap-4/umd/js/popper.js"></script>
    <script src="resources/bootstrap-4/js/bootstrap.js"></script>
    <script type="text/javascript" src="resources/multi-select/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  <script type='text/javascript' src="resources/html5shiv/src/html5shiv.js"></script>
  <script type='text/javascript' src="resources/Respond/src/respond.js"></script>
<![endif]-->
    <meta http-equiv="content-type" content="text/html; charset=utf8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
</head>

<body>
    <?php switch ($_SESSION['mode']) {
        case 'solar':
            echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
            break;

        case 'lumen':
            echo '<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="top">';
            break;

        case 'darkly':
            echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="top">';
            break;

        case 'slate':
            echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
            break;

        case 'cyborg':
            echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
            break;

        case 'pulse':
            echo '<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="top">';
            break;

        default:
            echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
            break;
    }
    ?>
    <!-- Brand -->
    <div class="container">
        <a class="navbar-brand mx-auto" href="home">
            <h3>Livestock</h3>
            <p style="margin-top:-10px; margin-bottom: 0px; font: 12px Open Sans; color: #aaa; text-shadow: none;">
                Control / Policy Issuance</p>
        </a>

        <!-- Toggler/collapsibe Button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="collapsibleNavbar">

            <ul class="navbar-nav ml-auto">


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <span class="fa fa-navicon"></span> Programs
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="programs/rsbsa">RSBSA</a>
                        <a class="dropdown-item" href="programs/regular">Regular Program</a>
                        <a class="dropdown-item" href="programs/apcp">APCP</a>
                        <a class="dropdown-item" href="programs/acpc">Punla</a>
                        <a class="dropdown-item" href="programs/agriagra">AGRI-AGRA</a>
                        <a class="dropdown-item" href="programs/saad">SAAD</a>
                        <a class="dropdown-item" href="programs/yrrp">YRRP</a>
                        <a class="dropdown-item" href="programs/type?core=1">Sample</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="main_search"><span class="fa fa-search"></span> Farmer Search</a>
                    </div>
                </li>

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" data-toggle="dropdown">
                        <span class="fa fa-gears"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">

                        <?php
                        echo '<a class="dropdown-item disabled" href="#">' . $_SESSION['isLoginName'] . '</a>';
                        echo '<div class="dropdown-divider"></div>';
                        if ($_SESSION['stat'] == "Main") { ?>
                        <a class="dropdown-item" href="year">Insurance Year</a>

                        <a class="dropdown-item" href="accounts">Accounts</a>
                        <a class="dropdown-item" href="masterlist">RSBSA List</a>
                        <a class="dropdown-item" href="checkbox" target="_blank">Checklist</a>
                        <a class="dropdown-item" href="extract" target="_blank">Extract LIPs</a>
                        <?php
                        }
                        ?>
                        <a class="dropdown-item" href="farmers">Farmers List</a>
                        <a class="dropdown-item" href="reports">Reports</a>
                        <a class="dropdown-item" href="locations">Locations</a>
                        <a class="dropdown-item" href="printform">Batch Printing</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logmeOut"><i class="fa fa-sign-out" style="font-size:20px"></i></a></li>
            </ul>



        </div>
    </div>
    </nav>

    <div class="container-fluid">
        <?php
        try {

            $query = "SELECT
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE status != 'cancelled') as RSBSA,
				(SELECT COUNT(*) FROM $regular_cnt WHERE status != 'cancelled') as REGULAR,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE status != 'cancelled') as APCP,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE status != 'cancelled') as PUNLA,
				(SELECT COUNT(*) FROM $agri_cnt WHERE status != 'cancelled') as AGRI,
				(SELECT COUNT(*) FROM $yrrp WHERE status != 'cancelled') as YRRP,
				(SELECT SUM(premium) FROM $rsbsa_cnt WHERE status != 'cancelled') as RSBSAPREMIUM,
				(SELECT SUM(amount_cover) FROM $rsbsa_cnt WHERE status != 'cancelled') as RSBSAAC,
				(SELECT SUM(premium) FROM $regular_cnt WHERE status != 'cancelled') as REGPREMIUM,
				(SELECT SUM(amount_cover) FROM $regular_cnt WHERE status != 'cancelled') as REGAC,
				(SELECT SUM(premium) FROM $apcp_cnt WHERE status != 'cancelled') as APCPPREMIUM,
				(SELECT SUM(amount_cover) FROM $apcp_cnt WHERE status != 'cancelled') as APCPAC,
				(SELECT SUM(premium) FROM $pnl_cnt WHERE status != 'cancelled') as PNLPREMIUM,
				(SELECT SUM(amount_cover) FROM $pnl_cnt WHERE status != 'cancelled') as PNLAC,
				(SELECT SUM(premium) FROM $agri_cnt WHERE status != 'cancelled') as AGRIPREMIUM,
				(SELECT SUM(amount_cover) FROM $agri_cnt WHERE status != 'cancelled') as AGRIAC,
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO TACLOBAN' and status != ' cancelled') as RSBSAL,
				(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO TACLOBAN' and status != ' cancelled' ) as REGL,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO TACLOBAN' and status != ' cancelled' ) as APCPL,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO TACLOBAN' and status != ' cancelled' ) as PNLL,
				(SELECT COUNT(*) FROM $agri_cnt WHERE office_assignment = 'PEO TACLOBAN' and status != ' cancelled' ) as AGRIL,
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO Ormoc' and status != ' cancelled' ) as RSBSAO,
				(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO Ormoc' and status != ' cancelled' ) as REGO,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO Ormoc' and status != ' cancelled' ) as APCPO,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO Ormoc' and status != ' cancelled' ) as PNLO,
				(SELECT COUNT(*) FROM $agri_cnt WHERE office_assignment = 'PEO Ormoc' and status != ' cancelled' ) as AGRIO,
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO Abuyog' and status != ' cancelled' ) as RSBSAA,
				(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO Abuyog' and status != ' cancelled' ) as REGA,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO Abuyog' and status != ' cancelled' ) as APCPA,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO Abuyog' and status != ' cancelled' ) as PNLA,
				(SELECT COUNT(*) FROM $agri_cnt WHERE office_assignment = 'PEO Abuyog' and status != ' cancelled' ) as AGRIA,
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO Sogod' and status != ' cancelled' ) as RSBSAS,
				(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO Sogod' and status != ' cancelled' ) as REGS,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO Sogod' and status != ' cancelled' ) as APCPS,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO Sogod' and status != ' cancelled' ) as PNLS,
				(SELECT COUNT(*) FROM $agri_cnt WHERE office_assignment = 'PEO Sogod' and status != ' cancelled' ) as AGRIS,
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO W-Samar' and status != ' cancelled' ) as RSBSAWS,
				(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO W-Samar' and status != ' cancelled' ) as REGWS,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO W-Samar' and status != ' cancelled' ) as APCPWS,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO W-Samar' and status != ' cancelled' ) as PNLWS,
				(SELECT COUNT(*) FROM $agri_cnt WHERE office_assignment = 'PEO W-Samar' and status != ' cancelled' ) as AGRIWS,
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO E-Samar' and status != ' cancelled' ) as RSBSAES,
				(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO E-Samar' and status != ' cancelled' ) as REGES,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO E-Samar' and status != ' cancelled' ) as APCPES,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO E-Samar' and status != ' cancelled' ) as PNLES,
				(SELECT COUNT(*) FROM $agri_cnt WHERE office_assignment = 'PEO E-Samar' and status != ' cancelled' ) as AGRIES,
				(SELECT COUNT(*) FROM $rsbsa_cnt WHERE office_assignment = 'PEO N-Samar' and status != ' cancelled' ) as RSBSANS,
				(SELECT COUNT(*) FROM $regular_cnt WHERE office_assignment = 'PEO N-Samar' and status != ' cancelled' ) as REGNS,
				(SELECT COUNT(*) FROM $apcp_cnt WHERE office_assignment = 'PEO N-Samar' and status != ' cancelled' ) as APCPNS,
				(SELECT COUNT(*) FROM $pnl_cnt WHERE office_assignment = 'PEO N-Samar' and status != ' cancelled' ) as PNLNS,
				(SELECT COUNT(*) FROM $agri_cnt WHERE office_assignment = 'PEO N-Samar' and status != ' cancelled' ) as AGRINS,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Carabao%' and status != ' cancelled' ) as CARBRSBSA,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Cattle%' and status != ' cancelled' ) as CATRSBSA,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Horse%' and status != ' cancelled' ) as HORSBSA,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Goat%' and status != ' cancelled' ) as GORSBSA,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Sheep%' and status != ' cancelled' ) as SHRSBSA,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal LIKE 'Swine%' and status != ' cancelled' ) as SWRSBSA,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal = 'Poultry-Broilers' and status != ' cancelled' ) as PMRSBSA,
				(SELECT SUM(heads) FROM $rsbsa_cnt WHERE animal = 'Poultry-Layers' and status != ' cancelled' ) as PERSBSA,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal LIKE 'Carabao%' and status != ' cancelled' ) as CARBAGRI,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal LIKE 'Cattle%' and status != ' cancelled' ) as CATAGRI,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal LIKE 'Horse%' and status != ' cancelled' ) as HOAGRI,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal LIKE 'Goat%' and status != ' cancelled' ) as GOAGRI,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal LIKE 'Sheep%' and status != ' cancelled' ) as SHAGRI,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal LIKE 'Swine%' and status != ' cancelled' ) as SWAGRI,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal = 'Poultry-Broilers' and status != ' cancelled' ) as PMAGRI,
				(SELECT SUM(heads) FROM $agri_cnt WHERE animal = 'Poultry-Layers' and status != ' cancelled' ) as PEAGRI,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Carabao%' and status != ' cancelled' ) as CARBREG,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Cattle%' and status != ' cancelled' ) as CATREG,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Horse%' and status != ' cancelled' ) as HOREG,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Goat%' and status != ' cancelled' ) as GOREG,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Sheep%' and status != ' cancelled' ) as SHREG,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal LIKE 'Swine%' and status != ' cancelled' ) as SWREG,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal = 'Poultry-Broilers' and status != ' cancelled' ) as PMREG,
				(SELECT SUM(heads) FROM $regular_cnt WHERE animal = 'Poultry-Layers' and status != ' cancelled' ) as PEREG,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Carabao%' and status != ' cancelled' ) as CARBAPCP,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Cattle%' and status != ' cancelled' ) as CATAPCP,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Horse%' and status != ' cancelled' ) as HOAPCP,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Goat%' and status != ' cancelled' ) as GOAPCP,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Sheep%' and status != ' cancelled' ) as SHAPCP,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal LIKE 'Swine%' and status != ' cancelled' ) as SWAPCP,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal = 'Poultry-Broilers' and status != ' cancelled' ) as PMAPCP,
				(SELECT SUM(heads) FROM $apcp_cnt WHERE animal = 'Poultry-Layers' and status != ' cancelled' ) as PEAPCP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal LIKE 'Carabao%' and status != ' cancelled' ) as CARBYRRP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal LIKE 'Cattle%' and status != ' cancelled' ) as CATYRRP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal LIKE 'Horse%' and status != ' cancelled' ) as HOYRRP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal LIKE 'Goat%' and status != ' cancelled' ) as GOYRRP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal LIKE 'Sheep%' and status != ' cancelled' ) as SHYRRP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal LIKE 'Swine%' and status != ' cancelled' ) as SWYRRP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal = 'Poultry-Broilers' and status != ' cancelled' ) as PMYRRP,
				(SELECT SUM(heads) FROM $yrrp WHERE animal = 'Poultry-Layers' and status != ' cancelled' ) as PEYRRP,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Carabao%' and status != ' cancelled' ) as CARBPNL,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Cattle%' and status != ' cancelled' ) as CATPNL,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Horse%' and status != ' cancelled' ) as HOPNL,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Goat%' and status != ' cancelled' ) as GOPNL,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Sheep%' and status != ' cancelled' ) as SHPNL,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal LIKE 'Swine%' and status != ' cancelled' ) as SWPNL,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal = 'Poultry-Broilers' and status != ' cancelled' ) as PMPNL,
				(SELECT SUM(heads) FROM $pnl_cnt WHERE animal = 'Poultry-Layers' and status != ' cancelled' ) as PEPNL";
            $result = $db->prepare($query);
            $result->execute();

            foreach ($result as $row) {

                $TRsbsa = number_format($row['RSBSA']);
                $TReg = number_format($row['REGULAR']);
                $TApcp = number_format($row['APCP']);
                $TPnl = number_format($row['PUNLA']);
                $TAgri = number_format($row['AGRI']);
                $TYrrp = number_format($row['YRRP']);
                //PREMIUM
                $RSBSA_prem = number_format($row['RSBSAPREMIUM'], 2);
                $REG_prem = number_format($row['REGPREMIUM'], 2);
                $APCP_prem = number_format($row['APCPPREMIUM'], 2);
                $PNL_prem = number_format($row['PNLPREMIUM'], 2);
                $AGRI_prem = number_format($row['AGRIPREMIUM'], 2);
                //AC
                $RSBSA_ac = number_format($row['RSBSAAC'], 2);
                $REG_ac = number_format($row['REGAC'], 2);
                $APCP_ac = number_format($row['APCPAC'], 2);
                $PNL_ac = number_format($row['PNLAC'], 2);
                $AGRI_ac = number_format($row['AGRIAC'], 2);
                //Leyte 1 - 2
                $LRsbsa = number_format($row['RSBSAL']);
                $LReg = number_format($row['REGL']);
                $LApcp = number_format($row['APCPL']);
                $LPnl = number_format($row['PNLL']);
                $LAgri = number_format($row['AGRIL']);
                //PEO Ormoc
                $ORsbsa = number_format($row['RSBSAO']);
                $OReg = number_format($row['REGO']);
                $OApcp = number_format($row['APCPO']);
                $OPnl = number_format($row['PNLO']);
                $OAgri = number_format($row['AGRIO']);
                //PEO Abuyog
                $ARsbsa = number_format($row['RSBSAA']);
                $AReg = number_format($row['REGA']);
                $AApcp = number_format($row['APCPA']);
                $APnl = number_format($row['PNLA']);
                $AAgri = number_format($row['AGRIA']);
                //PEO Sogod
                $SRsbsa = number_format($row['RSBSAS']);
                $SReg = number_format($row['REGS']);
                $SApcp = number_format($row['APCPS']);
                $SPnl = number_format($row['PNLS']);
                $SAgri = number_format($row['AGRIS']);
                //PEO Western Samar
                $WSRsbsa = number_format($row['RSBSAWS']);
                $WSReg = number_format($row['REGWS']);
                $WSApcp = number_format($row['APCPWS']);
                $WSPnl = number_format($row['PNLWS']);
                $WSAgri = number_format($row['AGRIWS']);
                //PEO Eastern Samar
                $ESRsbsa = number_format($row['RSBSAES']);
                $ESReg = number_format($row['REGES']);
                $ESApcp = number_format($row['APCPES']);
                $ESPnl = number_format($row['PNLES']);
                $ESAgri = number_format($row['AGRIES']);
                //PEO Northern Samar
                $NSRsbsa = number_format($row['RSBSANS']);
                $NSReg = number_format($row['REGNS']);
                $NSApcp = number_format($row['APCPNS']);
                $NSPnl = number_format($row['PNLNS']);
                $NSAgri = number_format($row['AGRINS']);

                //Animal Count
                $RSBSA_WB = number_format($row['CARBRSBSA']);
                $RSBSA_CA = number_format($row['CATRSBSA']);
                $RSBSA_HO = number_format($row['HORSBSA']);
                $RSBSA_GO = number_format($row['GORSBSA']);
                $RSBSA_SH = number_format($row['SHRSBSA']);
                $RSBSA_SW = number_format($row['SWRSBSA']);
                $RSBSA_PM = number_format($row['PMRSBSA']);
                $RSBSA_PE = number_format($row['PERSBSA']);

                $AGRI_WB = number_format($row['CARBAGRI']);
                $AGRI_CA = number_format($row['CATAGRI']);
                $AGRI_HO = number_format($row['HOAGRI']);
                $AGRI_GO = number_format($row['GOAGRI']);
                $AGRI_SH = number_format($row['SHAGRI']);
                $AGRI_SW = number_format($row['SWAGRI']);
                $AGRI_PM = number_format($row['PMAGRI']);
                $AGRI_PE = number_format($row['PEAGRI']);

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

                $YRRP_WB = number_format($row['CARBYRRP']);
                $YRRP_CA = number_format($row['CATYRRP']);
                $YRRP_HO = number_format($row['HOYRRP']);
                $YRRP_GO = number_format($row['GOYRRP']);
                $YRRP_SH = number_format($row['SHYRRP']);
                $YRRP_SW = number_format($row['SWYRRP']);
                $YRRP_PM = number_format($row['PMYRRP']);
                $YRRP_PE = number_format($row['PEYRRP']);
            }
            ?>
        <?php
            $date = date("Y-m-d");
            $user = $_SESSION['isLoginName'];
            $sqlQuery = "SELECT
				(SELECT SUM(farmers) FROM $rsbsa_cnt WHERE prepared = '$user' AND date_r = '$date') AS rsbsa,
				(SELECT SUM(farmers) FROM $regular_cnt WHERE prepared = '$user' AND date_r = '$date') AS regular,
				(SELECT SUM(farmers) FROM $apcp_cnt WHERE prepared = '$user' AND date_r = '$date') AS apcp,
				(SELECT SUM(farmers) FROM $pnl_cnt WHERE prepared = '$user' AND date_r = '$date') AS pnl,
				(SELECT SUM(farmers) FROM $agri_cnt WHERE prepared = '$user' AND date_r = '$date') AS agri,
				(SELECT SUM(farmers) FROM $saad WHERE prepared = '$user' AND date_r = '$date') AS saad,
				(SELECT SUM(farmers) FROM $yrrp WHERE prepared = '$user' AND date_r = '$date') AS yrrp";

            $result = $db->prepare($sqlQuery);
            $result->execute();

            foreach ($result as $key => $values) {
                $total_user_count = array_sum($values);
            }

            $sample_date = date("Y-m-d", strtotime('+1 year'));

            ?>
        <div style="margin-top: 50px;">
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
                        <td><?php echo $NSPnl; ?></td>
                        <td><?php echo $TPnl; ?></td>
                        <td><?php echo $PNL_ac; ?></td>
                        <td><?php echo $PNL_prem; ?></td>
                    </tr>
                    <tr>
                        <td>AGRI-AGRA</td>
                        <td><?php echo $LAgri ?></td>
                        <td><?php echo $OAgri ?></td>
                        <td><?php echo $AAgri ?></td>
                        <td><?php echo $SAgri ?></td>
                        <td><?php echo $WSAgri ?></td>
                        <td><?php echo $ESAgri ?></td>
                        <td><?php echo $NSAgri ?></td>
                        <td><?php echo $TAgri; ?></td>
                        <td><?php echo $AGRI_ac; ?></td>
                        <td><?php echo $AGRI_prem; ?></td>
                    </tr>
                    <tr>
                        <td>YRRP</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $TYrrp; ?></td>
                        <td></td>
                        <td></td>
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
                        <td>AGRI-AGRA</td>
                        <td><?php echo $AGRI_WB ?></td>
                        <td><?php echo $AGRI_CA ?></td>
                        <td><?php echo $AGRI_HO ?></td>
                        <td><?php echo $AGRI_GO ?></td>
                        <td><?php echo $AGRI_SH ?></td>
                        <td><?php echo $AGRI_SW ?></td>
                        <td><?php echo $AGRI_PM ?></td>
                        <td><?php echo $AGRI_PE ?></td>
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
                    <tr>
                        <td>YRRP</td>
                        <td><?php echo $YRRP_WB ?></td>
                        <td><?php echo $YRRP_CA ?></td>
                        <td><?php echo $YRRP_HO ?></td>
                        <td><?php echo $YRRP_GO ?></td>
                        <td><?php echo $YRRP_SH ?></td>
                        <td><?php echo $YRRP_SW ?></td>
                        <td><?php echo $YRRP_PM ?></td>
                        <td><?php echo $YRRP_PE ?></td>
                    </tr>
                </tbody>

            </table>

            <h3 class="text-center">User Acomplished</h3>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <td>User</td>
                        <td>Count</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $_SESSION['isLoginName'] ?></td>
                        <td><?php echo $total_user_count ?></td>
                        <td><?php echo $sample_date ?></td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>


    <?php

    } catch (Exception $e) {
        echo '<div class="alert alert-danger" style="margin-top: 100px;">';
        echo 'Error Found! ' . $e . '</div>';
    }
    ?>

    <!--
<audio autoplay></audio>

<script>
window.AudioContext = window.AudioContext || window.webkitAudioContext;

const context = new AudioContext();

navigator.mediaDevices.getUserMedia({audio: true}).
  then((stream) => {
    const microphone = context.createMediaStreamSource(stream);
    const filter = context.createBiquadFilter();
    // microphone -> filter -> destination
    microphone.connect(filter);
    filter.connect(context.destination);
});
</script>
-->
</body>

</html>