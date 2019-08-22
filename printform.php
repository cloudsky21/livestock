<?php
session_start();
require_once "connection/conn.php";
require 'myload.php';

date_default_timezone_set('Asia/Manila');


if (!isset($_SESSION['token'])) {
    header("location: logmeOut");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Print Form</title>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">

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
                    <a class="nav-link" href="logmeOut"><i class="fa fa-sign-out" style="font-size:20px"></i></a></li>
            </ul>



        </div>
    </div>
    </nav>

    <div class="container-fluid">
        <!-- Table two -->

        <div style="margin-top: 50px;">
            <form method="post" action="printPage.php">
                <table class="table table-condensed table-hover table-sm">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th class="text-center">
                                <input type="checkbox" style="width:27px; height:27px; cursor: pointer;"
                                    onchange="checkAll(this)" class="btn btn-secondary btn-sm">
                                <div class="btn-group" role="group" aria-label="Action Button">


                                    <button id="actionBtnDropList" type="button"
                                        class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                                        <input type="submit" class="dropdown-item btn btn-outline-primary btn-sm"
                                            name="printFrm" value="Print">
                                    </div>
                                </div>
                            </th>

                            <th>SERIES</th>
                            <th>PROGRAM</th>
                            <th>STATUS</th>
                            <th>DATE-ADDED</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $t = 1;
                        $sql = $db->prepare('SELECT * FROM print WHERE  (userid = ? AND flag = ?) AND status = ?');
                        $sql->execute([$_SESSION['isLoginID'], 0, 'active']);

                        foreach ($sql as $row) {

                            switch ($row['program']) {
                                case 'PPPP':
                                    $program = 'RSBSA';
                                    break;
                                case 'PPPP-ARB':
                                    $program = 'RSBSA-ARB';
                                    break;
                                case 'PPPP-ACEF':
                                    $program = 'RSBSA-ACEF';
                                    break;
                                case 'AGRI':
                                    $program = 'AGRI-AGRA';
                                    break;
                                case 'AGRI-ARB':
                                    $program = 'AGRI-AGRA ARB';
                                    break;
                                case 'PNL':
                                    $program = 'PUNLA';
                                    break;
                                case 'APCP':
                                    $program = 'LBP-APCP';
                                    break;
                                case 'YRRP':
                                    $program = 'YRRP';
                                    break;
                            }

                            echo '<tr>';
                            echo '<td class="text-center">' . $t++ . '</td>';
                            echo '<td class="text-center"><input type="checkbox" name="chk[]" style="width:20px; height:20px; cursor: pointer;" value ="' . $row['program'] . ',' . $row['series'] . ',' . $row['printId'] . '">
                            </td>';
                            echo '<td>' . $row['series'] . '</td>';
                            echo '<td>' . $program . '</td>';
                            echo '<td>' . $row['status'] . '</td>';
                            echo '<td>' . date("F d, Y h:m:s A", strtotime($row['date'])) . '</td>';
                            echo '</tr>';
                        }
                        ?>


                    </tbody>
                </table>
            </form>
            <!-- Footer-->

            <p class="text-center"><small>© Copyrighted <?php echo $_SESSION['insurance']; ?></small>
                <br><small>
            </p>
            <!-- end footer-->
        </div>
</body>

</html>
<script>
function checkAll(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            console.log(i)
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = false;
            }
        }
    }
}
</script>