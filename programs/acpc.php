<?PHP
session_start();
require_once '../connection/conn.php';
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\acpc;
use Classes\farmers;
use Classes\group;
use Classes\programtables;

$obj = new programtables();
$table = $obj->acpc();
$acpc = new acpc($table);

if (!isset($_SESSION['token'])) {
    header("location: ../logmeOut");
}

if (isset($_POST['submiter'])) {

    $unwanted = array("&NTILDE;" => "Ñ");
    $yearNow = $_SESSION['insuranceCode'];

    $getdate = $acpc->getDate(date("Y-m-d", strtotime($_POST['rcv'])));
    $LSP = $acpc->lsp($_POST['animal-type']);
    $ids = "RO8-" . date("Y") . "-" . date("m");
    $program = "PNL";
    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted);
    $check_group = new group();
    $check_group->param($group);
    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted);
    $prepared = mb_strtoupper($_SESSION['isLoginName']);
    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

    $f_id = htmlentities($_POST['assured-id']);

    //$barangay = strtr(mb_strtoupper(htmlentities($_POST['barangay'], ENT_QUOTES)), $unwanted);
    //$barangay = "";
    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
    $prem_loading = $acpc::prem_loading($_POST['animal-type']);

    //check office_assignment
    $office_assignment = $acpc->office_assignment($province, $town);
/* check if farmer id is register to farmers table*/
    $check_farmer = new farmers();
    $check_farmer->param($f_id, $assured, $office_assignment, $province, $town);

    $values = array(
        $yearNow, $getdate, $program, $group, $ids, $LSP,
        $province, $town, $assured, $_POST['farmer-count'],
        $_POST['head-count'], $_POST['animal-type'],
        $bpremium, $_POST['cover'],
        $_POST['rate'], $fromDate, $toDate, "active",
        $office_assignment, $prem_loading, $iu, $prepared, $f_id,
    );

    $result = $acpc->insertData($values);

    if ($result > 0) {
        header('Location: ' . $_SERVER[REQUEST_URI]);

    }
}
if (isset($_POST['submit_index_update'])) {
    // Update application form pdf
    if (isset($_POST['fileUpload'])) {
        if ($_FILES["fileUpload"]["type"] == "application/pdf" && $_FILES['fileUpload']['size'] != 0) {
            //do the error checking and upload if the check comes back OK
            switch ($_FILES['fileUpload']['error']) {
                case 1:
                    print '<p> The file is bigger than this PHP installation allows</p>';
                    break;
                case 2:
                    print '<p> The file is bigger than this form allows</p>';
                    break;
                case 3:
                    print '<p> Only part of the file was uploaded</p>';
                    break;
                case 4:
                    print '<p> No file was uploaded</p>';
                    break;
            }

            $temp = explode(".", $_FILES['fileUpload']['name']);
            $newfilename = $_POST['ids'] . 'ACPC' . '.' . end($temp);
            move_uploaded_file(
                $_FILES["fileUpload"]["tmp_name"],
                "../uploads/ACPC/" . $_SESSION['insurance'] . '/' . $newfilename
            );

            $path = "../uploads/ACPC/" . $_SESSION['insurance'] . '/' . $newfilename;
            $result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
            $result->execute([$path, $_POST['ids']]);
        }
    }
    $LSP = $acpc->lsp($_POST['animal-type']);
    $unwanted = array("&NTILDE;" => "Ñ");
    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted);
    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted);
    $prepared = mb_strtoupper($_SESSION['isLoginName']);
    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

    //check office_assignment
    $office_assignment = $acpc->office_assignment($province, $town);
    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
    $prem_loading = mb_strtoupper(htmlentities($_POST['loading']), 'UTF-8');
    if (empty($_POST['lslb'])) {
        $_lslb = 0;
    } else {
        $_lslb = $_POST['lslb'];
    }

    $values_update = array(
        $group, $assured, $province, $town, $_POST['farmer-count'], $_POST['head-count'], $_POST['animal-type'], $LSP,
        $bpremium, $_POST['rate'], $_POST['cover'], $fromDate, $toDate, $_POST['stt'], $_lslb, $office_assignment, $prem_loading,
        $iu, $prepared, $_POST['ids'],
    );

    $count = $acpc->update($values_update);

    if ($count > 0) {
        $url = $_SERVER['REQUEST_URI'];
        header("Location: " . $url);

    }

}

if (isset($_POST['delete_records'])) {

    $acpc->delete($_POST['recorded'], $header);
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>ACPC-PUNLA | Livestock Control</title>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="refresh" content="1800">
    <link rel="shortcut icon" href="../images/favicon.ico">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css">
    <link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../resources/css/local.css">
    <link rel="stylesheet" href="../resources/multi-select/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../resources/jquery-ui-1.12.1.custom/jquery-ui.css">
    <script src="../resources/bootstrap-4/js/jquery.js"></script>
    <script src="../resources/bootstrap-4/umd/js/popper.js"></script>
    <script src="../resources/bootstrap-4/js/bootstrap.js"></script>
    <script type="text/javascript" src="../resources/assets/js/css3-mediaqueries.js"></script>
    <script type="text/javascript" src="../resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  				<script type='text/javascript' src="../resources/html5shiv/src/html5shiv.js"></script>
  				<script type='text/javascript' src="../resources/Respond/src/respond.js"></script>
  	<![endif]-->
    <script type="text/javascript" src="../resources/multi-select/bootstrap-multiselect.js"></script>
    <script type="text/javascript" language="javascript" src="../resources/js/acpc.js"></script>
    <script>
    $(window).scroll(function() {
        sessionStorage.scrollTop = $(this).scrollTop();
    });

    $(document).ready(function() {
        if (sessionStorage.scrollTop != "undefined") {
            $(window).scrollTop(sessionStorage.scrollTop);
        }
    });
    </script>
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
    <div class="container">
        <a class="navbar-brand mx-auto" href="../home">
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
                        <a class="dropdown-item" href="rsbsa">RSBSA</a>
                        <a class="dropdown-item" href="regular">Regular Program</a>
                        <a class="dropdown-item" href="apcp">APCP</a>
                        <a class="dropdown-item" href="acpc">Punla</a>
                        <a class="dropdown-item" href="agriagra">AGRI-AGRA</a>
                        <a class="dropdown-item" href="saad">SAAD</a>
                        <a class="dropdown-item" href="yrrp">YRRP</a>
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
                        <a class="dropdown-item" href="../year">Insurance Year</a>
                        <a class="dropdown-item" href="../farmers">Farmers List</a>
                        <a class="dropdown-item" href="../accounts">Accounts</a>
                        <a class="dropdown-item" href="../checkbox" target="_blank">Checklist</a>
                        <?php
}
?>
                        <a class="dropdown-item" href="comments">Comments</a>
                        <a class="dropdown-item" href="../locations">Locations</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logmeOut">
                        <i class="fa fa-sign-out" style="font-size:15px"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- add button -->
                <li class="nav-item"><a class="nav-link" href="#">
                        <button class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#myModal"
                            data-backdrop="static" data-keyboard="false">Add Farmer</button>
                    </a>
                </li>
                <!-- end add button -->
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select id="pref" class="input-group-text">
                            <option value="f">Farmer</option>
                            <option value="l">Logbook</option>
                            <option value="i">IDS</option>
                        </select>
                    </div>
                    <input type="text" id="srch" name="srch" class="form-control form-control-sm py-2"
                        placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn btn-dark input-group-text" type="button" onclick="find_ids();">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </nav>

    <div class="container-fluid">
        <div class="page-header" style="margin-top:50px;">
            <h2 class="display-5">ACPC - PUNLA</h2>
            <hr>
        </div>

        <?PHP
$results_per_page = 100;

if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
;
$start_from = ($page - 1) * $results_per_page;

if ($_SESSION['office'] == "Regional Office") {
    $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table");
    $rs3->execute();
} else {
    $rs3 = $db->prepare("SELECT COUNT(idsnumber) AS total FROM $table WHERE office_assignment = ?");
    $rs3->execute([$_SESSION['office']]);
}
foreach ($rs3 as $row) {
    $getcount = $row['total'];
}
// calculate total pages with results
$total_pages = ceil(round($getcount) / $results_per_page);
?>





        <div style="overflow-x:auto;">
            <span id="addfarmers"></span>
            <?PHP

echo '<ul class="pagination pull-right">';

if ($page <= 1) {
    echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
} else {
    echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='acpc?page=" . ($page - 1) . "'>Previous</a></li>";
}

for ($x = max($page - 5, 1); $x <= max(1, min($total_pages, $page + 5)); $x++) {

    if ($page == $x) {
        echo '<li class="page-item active"><a class="page-link" href="acpc?page=' . $x . '">' . $x . '</a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="acpc?page=' . ($x) . '">' . $x . '</a></li>';
    }
}
if ($page < $total_pages) {
    echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='acpc?page=" . ($page + 1) . "'>Next</a></li>";

} else {
    echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
}

echo '</ul>';

?>

            <form method="post" action="../printing/printbatchProcessingslipACPC" target="_blank">
                <table class="table table-condensed table-hover table-sm" id="displaydata">


                    <thead>
                        <tr>
                            <th><input type="submit" class="btn btn-outline-primary btn-sm" name="printBtn"
                                    value="print"></th>
                            <th>Date Received</th>
                            <th>Livestock Policy Number</th>
                            <th>Name Of Farmers / Assured</th>
                            <th>Farmers ID</th>

                            <th>Address</th>
                            <th>Kind of Animal</th>
                            <th>Heads</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>

                    </thead>
                    <tbody>





                        <?PHP

if ($_SESSION['office'] == "Regional Office") {
    $rs = $db->prepare("SELECT * FROM $table ORDER BY idsnumber DESC LIMIT ?, ?");
    $rs->execute([$start_from, $results_per_page]);
} else {
    $rs = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? ORDER BY idsnumber DESC LIMIT ?, ?");
    $rs->execute([$_SESSION['office'], $start_from, $results_per_page]);
}

foreach ($rs as $row) {

    if ($row['status'] == "active") {

        echo '<tr>';

        echo '<td class="text-center"><input type="checkbox" name="chkPrint[]" value="' . $row['idsnumber'] . '" id="i' . $row['idsnumber'] . '" style="width:20px; height:20px; cursor: pointer;"></td>';
        echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
        echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '&nbsp;' . $row['idsprogram'] . '</strong></td>';
        echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
        echo '<td class="text-success">' . $row['f_id'] . '</td>';
        //echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
        echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
        echo '<td>' . $row['animal'] . '</td>';
        echo '<td class="text-center">' . $row['heads'] . '</td>';

        if (!$row['lslb'] == "0") {
            echo '<td><a class="btn btn-primary btn-sm" href="../policy/policy?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
        } else {
            echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">' . $row['lslb'] . '</a></td>';
        }

        echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'PNL" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
        echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
        echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash-o"/></i></a></td>';

        echo '</tr>';
    } else if ($row['status'] == "cancelled") {
        echo '<tr>';
        echo '<td class="text-center"><input type="checkbox" name="chkPrint" style="width:20px; height:20px; cursor: pointer;"></td>';
        echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
        echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '&nbsp;' . $row['idsprogram'] . '</strong></td>';
        echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
        echo '<td class="text-success">' . $row['f_id'] . '</td>';
        //echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';

        echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
        echo '<td>' . $row['animal'] . '</td>';
        echo '<td class="text-center">' . $row['heads'] . '</td>';

        if (!$row['lslb'] == "0") {
            echo '<td><a class="btn btn-outline-primary btn-sm" href="policy?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
        } else {
            echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">' . $row['lslb'] . '</a></td>';
        }
        echo '<td>&nbsp;</td>';
        echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
        echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';

        echo '</tr>';
    } else if ($row['status'] == 'cancelled') {
        echo '<tr>';
        echo '<td><input type="checkbox" name="chkPrint[]" value="' . $row['idsnumber'] . '" style="width:20px; height:20px; cursor: pointer;"></td>';
        echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
        echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '&nbsp;' . $row['idsprogram'] . '</strong></td>';
        echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
        echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
        echo '<td>' . $row['animal'] . '</td>';
        echo '<td class="text-center">' . $row['heads'] . '</td>';

        if (!$row['lslb'] == "0") {
            echo '<td><a class="btn btn-outline-primary btn-sm" href="../policy/policy?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
        } else {
            echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">' . $row['lslb'] . '</a></td>';
        }

        echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'PNL" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
        echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
        echo '<td>&nbsp;</td>';

        echo '</tr>';
    } else if ($row['status'] == "evaluated") {
        echo '<tr>';
        echo '<td><span class="badge badge-warning">Evaluated</span></td>';
        echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
        echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '&nbsp;' . $row['idsprogram'] . '</strong></td>';
        echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
        echo '<td class="text-success">' . $row['f_id'] . '</td>';
        echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
        echo '<td>' . $row['animal'] . '</td>';
        echo '<td class="text-center">' . $row['heads'] . '</td>';

        if (!$row['lslb'] == "0") {
            echo '<td><a class="btn btn-info btn-sm" href="../policy/policy?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
        } else {
            echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
        }

        echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
        echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
        echo '<td>&nbsp;</td>';

        echo '</tr>';

    }
}
?>


                    </tbody>
                </table>
            </form>

        </div>
        <!-- Footer-->
        <hr>
        <p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
            <br><small><a href="#top">Back to top</a>
        </p>
        <!-- end footer-->
    </div>
    </div>

    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Delete Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>


                </div>

                <div class="modal-body">
                    <div class="fetched-data">


                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog">

            <div class="modal-content">
                <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class="modal-body">
                        <div class="fetched-data">


                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_index_update">Save Changes</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Livestock Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div> 

                <div class="modal-body">
                    <div class="fetched-data">


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>


            </div>
        </div>
    </div>


    <div class="modal fade" id="ids" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <form method="post" id="farmersform">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">ADD FARMERS</h4>
                    </div>

                    <div class="modal-body">

                        <table class="table borderless" id="farmeradd">
                            <tbody>
                                <tr>
                                    <td style="border: none;"><label for="frmrid">Farmer ID:</label></td>
                                    <td style="border: none;" colspan="3"><input type="number" class="form-control"
                                            name="frmrid" id="frmrid" placeholder="436158"></td>
                                </tr>
                                <tr>
                                    <td style="border: none;"><label for="agem">Age(M)</label></td>
                                    <td style="border: none;"><input type="text" class="form-control" name="agem"
                                            id="agem" placeholder="3 Yrs Old"></td>
                                    <td style="border: none;"><label for="hdsm">Heads</label></td>
                                    <td style="border: none;"><input type="number" class="form-control" name="hdsm"
                                            id="hdsm" step="any" min="0" placeholder="0"></td>
                                </tr>

                                <tr>
                                    <td style="border: none;"><label for="agef">Age(F)</label></td>
                                    <td style="border: none;"><input type="text" class="form-control" name="agef"
                                            id="agef" placeholder="3 Yrs Old"></td>
                                    <td style="border: none;"><label for="hdsf">Heads</label></td>
                                    <td style="border: none;"><input type="number" class="form-control" name="hdsf"
                                            id="hdsf" step="any" min="0" placeholder="0"></td>
                                </tr>

                                <tr>
                                    <td style="border: none;"><label for="breed">Brand / Breed</label></td>
                                    <td style="border: none;" colspan="3"><input type="text" class="form-control"
                                            name="breed" id="breed" placeholder="Native"></td>
                                </tr>

                                <tr>
                                    <td style="border: none;"><label for="tagn">Ear Tag No.</label></td>
                                    <td style="border: none;" colspan="3"><input type="text" class="form-control"
                                            name="tagn" id="tagn"></td>
                                </tr>

                                <tr>
                                    <td style="border: none;"><label for="certt">Certificate No.</label></td>
                                    <td style="border: none;" colspan="3"><input type="number" class="form-control"
                                            name="certt" id="certt" step="any" min="0"></td>
                                </tr>
                                <tr>
                                    <td style="border: none;"><label for="aCover">Amount Cover</label></td>
                                    <td style="border: none;" colspan="3"><input type="number" class="form-control"
                                            name="aCover" id="aCover" step="any" min="0"></td>
                                </tr>
                                <tr>
                                    <td style="border: none;"><label for="apremium">Premium</label></td>
                                    <td style="border: none;" colspan="3"><input type="number" class="form-control"
                                            name="apremium" id="apremium" step="any" min="0"></td>
                                </tr>

                        </table>





                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" name="submitfrmrs" id="submitfrmrs"
                            onclick="verifyFarmers();">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- INSERT MODAL -->

    <!-- Modal -->
    <div class="modal animated zoomOutleft faster" id="myModal">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Insurance</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" autocomplete="false">
                        <table class="table table-sm table-condensed" id="addInsurance">
                            <tr>
                                <th scope="row"><label for="rcv">Received Date (optional):</label></th>
                                <td><input id="rcv" type="date" name="rcv" tabindex="1"
                                        class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="group-name">Group Name</label></th>
                                <td><input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al."
                                        required maxlength="200" tabindex="2" class="form-control form-control-sm"
                                        value="<?php if (isset($_SESSION['group'])) {
    echo $_SESSION['group'];
} else {
}?>" autofocus></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="assured-id">Farmers ID</label></th>
                                <td><input type="number" name="assured-id" id="assured-id" placeholder="Farmers ID"
                                        required tabindex="3" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="assured-name">Name of Assured</label></th>
                                <td><input type="text" name="assured-name" id="assured-name"
                                        placeholder="Juan Dela Cruz et. al." required maxlength="200" tabindex="4"
                                        class="form-control form-control-sm"></td>
                            </tr>
                            <?php
if ($_SESSION['office'] == "Regional Office") {
    ?>
                            <tr>
                                <th scope="row"><label for="address">Province</label></th>
                                <td><select id="province" name="province" placeholder="Leyte"
                                        class="form-control form-control-sm" tabindex="5"
                                        onchange="getaddress(this.value);">
                                        <option value="--">--</option>
                                        <option value="LEYTE">LEYTE</option>
                                        <option value="SOUTHERN LEYTE">SOUTHERN LEYTE</option>
                                        <option value="BILIRAN">BILIRAN</option>
                                        <option value="NORTHERN SAMAR">NORTHERN SAMAR</option>
                                        <option value="EASTERN SAMAR">EASTERN SAMAR</option>
                                        <option value="WESTERN SAMAR">WESTERN SAMAR</option>
                                    </select>
                                </td>
                            </tr>
                            <?php

} else {

    ?>
                            <tr>
                                <th scope="row"><label for="address">Province</label></th>
                                <td><select id="province" name="province" placeholder="Leyte" class="custom-select"
                                        tabindex="6" onfocus="getaddress(this.value);">
                                        <?php
/*
    $result = $db->prepare("SELECT province FROM location WHERE office = ? LIMIT 1");
    $result->execute([$_SESSION['office']]);
    foreach ($result as $row) {

    echo '<option value="' . $row['province'] . '" selected>' . $row['province'] . '</option>';
    }
     */
    ?>

                                    </select>
                                </td>

                            </tr>
                            <?php

}
?>
                            <tr>
                                <th scope="row"><label for="address">Town</label></th>
                                <td>
                                    <select id="town" name="town" class="form-control form-control-sm" tabindex="6">

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="farmer-count">Farmers</label></th>
                                <td><input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"
                                        tabindex="7" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="head-count">Heads</label></th>
                                <td><input type="number" id="head-count" name="head-count" required min=0 step="any"
                                        tabindex="8" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="animal-type">Kind of Animal: </label></th>
                                <td>
                                    <select name="animal-type" id="animal-type" tabindex="9" class="custom-select">
                                        <option name="animal" value="---------">&nbsp;</option>
                                        <option name="animal" value="Carabao-Breeder">Carabao Breeder</option>
                                        <option name="animal" value="Carabao-Draft">Carabao Draft</option>
                                        <option name="animal" value="Carabao-Dairy">Carabao Dairy</option>
                                        <option name="animal" value="Carabao-Fattener">Carabao Fattener</option>
                                        <option name="animal" value="Cattle-Breeder">Cattle Breeder</option>
                                        <option name="animal" value="Cattle-Draft">Cattle Draft</option>
                                        <option name="animal" value="Cattle-Dairy">Cattle Dairy</option>
                                        <option name="animal" value="Cattle-Fattener">Cattle Fattener</option>
                                        <option name="animal" value="Horse-Draft">Horse Draft</option>
                                        <option name="animal" value="Horse-Working">Horse Working</option>
                                        <option name="animal" value="Horse-Breeder">Horse Breeder</option>
                                        <option name="animal" value="Swine-Fattener">Swine Fattener</option>
                                        <option name="animal" value="Swine-Breeder">Swine Breeder</option>
                                        <option name="animal" value="Goat-Fattener">Goat Fattener</option>
                                        <option name="animal" value="Goat-Breeder">Goat Breeder</option>
                                        <option name="animal" value="Goat-Milking">Goat Milking</option>
                                        <option name="animal" value="Sheep-Fattener">Sheep Fattener</option>
                                        <option name="animal" value="Sheep-Breeder">Sheep Breeder</option>
                                        <option name="animal" value="Poultry-Broilers">Poultry-Broilers</option>
                                        <option name="animal" value="Poultry-Pullets">Poultry-Pullets</option>
                                        <option name="animal" value="Poultry-Layers">Poultry-Layers</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="tag">COLC / COTC / TAG</label></th>
                                <td><input type="text" name="tag" class="form-control form-control-sm" tabindex="10">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="rate">Premium Rate</label></th>
                                <td><input type="number" min=0 step="any" name="rate" id="rate" required
                                        placeholder="0.00" tabindex="11" class="form-control form-control-sm">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="cover">Amount Cover</label></th>
                                <td><input type="number" min=0 step="any" name="cover" id="cover" required
                                        placeholder="0.00" tabindex="12" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="datepicker1">Start of Cover</label></th>
                                <td><input type="date" name="effectivity-date" required tabindex="13"
                                        class="form-control form-control-sm" id="datepicker1"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="datepicker2">End of Cover</label></th>
                                <td><input type="date" name="expiry-date" required tabindex="14"
                                        class="form-control form-control-sm" id="datepicker2"></td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="iu">IU/Solicitor</label></th>
                                <td><input type="text" name="iu" id="iu" tabindex="15"
                                        class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="notes">Notes:</label></th>
                                <td><textarea name="notes" id="notes" maxlength="1000" tabindex="16"
                                        class="form-control form-control-sm"></textarea></td>
                            </tr>
                        </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submiter" class="btn btn-primary" tabindex="17" name="submiter"
                        data-loading-text="Adding Data..">Submit</button>
                    </form>
                </div>
            </div>
</body>

</html>
<script>
$(document).ready(function() {
    $("#displaydata tr").dblclick(function() {
        if ($(this).hasClass('table-active')) {
            $(this).removeClass('table-active');
        } else {
            $(this).addClass('table-active');
        }
    });
});
</script>