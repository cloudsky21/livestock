<?PHP
session_start();
require "connection/conn.php";
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\monitoring;

$table = "processmonitoring";
$monitoring = new monitoring($table, $db);

#$combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));

if (isset($_POST['save'])) {
    $date = $_POST['rcvdate'];
    $time = $_POST['rcvtime'];

    $rcv = date('Y-m-d H:i:s', strtotime("$date $time"));
    $added = date('Y-m-d H:i:s');
    $sender = strtoupper(htmlentities($_POST['sender'], ENT_QUOTES));

    $save = [
        $_SESSION['insurance'],
        htmlentities($_POST['total_apps']),
        $rcv,
        $added,
        $sender
    ];

    $monitoring->insertData($save);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>PRODUCTION PROCESS MONITORING | Livestock Control</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- <meta http-equiv="refresh" content="180"> -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <!--[if IE]><link rel="shortcut icon" href="../images/favicon-32x32.ico" ><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
        href="resources/bootswatch/<?php echo $_SESSION['mode']; ?>/bootstrap.css?v=<?= filemtime('resources/bootswatch/' . $_SESSION['mode'] . '/bootstrap.css') ?>"
        media="screen">
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
                        <a class="dropdown-item" href="year">Insurance Year</a>
                        <a class="dropdown-item" href="farmers">Farmers List</a>
                        <a class="dropdown-item" href="accounts">Accounts</a>
                        <a class="dropdown-item" href="masterlist">RSBSA List</a>
                        <a class="dropdown-item" href="checkbox" target="_blank">Checklist</a>
                        <a class="dropdown-item" href="extract" target="_blank">Extract LIPs</a>
                        <a class="dropdown-item" href="printform">Batch Printing</a>
                        <a class="dropdown-item" href="processmonitoring">PRODUCTION PROCESS MONITORING</a>

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
                        <button class="btn btn-sm btn-warning" href="#" data-toggle="modal" data-target="#newRecord"
                            data-backdrop="static" data-keyboard="false" onClick="groupName();">New Record</button>
                    </a>
                </li>
                <!-- end add button -->
            </ul>
        </div>
    </div>
    </nav>

    <a class="scrolledup" href="#" id="scrolledup"> <span class="fa fa-angle-up"></span> </a>

    <div class="container-fluid">
        <div class="page-header" style="margin-top:50px;">
            <h2 class="display-5">Production Process Monitoring Board</h2>
            <div class="addbutton">
                <button class="btn btn-sm btn-default" href="#" data-toggle="modal" data-target="#newRecord"
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

            $rs3 = $db->prepare("SELECT COUNT(*) AS total FROM $table");
            $rs3->execute();

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
                    echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='processmonitoring?page=" . ($page - 1) . "'>Previous</a></li>";
                }

                //5 = 9, 4 = 7, 3 = 5
                for ($x = max($page - 3, 1); $x <= max(1, min($total_pages, $page + 3)); $x++) {

                    if ($page == $x) {
                        echo '<li class="page-item active">
					<a class="page-link" href="processmonitoring?page=' . $x . '">' . $x . '</a>
					</li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="processmonitoring?page=' . ($x) . '">' . $x . '</a></li>';
                    }
                }
                if ($page < $total_pages) {
                    echo "<li class='page-item' style='cursor:pointer'><a class='page-link' href='processmonitoring?page=" . ($page + 1) . "'>Next</a></li>";
                } else {
                    echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
                }

                echo '</ul>';

                ?>


            <table class="table table-condensed table-hover table-sm" id="displaydata">


                <thead>
                    <tr>
                        <th>ProcessID</th>
                        <th>IU/PEO/GROUP</th>
                        <th>Date and Time Received (RO)</th>
                        <th>Count (Cancelled)</th>
                        <th>Date Added/Controlled</th>
                        <th colspan="6">&nbsp;</th>

                    </tr>

                </thead>
                <tbody>
                    <?php


                        $rs = $db->prepare("SELECT * FROM $table ORDER BY processid DESC LIMIT ?, ?");
                        $rs->execute([$start_from, $results_per_page]);



                        foreach ($rs as $row) {

                            echo '<tr id="act_tr">';
                            echo '<td class="text-success" href="#infoModal" id="info_id" data-toggle="modal" data-id="' . $row['processid'] . '" data-backdrop="static">' . sprintf("%05d", $row['processid']) . '-' . $row['year'] . '</td>';
                            echo '<td>' . strtoupper($row['sender']) . '</td>';
                            echo '<td>' . date("M j, Y h:i A", strtotime($row['date_received'])) . '</td>';
                            echo '<td>' . $row['total'] . ' <i><small class="text-info">(' . $row['cancelled'] . ')</i><small></td>';
                            echo '<td>' . date("m-d-Y H:i", strtotime($row['date_added'])) . '</td>';

                            echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="' . $row['processid'] . '" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
                            echo '<td><a class="btn btn-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="' . $row['processid'] . '" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';

                            echo '</tr>';
                        }

                        ?>


                </tbody>
            </table>

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
                    <h4 class="modal-title">Details</h4>
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
    <div class="modal animated fade faster" id="newRecord" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Record</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" autocomplete="false">
                        <table class="table table-sm table-condensed" id="addInsurance">
                            <tr>
                                <th scope="row"><label for="rcv">Date Received (Office):</label></th>
                                <td><input id="rcv" type="date" name="rcvdate" tabindex="1"
                                        class="form-control form-control-sm" required>
                                    <input id="rcv" type="time" name="rcvtime" tabindex="2"
                                        class="form-control form-control-sm" required></td>
                            </tr>
                            <tr>
                                <th scope="row"><label for="sender">IU/PEO/GROUP/LENDER</label></th>
                                <td><input id="sender" type="text" name="sender" tabindex="3"
                                        class="form-control form-control-sm" required></td>
                            </tr>

                            <tr>
                                <th scope="row"><label for="total_apps">Total IP/Apps</label></th>
                                <td><input type="number" id="total_apps" name="total_apps" placeholder="0" required
                                        min=1 tabindex="4" class="form-control form-control-sm"></td>
                            </tr>
                        </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="save" class="btn btn-primary" tabindex="4" name="save"
                        data-loading-text="Adding Data..">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="resources/bootstrap-4/js/jquery.js"></script>
<script src="resources/bootstrap-4/umd/js/popper.js"></script>
<script src="resources/bootstrap-4/js/bootstrap.js"></script>
<script src="resources/bootstrap-4/umd/js/popper.js"></script>
<script type="text/javascript" src="resources/assets/js/css3-mediaqueries.js"></script>
<script type="text/javascript" src="resources/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    	<script type='text/javascript' src="../resources/html5shiv/src/html5shiv.js"></script>
  		<script type='text/javascript' src="../resources/Respond/src/respond.js"></script>
  	<![endif]-->
<script type="text/javascript" src="resources/js/rsbsa.js?v=<?= filemtime('resources/js/rsbsa.js'); ?>"></script>
<script type="text/javascript">
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
$(document).ready(function() {
    $('#infoModal').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            type: 'post',
            url: 'bin/details/pmonitoringdetails.php', //Here you will fetch records 
            data: 'rowid=' + rowid, //Pass $id
            success: function(data) {
                $('.fetched-data').html(data); //Show fetched data from database
            }
        });
    });
});

$(document).ready(function() {
    $("#sender").autocomplete({
        source: 'bin/search_group.php',
        messages: {
            noResults: function(count) {
                console.log("There were no matches.")
            },
            results: function(count) {
                console.log("There were " + count + " matches")
            }
        }
    });

});
</script>