<?php
session_start();
require_once "../connection/conn.php";
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\group;
use Classes\programtables;
use Classes\regular;

$obj = new programtables;

$table = $obj->regular();

$regular = new regular($table);
if (!isset($_SESSION['token'])) {
    header("location: ../logmeOut");
}

if (isset($_POST['submit_index'])) {

    $yearNow = $_SESSION['insuranceCode'];

    $getdate = $regular->getDate(date("Y-m-d", strtotime($_POST['rcv'])));

    $ids = "RO8-" . date("Y") . "-" . date("m");

    $LSP = $regular->lsp($_POST['animal-type']);
    $ids = "RO8-" . date("Y") . "-" . date("m");
    $program = "REGULAR";
    $unwanted = array("&NTILDE;" => "Ñ",
    "&AMP;" => "&"); // FILTER FOR SPECIAL CHARACTER 'Ñ'
    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted);
    $check_group = new group();
    $check_group->param($group);

    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted);
    $prepared = mb_strtoupper($_SESSION['isLoginName']);
    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);
    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];
    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));
    if (empty($_POST['prem_loading'])) {
        $prem_loading = "";
    } else {
        #$prem_loading = $_POST['prem_loading'];
        $prem_loading = 'Normal Cover - Typhoon and Flood';
        $prem_loading = htmlentities($prem_loading, ENT_QUOTES);
    }

    $rC_num = htmlentities($_POST['rcnum']);
    $rC_amt = htmlentities($_POST['rcAmt']);
    if (empty(htmlentities($_POST['scharge']))) {
        $s_charge = 0.00;
    } else {
        $s_charge = htmlentities($_POST['scharge']);
    }
    $rcdget = "none";

    $office_assignment = $regular->office_assignment($province, $town);

    $values = array(
        $yearNow, $getdate, $rC_num, $rC_amt, $rcdget, $group, $ids, $LSP, $province, $town, $assured,
        $_POST['farmer-count'], $_POST['head-count'], $_POST['animal-type'], $bpremium, $_POST['rate'], $_POST['cover'], $fromDate,
        $toDate, "active", $office_assignment, $s_charge, $prem_loading, $iu, $prepared,
    );

    $result = $regular->insertData($values);

    if ($result > 0) {

        $url = $_SERVER['REQUEST_URI'] . '#i' . $_POST['ids'];
        header("Location: " . $url);

    }

}
?>


<?php
if (isset($_POST['submit_update'])) {

    // Update application form pdf
    if (isset($_POST['fileUpload']) && !empty($_POST['fileUpload'])) {
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
            $newfilename = $_POST['ids'] . 'REGULAR' . '.' . end($temp);
            move_uploaded_file(
                $_FILES["fileUpload"]["tmp_name"],
                "../L/uploads/REGULAR/" . $_SESSION['insurance'] . '/' . $newfilename
            );

            $path = "../L/uploads/REGULAR/" . $_SESSION['insurance'] . '/' . $newfilename;
            $result = $db->prepare("UPDATE $table SET imagepath = ? WHERE idsnumber = ?");
            $result->execute([$path, $_POST['ids']]);

        }
    }

    $LSP = $regular->lsp($_POST['animal-type']);

    $unwanted = array("&NTILDE;" => "Ñ", "&AMP;" => "&");
    $group = strtr(mb_strtoupper(htmlentities($_POST['group-name'], ENT_QUOTES)), $unwanted);
    $assured = strtr(mb_strtoupper(htmlentities($_POST['assured-name'], ENT_QUOTES)), $unwanted);
    $iu = strtr(mb_strtoupper(htmlentities($_POST['iu'], ENT_QUOTES)), $unwanted);
    $prepared = mb_strtoupper($_SESSION['isLoginName']);
    $province = strtr(mb_strtoupper(htmlentities($_POST['province'], ENT_QUOTES)), $unwanted);
    $town = strtr(mb_strtoupper(htmlentities($_POST['town'], ENT_QUOTES)), $unwanted);

    if (!empty($_POST['rcd'])) {
        $getrcd = strtoupper(htmlentities($_POST['rcd']));
    } else {
        $getrcd = null;
    }

    $bpremium = ($_POST['rate'] / 100) * $_POST['cover'];

    $fromDate = date("Y-m-d", strtotime($_POST['effectivity-date']));
    $toDate = date("Y-m-d", strtotime($_POST['expiry-date']));

    $office_assignment = $regular->office_assignment($province, $town);
    $s_charge = htmlentities($_POST['scharge']) ?: 0.00;

    /*
    if (empty(htmlentities($_POST['scharge']))) {
    $s_charge = 0.00;
    } else {
    $s_charge = htmlentities($_POST['scharge']);
    }
     */

    $lslb = htmlentities($_POST['lslb']);
    $lslb = $lslb ?: 0;

    $values_update = array(
        $group, $assured, $province, $town, $_POST['farmer-count'], $_POST['head-count'], $_POST['animal-type'], $bpremium,
        $_POST['rate'], $_POST['cover'], $fromDate, $toDate, $_POST['stt'], $_POST['rcnum'], $_POST['rcAmt'], $LSP, $lslb,
        $office_assignment, $s_charge, $iu, $prepared, $_POST['ids'],
    );

    $result = $regular->updateData($values_update);

    if ($result > 0) {

        $url = $_SERVER['REQUEST_URI'];
        header("Location: " . $url);

    } else {
        $success = '<div class="alert alert-danger alert-dismissable" id="flash-msg">Record rejected for update.</div>';
    }

}

if (isset($_POST['delete_form'])) {

    $rec = htmlentities($_POST['recorded']);
    echo $rec;

    $result = $db->prepare("DELETE FROM $table WHERE idsnumber = ?");
    $result->execute([$rec]);

    $result = $db->prepare("ALTER TABLE $table AUTO_INCREMENT=1");
    $result->execute();

    header("location: " . $_SERVER[REQUEST_URI]);
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Regular | Livestock Control</title>

    <meta charset="utf8">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="../resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css?v=<?= filemtime('../resources/bootswatch/' . $_SESSION['mode'] . '/bootstrap.css') ?>"
        media="screen">
    <link rel="stylesheet" href="../resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../resources/css/local.css">
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
    <script type="text/javascript" language="javascript" src="../resources/js/regular.js"></script>
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
                        <a class="dropdown-item" href="farmers">Farmers List</a>
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

    <a class="scrolledup" href="#" id="scrolledup"> <span class="fa fa-angle-up"></span> </a>

    <div class="container-fluid">
        <div class="page-header" style="margin-top:50px;">
            <h2 class="display-5">Regular Program</h2>
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




        <div class="span3">
            <div class="table-responsive">
                <div style="overflow-x:auto;">
                    <table class="table table-condensed table-hover table-sm" id='displaydata'>

                        <?PHP

echo '<ul class="pagination pull-right">';

//Disables button on start of page
if ($page <= 1) {
    echo "<li class='page-item disabled'>
        <a class='page-link' href='#'>Previous</a></li>";
} else {
    echo "<li class='page-item' style='cursor:pointer'>
        <a class='page-link' href='regular?page=" . ($page - 1) . "'>Previous</a></li>";
}

for ($x = max($page - 3, 1); $x <= max(1, min($total_pages, $page + 3)); $x++) {

    // Higlights active page
    if ($page == $x) {
        echo '<li class="page-item active">
          <a class="page-link" href="regular?page=' . $x . '">' . $x . '</a>
          </li>';
    } else {
        echo '<li><a class="page-link" href="regular?page=' . ($x) . '">' . $x . '</a></li>';
    }
}

//Disables button on end of page
if ($page < $total_pages) {
    echo "<li class='page-item' style='cursor:pointer'>
       <a class='page-link' href='regular?page=" . ($page + 1) . "'>Next</a>
       </li>";

} else {
    echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
}

echo '</ul>';

?>

                        <form method="post" action="../printing/printbatchProcessingslipRegular" target="_blank">

                            <thead>
                                <tr>
                                    <th><input type="submit" class="btn btn-outline-primary btn-sm" name="printBtn"
                                            value="print"></th>
                                    <th>Date Received</th>
                                    <th>Lending Institution</th>
                                    <th>Livestock Policy Number</th>
                                    <th>Name Of Farmers / Assured</th>
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

        echo '<td class="text-center"><input type="checkbox" name="chkPrint[]" value="' . $row['idsnumber'] . '" id="#i' . $row['idsnumber'] . '" style="width:20px; height:20px;"></td>';
        echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
        echo '<td>' . $row['groupName'] . '</td>';
        echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '</strong></td>';
        echo '<td>' . $row['assured'] . '</td>';
        echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
        echo '<td>' . $row['animal'] . '</td>';
        echo '<td class="text-center">' . number_format($row['heads']) . '</td>';

        if (!$row['lslb'] == "0") {
            echo '<td><a class="btn btn-primary btn-sm" href="../policy/policyR.php?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
        } else {
            echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#"></a></td>';
        }
        echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'RRRR" target="_blank"><span class="fa fa-list"> </span></a></td>';
        echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><span class="fa fa-edit"></span></a></td>';
        if (!$row['lslb'] == "0") {
            echo '<td></td>';
        } else {
            echo '<td><a class="btn btn-outline-danger btn-sm" href="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><span class="fa fa-trash"></span></a></td>';
        }

        echo '</tr>';
    } else if ($row['status'] == "cancelled") {
        echo '<tr>';
        echo '<td class="text-center"><input type="checkbox" name="chkPrint[]" value="' . $row['idsnumber'] . '" style="width:20px; height:20px;"></td>';
        echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
        echo '<td>' . $row['groupName'] . '</td>';
        echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '&nbsp;' . $row['idsprogram'] . '</strong></td>';
        echo '<td>' . $row['assured'] . '</td>';
        echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
        echo '<td>' . $row['animal'] . '</td>';
        echo '<td class="text-center">' . number_format($row['heads']) . '</td>';
        if (!$row['lslb'] == "0") {
            echo '<td><a class="btn btn-primary btn-sm" href="../policy/policyR.php?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
        } else {
            echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="policyR.php?lslb=' . $row['lslb'] . '" target="_blank" readonly>' . $row['lslb'] . '</a></td>';
        }
        echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'RRRR" target="_blank"><span class="fa fa-list"> </span></a></td>';
        echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><span class="fa fa-edit"></span></a></td>';
        echo '<td><a class="btn btn-outline-danger btn-sm" href="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><span class="fa fa-trash"></span></a></td>';

        echo '</tr>';
    } else {
        echo '<tr>';
        echo '<td><span class="badge badge-warning">Evaluated</span></td>';
        echo '<td>' . date("m/d/Y", strtotime($row['date_r'])) . '</td>';
        echo '<td>' . $row['groupName'] . '</td>';
        echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><strong>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '</strong></td>';
        echo '<td>' . $row['assured'] . '</td>';
        echo '<td>' . $row['town'] . ', ' . $row['province'] . '</td>';
        echo '<td>' . $row['animal'] . '</td>';
        echo '<td class="text-center">' . number_format($row['heads']) . '</td>';

        if (!$row['lslb'] == "0") {
            echo '<td><a class="btn btn-info btn-sm" href="../policy/policyR.php?lslb=' . $row['lslb'] . '" target="_blank">' . $row['lslb'] . '</a></td>';
        } else {
            echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#"></a></td>';
        }
        echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids=' . $row['idsnumber'] . 'RRRR" target="_blank"><span class="fa fa-list"> </span></a></td>';
        echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['idsnumber'] . '" data-backdrop="static" data-keyboard="false"><span class="fa fa-edit"></span></a></td>';
        echo '<td></td>';

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
    </div>
    <div class="modal fade" id="deleteModal" role="dialog">
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

    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <form action="" method="post" class="form-horizontal">
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
                        <button type="submit" class="btn btn-primary" name="submit_update">Save Changes</button>
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










    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Insurance</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">


                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="rcv">Received Date (optional):</label>
                                <input id="rcv" type="date" name="rcv" tabindex="1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="rcnum">Receipt No.</label>
                                <input id="rcnum" type="number" name="rcnum" tabindex="2" placeholder="0000000" required
                                    step="any" class="form-control" autofocus>
                            </div>

                            <div class="col-lg-6">
                                <label for="rcAmt">Receipt Amount</label>
                                <input id="rcAmt" type="number" name="rcAmt" tabindex="3" placeholder="0000" required
                                    step="any" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-lg-6">
                                <label for="group-name">Group Name</label>
                                <input type="text" id="group-name" name="group-name" placeholder="DA/LGU or et. al."
                                    required maxlength="200" tabindex="4" class="form-control">
                            </div>

                            <div class="col-lg-6">
                                <label for="assured-name">Name of Assured</label>
                                <input type="text" name="assured-name" id="assured-name"
                                    placeholder="Juan Dela Cruz et. al." required maxlength="200" tabindex="5"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="address">Province</label>
                                <select id="province" name="province" placeholder="Leyte" class="form-control"
                                    onchange="getaddress(this.value);" tabindex="6">
                                    <option value="Leyte">LEYTE</option>
                                    <option value="Southern Leyte">SOUTHERN LEYTE</option>
                                    <option value="Biliran">BILIRAN</option>
                                    <option value="Northern Samar">NORTHERN SAMAR</option>
                                    <option value="Eastern Samar">EASTERN SAMAR</option>
                                    <option value="Western Samar">WESTERN SAMAR</option>
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <label for="address">Town</label>
                                <select id="town" name="town" class="form-control" tabindex="7">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label for="farmer-count">Farmers</label>
                                <input type="number" id="farmer-count" name="farmer-count" required min=0 step="any"
                                    tabindex="8" class="form-control">
                            </div>

                            <div class="col-lg-4">
                                <label for="head-count">Heads</label>
                                <input type="number" id="head-count" name="head-count" required min=0 step="any"
                                    tabindex="9" class="form-control">
                            </div>

                            <div class="col-lg-4">
                                <label for="animal-type">Kind of Animal: </label>
                                <select name="animal-type" id="animal-type" onchange="getch(this.value);" tabindex="10"
                                    class="form-control">

                                    <option name="animal" value="--------">---------</option>
                                    <option name="animal" value="Carabao-Breeder">Carabao Breeder</option>
                                    <option name="animal" value="Carabao-Draft">Carabao Draft</option>
                                    <option name="animal" value="Carabao-Dairy">Carabao Dairy</option>
                                    <option name="animal" value="Carabao-Fattener">Carabao Fattener</option>
                                    <option name="animal" value="--------">---------</option>
                                    <option name="animal" value="Cattle-Breeder">Cattle Breeder</option>
                                    <option name="animal" value="Cattle-Draft">Cattle Draft</option>
                                    <option name="animal" value="Cattle-Dairy">Cattle Dairy</option>
                                    <option name="animal" value="Cattle-Fattener">Cattle Fattener</option>
                                    <option name="animal" value="--------">---------</option>
                                    <option name="animal" value="Horse-Draft">Horse Draft</option>
                                    <option name="animal" value="Horse-Working">Horse Working</option>
                                    <option name="animal" value="Horse-Breeder">Horse Breeder</option>
                                    <option name="animal" value="--------">---------</option>
                                    <option name="animal" value="Swine-Fattener">Swine Fattener</option>
                                    <option name="animal" value="Swine-Breeder">Swine Breeder</option>
                                    <option name="animal" value="--------">---------</option>
                                    <option name="animal" value="Goat-Fattener">Goat Fattener</option>
                                    <option name="animal" value="Goat-Breeder">Goat Breeder</option>
                                    <option name="animal" value="Goat-Milking">Goat Milking</option>
                                    <option name="animal" value="--------">---------</option>
                                    <option name="animal" value="Sheep-Fattener">Sheep Fattener</option>
                                    <option name="animal" value="Sheep-Breeder">Sheep Breeder</option>
                                    <option name="animal" value="--------">---------</option>
                                    <option name="animal" value="Poultry-Broilers">Poultry-Broilers</option>
                                    <option name="animal" value="Poultry-Pullets">Poultry-Pullets</option>
                                    <option name="animal" value="Poultry-Layers">Poultry-Layers</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label for="rate">Premium Rate</label>
                                <input type="number" min=0 step="any" name="rate" id="rate" required placeholder="0.00"
                                    tabindex="11" class="form-control">
                            </div>

                            <div class="col-lg-3">
                                <label for="cover"><strong>Amount Cover</strong></label>
                                <input type="number" min=0 step="any" name="cover" id="cover" required
                                    placeholder="0.00" tabindex="12" class="form-control">
                            </div>

                            <div class="col-lg-4">
                                <label for="scharge">Service Charge</label>
                                <input type="number" min=0 step="any" name="scharge" id="scharge" placeholder="0.00"
                                    tabindex="13" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-lg-4">
                                <label for="datepicker1">Start of Cover</label>
                                <input type="date" name="effectivity-date" tabindex="14" class="form-control"
                                    id="datepicker1">
                            </div>

                            <div class="col-lg-4">
                                <label for="datepicker2">End of Cover</label>
                                <input type="date" name="expiry-date" tabindex="15" class="form-control"
                                    id="datepicker2">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="loading">Premium Loading</label>

                            <select id="prem_loading1" name="prem_loading[]" multiple class="form-control"
                                tabindex="13">
                                <?php
$result = $db->prepare("SELECT premium_loading,percentage FROM premload_list ORDER BY prem_id DESC");
$result->execute();

foreach ($result as $row) {

    echo '<option value="' . $row['premium_loading'] . '-' . $row['percentage'] . '">' . $row['premium_loading'] . ' - ' . $row['percentage'] . '</option>';
}

?>

                            </select>

                        </div>
                        <div class="form-group row">

                            <div class="col-lg-12">
                                <label for="iu">IU/Solicitpr</label>
                                <input type="text" id="iu" name="iu" tabindex="16" class="form-control">
                            </div>
                        </div>





                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" tabindex="17" name="submit_index">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</body>

</html>