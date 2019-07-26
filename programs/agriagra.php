<?PHP
session_start();
date_default_timezone_set('Asia/Manila');

require_once "../connection/conn.php";
require '../myload.php';

use Classes\farmers;
use Classes\group;
use Classes\programtables;
use Classes\Rsbsa;

$obj = new programtables();
$table = $obj->agriagra();
$agri_agra = new Rsbsa($table);

//Start Cache page
#include '../top.php';

$unwanted = array("&NTILDE;" => "Ñ");

if (!isset($_SESSION['token'])) {
    header("location: ../logmeOut");
}
if (isset($_POST['submiter'])) {

    $yearNow = $_SESSION['insuranceCode'];

    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted);
    $check_group = new group($group);
    $check_group->param($group);
    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted);
    $prepared = mb_strtoupper($_SESSION['isLoginName']);
    $tag = mb_strtoupper(htmlentities($_POST['tag']));
    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);
    $nonrsbsa_type = strtr(mb_strtoupper(htmlentities($_POST['type_agri'], ENT_QUOTES)), $unwanted);

    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
    $prem_loading = $agri_agra::prem_loading($_POST['animal-type'], $fromDate);

    //check office_assignment
    $office_assignment = $agri_agra->office_assignment($province, $town);
    $f_id = htmlentities($_POST['assured-id']);
    $notes = htmlentities($_POST['notes'], ENT_QUOTES);

    $check_farmer = new farmers();
    $check_farmer->param($f_id, $assured, $office_assignment, $province, $town);

    $values = array(
        $yearNow, $agri_agra->getdate(date("Y-m-d", strtotime($_POST['rcv']))), "AGRI-AGRA",
        $group, "RO8-" . date("Y") . "-" . date("m"), $agri_agra->lsp($_POST['animal-type']), $province,
        $town, $assured, $_POST['farmer-count'],
        $_POST['head-count'], $_POST['animal-type'],
        $bpremium, $_POST['cover'], $_POST['rate'],
        $fromDate, $toDate, "active", $office_assignment,
        $prem_loading, $iu, $prepared, $tag, $f_id, $notes, $nonrsbsa_type
    );

    $result = $agri_agra->insertData($values);

    if ($result > 0) {
        header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        $_SESSION['group'] = $group;
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
            $newfilename = $_POST['ids'] . 'AGRI' . '.' . end($temp);
            move_uploaded_file(
                $_FILES["fileUpload"]["tmp_name"],
                "../uploads/AGRI/" . $_SESSION['insurance'] . '/' . $newfilename
            );
            $path = "../uploads/AGRI/" . $_SESSION['insurance'] . '/' . $newfilename;
            $result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
            $result->execute([$path, $_POST['ids']]);
        } else {
            echo "Files must be PDF or empty";
        }
    }
    $LSP = $agri_agra->lsp($_POST['animal-type']);

    $unwanted = array("&NTILDE;" => "Ñ");
    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted);
    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted);
    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);
    $nonrsbsa_type = strtr(mb_strtoupper(htmlentities($_POST['type_agri'], ENT_QUOTES)), $unwanted);
    //check office_assignment
    $office_assignment = $agri_agra->office_assignment($province, $town);
    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
    $prem_loading = mb_strtoupper(htmlentities($_POST['loading']), 'UTF-8');

    $tag = mb_strtoupper(htmlentities($_POST['tag']));
    $f_id = htmlentities($_POST['assured-id']) ?: 0;
    $notes = htmlentities($_POST['notes'], ENT_QUOTES) ?: '';
    $_lslb = htmlentities($_POST['lslb']) ?: 0;

    $values_update = array(
        $group, $assured, $province, $town, $_POST['farmer-count'], $_POST['head-count'], $_POST['animal-type'], $LSP,
        $bpremium, $_POST['rate'], $_POST['cover'], $fromDate, $toDate, $_POST['stt'], $_lslb,
        $office_assignment, $prem_loading, $iu, $tag, $f_id, $notes, $nonrsbsa_type, $_POST['ids']
    );

    $count = $agri_agra->update($values_update);

    if ($count > 0) {

        $url = $_SERVER['REQUEST_URI'];
        //$url = $_SERVER['REQUEST_URI'].'#i'.$_POST['ids'];
        header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        header("Location: " . $url);

    }
}
if (isset($_POST['delete_records'])) {
    $del = $_POST['recorded'];
    $result = $db->prepare("DELETE FROM $table WHERE idsnumber = ?");
    $result->execute([$del]);
    $result = $db->prepare("ALTER TABLE $table AUTO_INCREMENT=1");
    $result->execute();
    header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    header("location:" . $_SERVER[REQUEST_URI]);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>NON-RSBSA | Livestock Control</title>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="../images/favicon.ico">


    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css"
        type="text/css">
    <!--<link rel="stylesheet" href="../resources/bootstrap-4/css/bootstrap.css">-->
    <link rel="stylesheet" href="../resources/css/local.css?v=<?=filemtime('../resources/css/local.css')?>"
        type="text/css">
    <link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../resources/css/animate.css">
    <link rel="stylesheet" href="../resources/jquery-ui-1.12.1.custom/jquery-ui.css">
    <script src="../resources/bootstrap-4/js/jquery.js"></script>
    <script src="../resources/bootstrap-4/umd/js/popper.js"></script>
    <script src="../resources/bootstrap-4/js/bootstrap.js"></script>
    <script src="../resources/assets/js/css3-mediaqueries.js"></script>
    <script src="../resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <script type="text/javascript" src="../resources/js/agriagra.js?v=<?=filemtime('../resources/js/agriagra.js');?>">
    </script>

    <script>
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
        $("#assured-id").change(function() {
            var val = $("#assured-id").val();
            $.ajax({
                type: 'post',
                url: '../bin/search/search_farmer.php', //Here you will fetch records
                data: 'id=' + val, //Pass $id
                success: function(data) {
                    if (!data.trim() == '') {
                        var obj = $.parseJSON(data);
                        var provinces = obj[0].province;
                        var town = obj[0].town;
                        console.log(obj);

                        $('#assured-name').val(obj[0]
                            .name); //Show fetched data from database
                        $('#province option').each(function() {
                            if ($(this).text() == provinces) {
                                $(this).parent().val($(this).val());

                            }
                        });
                        $('#town').append($('<option>', {
                            value: town,
                            text: town
                        }));
                        $('#town').val(town);
                    } else {
                        $('#assured-name').val = '';
                        $('#assured-name').prop('readonly', false);

                    }
                },
                error: function(data) {
                    $('#assured-name').prop('readonly', false);
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
            }, 500);
            return false;
        });
    });
    </script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  			<script type='text/javascript' src="../resources/html5shiv/src/html5shiv.js"></script>
  			<script type='text/javascript' src="../resources/Respond/src/respond.js"></script>
  		<![endif]-->

    <style type="text/css">
    .scrolledup {

        position: fixed;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        bottom: 0px;
        right: 300px;
        font-size: 18px;
        padding: 10px;
        background-color: #e34234;
        color: #fff;
        outline: none;

    }

    .scrolledup:hover {
        background-color: red;
    }

    .fixed-top-2 {

        opacity: 0.4;


    }

    /* if device screen LESS than or equal to 900px */
    @media only screen and (max-width: 900px) {
        .addbutton {
            display: block !important;
        }
    }

    /* if device screen GREATER than or equal to 901px */
    @media only screen and (min-width: 901px) {
        .addbutton {
            display: none !important;
        }
    }
    </style>
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
                <li class="nav-item">
                </li>
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


    <a class="scrolledup" href="#" id="scrolledup"> <span class="fa fa-angle-up"></span> </a>



    <div class="container-fluid">
        <div class="page-header" style="margin-top:50px;">
            <h2 class="display-5">NON-RSBSA (AGRI-AGRA)</h2>
            <div class="addbutton">
                <button class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#myModal"
                    data-backdrop="static" data-keyboard="false">
                    <i class="fa fa-plus-circle"></i>
                </button>
            </div>
            <hr>
        </div>

        <?PHP

try {
    $results_per_page = 100;
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

        <div class="table-responsive">
            <div style="overflow-x:auto;">
                <span id="addfarmers"></span>

                <?PHP

    echo '<ul class="pagination pull-right">';
    if ($page <= 1) {
        echo "<li class='page-item disabled'><a class='page-link' href='#'>Previous</a></li>";
    } else {
        echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='agriagra?page=" . ($page - 1) . "'>Previous</a></li>";
    }
    for ($x = max($page - 3, 1); $x <= max(1, min($total_pages, $page + 3)); $x++) {
        if ($page == $x) {
            echo '<li class="page-item active"><a class="page-link" href="agriagra?page=' . $x . '">' . $x . '</a></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="agriagra?page=' . ($x) . '">' . $x . '</a></li>';
        }
    } # END FOR LOOP
    if ($page < $total_pages) {
        echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='agriagra?page=" . ($page + 1) . "'>Next</a></li>";
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
    }
    echo '</ul>';
    ?>

                <form method="post" action="../printing/printbatchProcessingslipAGRI" target="_blank">
                    <table class="table table-hover table-condensed table-sm" id="displaydata">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <div class="btn-group" role="group" aria-label="Action Button">
                                        <div class="btn-group" role="group">
                                            <button id="actionBtnDropList" type="button"
                                                class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                                <input type="submit" class="dropdown-item" name="printBtn"
                                                    value="Print">
                                                <input type="submit" class="dropdown-item" name="evaluateBtn"
                                                    value="Evaluate">
                                                <input type="submit" class="dropdown-item" name="cancelBtn"
                                                    value="Cancel">
                                                <input type="submit" class="dropdown-item" name="activeBtn"
                                                    value="Set Active">
                                                <input type="submit" class="dropdown-item" name="t_rsbsa"
                                                    value="Move to RSBSA">
                                            </div>
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
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
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

        # if Status is ACTIVE
        if ($row['status'] == "active") {
            echo '<tr>';
            echo '<td class="text-center">
              <input type="checkbox" name="chkPrint[]" style="width:20px; height:20px; cursor: pointer;" value="' . $row['idsnumber'] . '" id="i' . $row['idsnumber'] . '">
              </td>';
            echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
            echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">
              <strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
            echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
            echo '<td class="text-success">' . $row['f_id'] . '</td>';
            echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
            echo '<td>' . $row['animal'] . '</td>';
            echo '<td>' . $row['heads'] . '</td>';

            if (!$row['lslb'] == "0") {
                echo '<td><a class="btn btn-primary btn-sm" href="../policy/agriagra?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
            } else {
                echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';
            }
            echo '<td><a class="btn btn-outline-primary btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . '' . $row['idsprogram'] . '" target="_blank"><i class="fa fa-file-o"></i></a></td>';
            echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';

            if (!$row['lslb'] != "0") {
                echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-trash"></i></a></td>';
            } else {
                echo '<td></td>';
            }
            echo '</tr>';
        }

        # if Status is CANCELLED
        else if ($row['status'] == "cancelled") {
            echo '<tr id="i' . $row['idsnumber'] . '">';
            echo '<td></td>';
            echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
            echo '<td class="text-danger"
             href="#infoModal"
             id="info_id"
             data-toggle="modal"
             data-id="' . $row['idsnumber'] . '"
             data-backdrop="static" disabled>
             <strong>
             ' . $row['lsp'] . '
             ' . sprintf("%04d", $row['idsnumber']) .
                '-' . $row['idsprogram'] . '
             </strong>
             </td>';
            echo '<td
             href="#addmembers"
             id="members"
             data-toggle="modal"
             data-id="' . $row['idsnumber'] . '"
             data-backdrop="static">' . $row['assured'] .
                '</td>';
            echo '<td class="text-success">' . $row['f_id'] . '</td>';

            echo '<td>'
                . $row['town'] . ', '
                . $row['province'] .
                '</td>';
            echo '<td>'
                . $row['animal'] .
                '</td>';

            echo '<td>'
                . $row['heads'] .
                '</td>';

            if (!$row['lslb'] == "0") {
                echo '<td>
              <a
              class="btn btn-outline-primary btn-sm" disabled>' . $row['lslb'] . '
              </a>
              </td>';
            } else {
                echo '<td></td>';
            }
            echo '<td>
            <a
            class="btn btn-outline-primary btn-sm"
            href="#editModal"
            id="edit_id"
            data-toggle="modal"
            data-id="' . $row['idsnumber'] . '"
            data-backdrop="static">
            <i class="fa fa-edit">
            </i>
            </a>
            </td>';

            echo '<td>
            <a
            class="btn btn-outline-primary btn-sm"
            data-target="#deleteModal" ]
            id="delete_id"
            data-toggle="modal"
            data-id="' . $row['idsnumber'] . '"
            data-backdrop="static">
            <i
            class="fa fa-trash">
            </i>
            </a>
            </td>';

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
            echo '<td>' . $row['heads'] . '</td>';

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
        } else {
            echo '<tr>';
            echo '<td><span class="badge badge-warning">Evaluated</span></td>';
            echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
            echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</strong></td>';
            echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static">' . $row['assured'] . '</td>';
            echo '<td class="text-success">' . $row['f_id'] . '</td>';

            echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
            echo '<td>' . $row['animal'] . '</td>';
            echo '<td>' . $row['heads'] . '</td>';

            if (!$row['lslb'] == "0") {
                echo '<td><a class="btn btn-success btn-sm" href="../policy/agriagra?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
            } else {
                echo '<td><a class="btn btn-success btn-sm disabled" href="#">' . $row['lslb'] . '</a></td>';
            }

            echo '<td><a class="btn btn-success btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'AGRI" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
            echo '<td><a class="btn btn-success btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
            echo '<td>&nbsp;</td>';

            echo '</tr>';
        }
    }
    ?>


                        </tbody>
                    </table>
                </form>
            </div>

        </div>
    </div>

    </div>

    <!-- Footer-->

    <p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
        <br><small>
    </p>
    <!-- end footer-->
    <div class="modal animate fadeIn faster" id="deleteModal">
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

    <div class="modal animated fadeIn faster" id="editModal">
        <div class="modal-dialog">

            <div class="modal-content">
                <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>

                    <div class="modal-body">
                        <div class="fetched-data"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit_index_update">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal animated bounce faster" id="infoModal" role="dialog">
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


    <!-- Modal -->
    <div class="modal animated bounceInDown faster" id="myModal">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Insurance</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <form method="POST" action="" autocomplete="false">
                        <table class="table table-sm table-condensed">
                            <tr>
                                <th scope="row"><label for="rcv">Received Date (optional):</label></th>
                                <td><input id="rcv" type="date" name="rcv" tabindex="1"
                                        class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="type_agri">Type of AGRI-AGRA (optional):</label></th>
                                <td>
                                    <select id="type_agri" name="type_agri" class="form-control form-control-sm">
                                        <option value="AGRI" selected>Default</option>
                                        <option value="AGRI-ARB">DAR</option>
                                    </select>
                                </td>
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
                                        <option value="Leyte">LEYTE</option>
                                        <option value="Southern Leyte">SOUTHERN LEYTE</option>
                                        <option value="Biliran">BILIRAN</option>
                                        <option value="Northern Samar">NORTHERN SAMAR</option>
                                        <option value="Eastern Samar">EASTERN SAMAR</option>
                                        <option value="Western Samar">WESTERN SAMAR</option>
                                    </select></td>
                            </tr>

                            <?php

    } else {

        ?>
                            <th scope="row"><label for="address">Province</label></th>
                            <td><select id="province" name="province" placeholder="Leyte"
                                    class="form-control form-control-sm" tabindex="6" onfocus="getaddress(this.value);">
                                    <?php
$result = $db->prepare("SELECT province FROM location WHERE office = ? LIMIT 1");
        $result->execute([$_SESSION['office']]);
        foreach ($result as $row) {
            echo '<option value="' . $row['province'] . '" selected>' . $row['province'] . '</option>';
        }
        ?>

                                </select></td>

                            <?php

    }
    ?>
                            <tr>
                                <th scope="row"><label for="address">Town</label></th>
                                <td><select id="town" name="town" class="form-control form-control-sm" tabindex="7">
                                        <option value=""></option>
                                    </select></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="farmer-count">Farmers</label></th>
                                <td><input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"
                                        tabindex="8" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="head-count">Heads</label></th>
                                <td><input type="number" id="head-count" name="head-count" required min=0 step="any"
                                        tabindex="9" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="animal-type">Kind of Animal: </label></th>
                                <td><select name="animal-type" id="animal-type" tabindex="10"
                                        class="form-control form-control-sm">
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
                                    </select></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="tag">COLC / COTC / TAG</label></th>
                                <td><input type="text" name="tag" class="form-control form-control-sm" tabindex="11">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="rate">Premium Rate</label></th>
                                <td><input type="number" min=0 step="any" name="rate" id="rate" required
                                        placeholder="0.00" tabindex="12" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="cover">Amount Cover</label></th>
                                <td><input type="number" min=0 step="any" name="cover" id="cover" required
                                        placeholder="0.00" tabindex="13" class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="datepicker1">Start of Cover</label></th>
                                <td><input type="date" name="effectivity-date" tabindex="14"
                                        class="form-control form-control-sm" id="datepicker1" required></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="datepicker2">End of Cover</label></th>
                                <td><input type="date" name="expiry-date" required tabindex="15"
                                        class="form-control form-control-sm" id="datepicker2"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="iu">IU/Solicitor</label></th>
                                <td><input type="text" name="iu" id="iu" tabindex="16"
                                        class="form-control form-control-sm"></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="notes">Notes:</label></th>
                                <td><textarea name="notes" id="notes" maxlength="1000" tabindex="17"
                                        class="form-control form-control-sm"></textarea></td>
                            </tr>
                        </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="submiter" class="btn btn-primary" tabindex="18"
                        name="submiter">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>







</body>

</html>

<?php

} catch (Exception $e) {
    echo "No Data Found";
}
?>

<?php

//End Cache

#include '../bottom.php';

?>



<script>
function groupName() {
    var input = document.getElementById('group-name');
    input.focus();
    input.select();
}

function lslb() {
    var input = document.getElementById('lslb');
    input.focus();
    input.select();
}
</script>