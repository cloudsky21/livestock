<?PHP
session_start();
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;
use Classes\util;

$util = new util('rsbsa', $db);
$tables = new programtables();

//error trappings
$unwanted = array("&NTILDE;" => "Ñ");

if (!isset($_SESSION['token'])) {
    header("location: ../logmeOut");
}

function adjustFarmer_table($data, $listTbl, $db)
{
    /*
@param office_assignment varchar(200) $assignment
@param province varchar(300) $province
@param town varchar(300) $city
@param f_id decimal(20,0) $trigger_id (old_id), $id_update (to_be_updated)
@param assured varchar(300) $name
 */
    $list_of_table = $listTbl->tableList_print();
    $count = 0;

    foreach ($list_of_table as $key => $value) {
        $result = $db->prepare("UPDATE $value SET f_id = ?, assured = ?, province =?, town = ?, office_assignment = ? WHERE f_id = ?");
        $result->execute($data);
        $rowcount = $result->rowcount();

        $count = $count + $rowcount;
    }
    return $count;
}

/* Save Code */

if (isset($_POST['modify'])) {

    $province = strtr(mb_strtoupper(htmlentities($_POST['f_prov'], ENT_QUOTES)), $unwanted);
    $city = strtr(mb_strtoupper(htmlentities($_POST['f_city'], ENT_QUOTES)), $unwanted);
    $name = strtr(mb_strtoupper(htmlentities($_POST['f_name'], ENT_QUOTES)), $unwanted);
    $id_update = htmlentities($_POST['f_id'], ENT_QUOTES);
    $trigger_id = htmlentities($_POST['idformer'], ENT_QUOTES);
    $assignment = $util->office_assignment($province, $city);

    $data = [$id_update, $name, $province, $city, $assignment, $trigger_id];
    $result = $db->prepare("UPDATE farmers SET farmers.id = ?, farmers.name = ?, farmers.province = ?, farmers.city= ?, farmers.office_assigned =? WHERE farmers.id = ?");
    $result->execute($data);

    if ($result->rowcount() > 0) {
        $affected = adjustFarmer_table($data, $tables, $db);
        echo '<script>if(!alert("Success! Data has been saved. Tables affected: ' . $affected . ' ")){window.location.reload();}</script>';
    } else {
        echo '<script>console.log( ' . json_encode($data) . ' );</script>';
    }
}

/* End Save Code */

/* Search Code */
if (isset($_POST['searchBtn'])) {
    $html = "";
    $data = htmlentities($_POST['searchText'], ENT_QUOTES);
    /* If numbers (means f_ID) */
    if (preg_match("/^[1-9][0-9]{0,15}$/", $data, $matches)) {
        $result = $db->prepare("SELECT * FROM farmers WHERE id = ?");
        $result->execute([$data]);
    } else {
        $result = $db->prepare("SELECT * FROM farmers WHERE farmers.name LIKE ?");
        $result->execute(["%" . $data . "%"]);
    }

    if ($result->rowcount() > 0) {

        $html = '<table class="table table-striped table-bordered table-condensed table-sm">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th colspan="6">Data Found: ' . $result->rowcount() . ' For: <strong>(' . $data . ')</strong></th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($result as $key) {
            $html .= '<tr>';
            $html .= '<td><input type="number" class="form-control" placeholder="Farmers ID" name="f_id" value="' . $key['id'] . '"></td>';
            $html .= '<td><input type="text" class="form-control" placeholder="Name of Farmer" name="f_name" value="' . $key['name'] . '"></td>';
            $html .= '<td><input type="text" class="form-control" placeholder="Province" name="f_prov" value="' . $key['province'] . '"></td>';
            $html .= '<td><input type="text" class="form-control" placeholder="City" name="f_city" value="' . $key['city'] . '"></td>';
            $html .= '<td><input type="hidden" name="idformer" value="' . $key['id'] . '"></td>';
            $html .= '<td><button type="submit" name="modify" class="btn btn-primary form-control form-control-sm">Save</button></td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
    } else {
        echo '<script>if( alert("No Data Found For : ' . $data . '") ){window.location.reload();}</script>';
    }
}
/* End of Search Code */

?>
<!DOCTYPE html>
<html>

<head>
    <title>Farmers Info | Livestock Control</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- <meta http-equiv="refresh" content="180"> -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <!--[if IE]><link rel="shortcut icon" href="../images/favicon-32x32.ico" ><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css" media="screen">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
    <link href="resources/css/local.css?v=<?= filemtime('resources/css/local.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/animate.css">
    <link rel="stylesheet" href="resources/jquery-ui-1.12.1.custom/jquery-ui.css">
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

        case 'default':
            echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="top">';
            break;
    }
    ?>
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
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <span class="fa fa-navicon"></span> Programs
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="programs/rsbsa">RSBSA</a>
                        <a class="dropdown-item" href="programs/regular">Regular Program</a>
                        <a class="dropdown-item" href="programs/apcp">APCP</a>
                        <a class="dropdown-item" href="programs/acpc">Punla</a>
                        <a class="dropdown-item" href="programs/agriagra">AGRI-AGRA</a>
                        <a class="dropdown-item" href="programs/saad">SAAD</a>
                        <a class="dropdown-item" href="programs/yrrp">YRRP</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <span class="fa fa-gears"></span> Settings
                    </a>
                    <div class="dropdown-menu">
                        <?php
                            if ($_SESSION['stat'] == "Main") {
                                ?>
                        <a class="dropdown-item" href="year">Insurance Year</a>
                        <a class="dropdown-item" href="farmers">Farmers List</a>
                        <a class="dropdown-item" href="accounts">Accounts</a>
                        <a class="dropdown-item" href="masterlist">RSBSA List</a>
                        <a class="dropdown-item" href="checkbox" target="_blank">Checklist</a>
                        <a class="dropdown-item" href="extract" target="_blank">Extract LIPs</a>

                        <?php
                            }
                            ?>
                        <a class="dropdown-item" href="reports">Reports</a>
                        <a class="dropdown-item" href="locations">Locations</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logmeOut">
                        <i class="fa fa-sign-out" style="font-size:15px"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <div class="container-fluid">
        <div class="page-header" style="margin-top:50px;">
            <h2 class="display-5">Farmers Information Table</h2>
            <hr>
            <form method="post" action="" name="search" autocomplete="off">
                <div class="input-group">
                    <input type="text" class="form-control form-control-lg" name="searchText" placeholder="Search here"
                        required>
                    <div class="input-group-append">
                        <button type="submit" name="searchBtn" class="btn btn-primary form-control"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Body of Code -->
        <div style="margin-top: 50px;">
            <?php
                if (isset($_POST['searchBtn'])) {
                    ?>
            <form method="post" action="">
                <?php
                            echo $html;
                            echo '<script>if ( window.history.replaceState ) {window.history.replaceState( null, null, window.location.href );}</script>';
                            ?>
            </form>
            <?php
                }
                ?>

        </div>
        <!-- End of Body of Code -->



        <!-- Footer-->
        <p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
            <br><small>
        </p>
        <!-- end footer-->
    </div>
    </div>
</body>

</html>

<!-- JS Scripts -->
<script src="resources/bootstrap-4/js/jquery.js"></script>
<script src="resources/bootstrap-4/umd/js/popper.js"></script>
<script src="resources/bootstrap-4/js/bootstrap.js"></script>
<script src="resources/bootstrap-4/umd/js/popper.js"></script>
<script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
<script type="text/javascript" src="resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    	<script type='text/javascript' src="resources/html5shiv/src/html5shiv.js"></script>
  		<script type='text/javascript' src="resources/Respond/src/respond.js"></script>
      <![endif]-->