<?PHP
session_start();
require "../connection/conn.php";
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\farmers;
use Classes\group;
use Classes\util;

$table = "rsbsa" . $_SESSION['insurance'];

$util = new util('rsbsa', $db);
$util->setColumns(array(
    "Year", "date_r", "program", "groupName", "ids1", "lsp", "province", "town", "assured",
    "farmers", "heads", "animal", "premium", "amount_cover", "rate", "Dfrom", "Dto", "status", "office_assignment",
    "loading", "iu", "prepared", "tag", "f_id", "comments", "idsprogram"
));
#$table = $util->table();

//error trappings
$unwanted = array("&NTILDE;" => "Ñ");

if (!isset($_SESSION['token'])) {
    header("location: ../logmeOut");
    exit();
}

if (isset($_POST['submiter'])) {

    $yearNow = $_SESSION['insuranceCode']; # Current Year
    $getdate = $util->getDate(date("Y-m-d", strtotime($_POST['rcv']))); # Date Received
    $LSP = $util->lsp($_POST['animal-type']); # Get LSP or Policy type

    $ids = "RO8-" . date("Y") . "-" . date("m"); # IDS Code
    $program = "RSBSA"; # Type Program
    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted); # Group name

    $check_group = new group();
    $check_group->param($group);

    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted); # insurance underwriter
    $prepared = mb_strtoupper($_SESSION['isLoginName']); # User / Prepared
    $tag = mb_strtoupper(htmlentities($_POST['tag'])); # Tag Number
    $f_id = htmlentities($_POST['assured-id']);
    $notes = htmlentities($_POST['notes'], ENT_QUOTES);

    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);
    $rsbsa_type = strtr(mb_strtoupper(htmlentities($_POST['type_rsbsa'], ENT_QUOTES)), $unwanted);

    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));

    $prem_loading = $util->prem_loading($_POST['animal-type'], $fromDate);

    $office_assignment = $util->office_assignment($province, $town);

    /* check if farmer id is register to farmers table*/
    $check_farmer = new farmers();
    $check_farmer->param($f_id, $assured, $office_assignment, $province, $town);

    $values = array(
        $yearNow, $getdate, $program, $group, $ids, $LSP,
        $province, $town, $assured, $_POST['farmer-count'],
        $_POST['head-count'], $_POST['animal-type'],
        $bpremium, $_POST['cover'],
        $_POST['rate'], $fromDate, $toDate, "active",
        $office_assignment, $prem_loading, $iu, $prepared, $tag, $f_id, $notes, $rsbsa_type,
    );
    $result = $util->insertData($values);
    if ($result > 0) {
        $_SESSION['group'] = $group;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
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
            $newfilename = $_POST['ids'] . 'RSBSA' . '.' . end($temp);
            move_uploaded_file(
                $_FILES["fileUpload"]["tmp_name"],
                "../uploads/RSBSA/" . $_SESSION['insurance'] . '/' . $newfilename
            );

            $path = "../uploads/RSBSA/" . $_SESSION['insurance'] . '/' . $newfilename;
            $result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
            $result->execute([$path, $_POST['ids']]);
        }
    }
    $LSP = $util->lsp($_POST['animal-type']);
    $unwanted = array("&NTILDE;" => "Ñ");
    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted);
    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted);
    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);
    $rsbsa_type = strtr(mb_strtoupper(htmlentities($_POST['type_rsbsa'], ENT_QUOTES)), $unwanted);
    $tag = mb_strtoupper(htmlentities($_POST['tag'])) ?: "";
    $f_id = htmlentities($_POST['assured-id']);
    $notes = htmlentities($_POST['notes'], ENT_QUOTES) ?: "";

    //check office_assignment
    $office_assignment = $util->office_assignment($province, $town);
    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
    $prem_loading = $util->prem_loading($_POST['animal-type'], $fromDate);
    $_lslb = $_POST['lslb'] ?: 0;

    $check_farmer = new farmers();
    $check_farmer->update($f_id, $assured, $office_assignment, $province, $town);

    $values_update = array(
        $group, $assured, $province, $town, $_POST['farmer-count'], $_POST['head-count'], $_POST['animal-type'], $LSP,
        $bpremium, $_POST['rate'], $_POST['cover'], $fromDate, $toDate, $_POST['stt'], $_lslb, $office_assignment, $prem_loading,
        $iu, $tag, $f_id, $notes, $rsbsa_type, $_POST['ids'],
    );

    $count = $util->update($values_update);

    if ($count > 0) {
        $url = $_SERVER['REQUEST_URI'];
        //$url = $_SERVER['REQUEST_URI'].'#i'.$_POST['ids'];
        header("Location: " . $url);
    }
}

if (isset($_POST['delete_records'])) {

    $header = $_SERVER["REQUEST_URI"];

    $util->delete($_POST['recorded'], $header);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>RSBSA | Livestock Control</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- <meta http-equiv="refresh" content="180"> -->
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <!--[if IE]><link rel="shortcut icon" href="../images/favicon-32x32.ico" ><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
        href="../resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css?v=<?= filemtime('../resources/bootswatch/' . $_SESSION['mode'] . '/bootstrap.css') ?>"
        media="screen">
    <link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
    <link href="../resources/css/local.css?v=<?= filemtime('../resources/css/local.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/animate.css">
    <link rel="stylesheet" href="../resources/jquery-ui-1.12.1.custom/jquery-ui.css">
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
                        <a class="dropdown-item" href="../masterlist">RSBSA List</a>
                        <a class="dropdown-item" href="../checkbox" target="_blank">Checklist</a>
                        <a class="dropdown-item" href="../extract" target="_blank">Extract LIPs</a>
                        <a class="dropdown-item" href="../printform">Batch Printing</a>
                        <a class="dropdown-item" href="../processmonitoring">PRODUCTION PROCESS MONITORING</a>

                        <?php
                        }
                        ?>
                        <a class="dropdown-item" href="../reports">Reports</a>
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
                            data-backdrop="static" data-keyboard="false" onClick="groupName();">Add Farmer</button>
                    </a>
                </li>
                <!-- end add button -->
            </ul>
            <form class="form-inline my-2 my-lg-0" id="searchForm">
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
                        <button class="btn btn-default input-group-text" type="button" id="searchBtn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </nav>

    <a class="scrolledup" href="#" id="scrolledup"> <span class="fa fa-angle-up"></span> </a>

    <div class="container-fluid">
        <div class="page-header" style="margin-top:50px;">
            <h2 class="display-5">Registry System on Basic Sectors in Agriculture (RSBSA)</h2>
            <div class="addbutton">
                <button class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#myModal"
                    data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
            <hr>
        </div>
        <?PHP
        /* ============== RESULTS DISPLAYED PER PAGE ==========  */
        $results_per_page = 100;
        /* =======================================================*/
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }

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
                echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='rsbsa?page=" . ($page - 1) . "'>Previous</a></li>";
            }

            //5 = 9, 4 = 7, 3 = 5
            for ($x = max($page - 3, 1); $x <= max(1, min($total_pages, $page + 3)); $x++) {

                if ($page == $x) {
                    echo '<li class="page-item active">
					<a class="page-link" href="rsbsa?page=' . $x . '">' . $x . '</a>
					</li>';
                } else {
                    echo '<li class="page-item"><a class="page-link" href="rsbsa?page=' . ($x) . '">' . $x . '</a></li>';
                }
            }
            if ($page < $total_pages) {
                echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='rsbsa?page=" . ($page + 1) . "'>Next</a></li>";
            } else {
                echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
            }

            echo '</ul>';

            ?>

            <form method="post" action="../printing/printbatchProcessingslipRSBSA" target="_blank">
                <table class="table table-condensed table-hover table-sm" id="displaydata">


                    <thead>
                        <tr>
                            <th class="text-center">
                                <div class="btn-group" role="group" aria-label="Action Button">
                                    <div class="btn-group" role="group">
                                        <button id="actionBtnDropList" type="button"
                                            class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                            <input type="submit" class="dropdown-item btn btn-outline-primary btn-sm"
                                                name="printBtn" value="Print Processing Slip">
                                            <input type="submit" class="dropdown-item btn btn-outline-primary btn-sm"
                                                name="pIDSBtn" value="Print IDS">
                                            <input type="submit" class="dropdown-item btn btn-outline-primary btn-sm"
                                                name="evaluateBtn" value="Evaluate">
                                            <input type="submit" class="dropdown-item btn btn-outline-primary btn-sm"
                                                name="cancelBtn" value="Cancel">
                                            <input type="submit" class="dropdown-item btn btn-outline-primary btn-sm"
                                                name="activeBtn" value="Set Active">
                                            <input type="submit" class="dropdown-item btn btn-outline-primary btn-sm"
                                                name="t_agri" value="Move to AGRI-AGRA"
                                                onclick="setTimeout(function () { window.location.reload(); }, 3)">
                                        </div>
                                    </div>
                            </th>
                            <th>Date Received</th>
                            <th>Livestock Policy Number</th>
                            <th>Name Of Farmers / Assured</th>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Kind of Animal</th>
                            <th>Heads</th>
                            <th>LB#</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php

                        if ($_SESSION['office'] == "Regional Office") {
                            $rs = $db->prepare("SELECT * FROM $table ORDER BY idsnumber DESC LIMIT ?, ?");
                            $rs->execute([$start_from, $results_per_page]);
                        } else {
                            $rs = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? ORDER BY idsnumber DESC LIMIT ?, ?");
                            $rs->execute([$_SESSION['office'], $start_from, $results_per_page]);
                        }


                        foreach ($rs as $row) {




                            if ($row['status'] == "active") {
                                echo '<tr id="act_tr">';
                                echo '<td class="text-center"><input type="checkbox" name="chkPrint[]" value="' . $row['idsnumber'] . '" id="i' . $row['idsnumber'] . '"  style="width:20px; height:20px; cursor: pointer;">
				</td>';
                                echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                                echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                                echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                                echo '<td class="text-success">' . $row['f_id'] . '</td>';

                                echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                                echo '<td>' . $row['animal'] . '</td>';
                                echo '<td class="text-center">' . $row['heads'] . '</td>';

                                if (!$row['lslb'] == "0") {
                                    echo '<td><a class="btn btn-primary btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                                } else {
                                    echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                                }

                                echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . '' . $row['idsprogram'] . '" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                                echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                                if (!$row['lslb'] != "0") {
                                    echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';
                                } else {
                                    echo '<td></td>';
                                }

                                echo '</tr>';
                            } else if ($row['status'] == "cancelled") {
                                echo '<tr>';
                                echo '<td class="text-center">Cancelled</td>';
                                echo '<td id="i"' . $row['idsnumber'] . '>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                                echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong class="text-danger">' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                                echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" disabled>' . $row['assured'] . '</td>';
                                echo '<td class="text-success">' . $row['f_id'] . '</td>';

                                echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                                echo '<td>' . $row['animal'] . '</td>';
                                echo '<td class="text-center">' . $row['heads'] . '</td>';

                                echo '<td>&nbsp;</td>';
                                echo '<td>&nbsp;</td>';
                                echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                                echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';

                                echo '</tr>';
                            } else if ($row['status'] == "evaluated") {
                                echo '<tr>';
                                echo '<td><span class="badge badge-warning">Evaluated</span></td>';
                                echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                                echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                                echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                                echo '<td class="text-success">' . $row['f_id'] . '</td>';

                                echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                                echo '<td>' . $row['animal'] . '</td>';
                                echo '<td class="text-center">' . $row['heads'] . '</td>';

                                if (!$row['lslb'] == "0") {
                                    echo '<td><a class="btn btn-info btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                                } else {
                                    echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                                }

                                echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                                echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                                echo '<td>&nbsp;</td>';

                                echo '</tr>';
                            } else if ($row['status'] == "hold") {
                                echo '<tr>';
                                echo '<td class="text-center"><span class="badge badge-danger">HOLD</span></td>';
                                echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
                                echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
                                echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
                                echo '<td class="text-success">' . $row['f_id'] . '</td>';

                                echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
                                echo '<td>' . $row['animal'] . '</td>';
                                echo '<td class="text-center">' . $row['heads'] . '</td>';

                                if (!$row['lslb'] == "0") {
                                    echo '<td><a class="btn btn-outline-primary btn-sm" href="../policy/rsbsa?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
                                } else {
                                    echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
                                }

                                echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . '' . $row['idsprogram'] . '" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
                                echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                                if (!$row['lslb'] != "0") {
                                    echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';
                                } else {
                                    echo '<td></td>';
                                }

                                echo '</tr>';
                            }
                        }
                        ?>


                    </tbody>
                </table>
            </form>
        </div>
        <!-- Footer-->

        <p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
            <br><small>
        </p>
        <!-- end footer-->
    </div>
    </div>


    <div class="modal animated fade faster" id="deleteModal">
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

            </div>
        </div>
    </div>

    <div class="modal animated fade faster" id="editModal">
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

    <div class="modal animated fade faster" id="infoModal" role="dialog">
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
            </div>
        </div>
    </div>


    <!-- Add New Farmer -->
    <div class="modal animated fade faster" id="myModal">
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
                                <th scope="row"><label for="type_rsbsa">Type of RSBSA (optional):</label></th>
                                <td>
                                    <select id="type_rsbsa" name="type_rsbsa" class="form-control form-control-sm">
                                        <option value="PPPP" selected>Default</option>
                                        <option value="PPPP-ARB">DAR</option>
                                        <option value="PPPP-ACEF">ACEF</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="group-name">Group Name</label></th>
                                <td><input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al."
                                        required maxlength="200" tabindex="2" class="form-control form-control-sm"
                                        value="<?php
                                                                                                                                                                                                            if (isset($_SESSION['group'])) {
                                                                                                                                                                                                                echo $_SESSION['group'];
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                            } ?>"
                                        autofocus></td>
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
                                        tabindex="6" onfocus="getaddress(this.value);" required>
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
                                    <select id="town" name="town" class="form-control form-control-sm" tabindex="6"
                                        required>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="farmer-count">Farmers</label></th>
                                <td><input type="number" id="farmer-count" name="farmer-count" required readonly min=0
                                        step="any" tabindex="7" class="form-control form-control-sm" value="1"></td>
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
        </div>
    </div>
</body>

</html>

<script>
function groupName() {
    var input = document.getElementById('group-name');
    input.focus();
    input.select();
}
</script>
<script src="../resources/bootstrap-4/js/jquery.js"></script>
<script src="../resources/bootstrap-4/umd/js/popper.js"></script>
<script src="../resources/bootstrap-4/js/bootstrap.js"></script>
<script src="../resources/bootstrap-4/umd/js/popper.js"></script>
<script type="text/javascript" src="../resources/assets/js/css3-mediaqueries.js"></script>
<script type="text/javascript" src="../resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    	<script type='text/javascript' src="../resources/html5shiv/src/html5shiv.js"></script>
  		<script type='text/javascript' src="../resources/Respond/src/respond.js"></script>
  	<![endif]-->
<script type="text/javascript" src="../resources/js/rsbsa.js?v=<?= filemtime('../resources/js/rsbsa.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#assured-id").change(function() {
        var val = $("#assured-id").val();
        $.ajax({
            type: 'post',
            url: '../bin/search/search_farmer.php', //Here you will fetch records
            data: 'id=' + val, //Pass $id
            success: function(data) {
                $('#assured-name').trigger(':reset');
                $('#province').trigger(':reset');

                if (!data.trim() == '') {

                    var obj = $.parseJSON(data);
                    var provinces = obj[0].province;
                    var town = obj[0].town;
                    console.log(town);

                    $('#assured-name').val(obj[0]
                        .name); //Show fetched data from database
                    $('#province').val(obj[0].province);
                    $('#town').append($('<option>', {
                        value: town,
                        text: town
                    }));
                    $('#town').val(town);

                    /*
                    $('#province option').each(function(){
                    	if ($(this).text() == provinces){
                    		$(this).parent().val($(this).val());

                    	}
                    });
                    $('#town option').val(town);
                    */


                    $('#assured-name').prop('readonly', true);
                } else {
                    $('#assured-name').val('');
                    $('#assured-name').trigger(':reset');
                    $('#province').trigger(':reset');



                }
            },
            error: function(data) {
                $('#assured-name').val('');
                $('#province').val('');
                $('#assured-name').trigger(':reset');
                $('#province').trigger(':reset');


                $('#assured-name').prop('readonly', false);
            }
        });

    });

});
$(window).scroll(function() {
    sessionStorage.scrollTop = $(this).scrollTop();
});
$(document).ready(function() {
    if (sessionStorage.scrollTop != "undefined") {
        $(window).scrollTop(sessionStorage.scrollTop);
    }
});
$(document).ready(function() {
    $("#displaydata tr").dblclick(function() {
        if ($(this).hasClass('table-active')) {
            $(this).removeClass('table-active');
        } else {
            $(this).addClass('table-active');
        }
    });
});

$(document).ready(function() {
    setTimeout(function() {
        $('#act_tr').removeClass('table-active');
        //....and whatever else you need to do
    }, 6000);
});

$(document).ready(function() {
    $('#searchBtn').click(function(e) {

        var xz = $("#pref").val() + $("#srch").val();
        $('#displaydata > tbody').empty();

        $.ajax({
            type: 'POST',
            url: '../search.php',
            data: 'ids=' + xz,
            success: function(e) {
                $('#displaydata > tbody').html(e);
            },
            error: function(d) {
                alert("ERROR: " + d);
            }
        });
    });
});

$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 80) {
            $('#scrolledup').fadeIn();
        } else {
            $('#scrolledup').fadeOut();
        }
    });
    $('.scrolledup').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
});
</script>