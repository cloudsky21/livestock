<?php
session_start();
include 'mympdf.php';
require_once 'connection/conn.php';
require 'myload.php';

use Classes\programtables;

$obj = new programtables();

date_default_timezone_set('Asia/Manila');
$vale = "";

if (!isset($_SESSION['token'])) {
    header("location: ../logmeOut");
}

if (isset($_POST['submit'])) {

    if (isset($_POST['range'])) {
        /*checkbox clicked*/
        $vale = "clicked";
        $getdate1 = date("Y-m-d", strtotime($_POST['date1']));

        switch ($_POST['program']) {
            case 'rsbsa':

                $table = $obj->rsbsa();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklist($getdate1, $db, $table, $code, 'RSBSA');
                break;
            case 'agri':
                $table = $obj->agriagra();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklist($getdate1, $db, $table, $code, 'NONE-RSBSA');
                break;
            case 'regular':
                $table = $obj->regular();
                checklistRegular($getdate1, $db, $table, 'Regular Program');
                break;
            case 'apcp':
                $table = $obj->apcp();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklist($getdate1, $db, $table, $code, 'APCP');
                break;

            case 'punla':
                $table = $obj->acpc();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklist($getdate1, $db, $table, $code, 'PUNLA');
                break;

            case 'saad':
                $table = $obj->saad();
                $code = substr($_SESSION['insurance'], -2) . '-SAAD-';
                checklist($getdate1, $db, $table, $code, 'SAAD');
                break;

            case 'yrrp':
                $table = $obj->yrrp();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklist($getdate1, $db, $table, $code, 'YRRP');
                break;
        }

    } else {

        $getdate1 = date("Y-m-d", strtotime($_POST['date1']));
        $getdate2 = date("Y-m-d", strtotime($_POST['date2']));

        switch ($_POST['program']) {
            case 'rsbsa':
                $table = $obj->rsbsa();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklistRange($getdate1, $getdate2, $db, $table, $code, 'RSBSA');
                break;
            case 'agri':
                $table = $obj->agriagra();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklistRange($getdate1, $getdate2, $db, $table, $code, 'NONE-RSBSA');
                break;
            case 'apcp':
                $table = $obj->apcp();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklistRange($getdate1, $getdate2, $db, $table, $code, 'APCP');
                break;
            case 'regular':
                $table = $obj->regular();
                checklistRegularRange($getdate1, $getdate2, $db, $table, 'Regular Program');
                break;

            case 'punla':
                $table = $obj->acpc();
                checklistRange($getdate1, $getdate2, $db, $table, $code, 'PUNLA');
                break;

            case 'saad':
                $table = $obj->saad();
                $code = substr($_SESSION['insurance'], -2) . '-SAAD-';
                checklistRange($getdate1, $getdate2, $db, $table, $code, 'SAAD');
                break;

            case 'yrrp':
                $table = $obj->yrrp();
                $code = substr($_SESSION['insurance'], -2) . '-';
                checklistRange($getdate1, $getdate2, $db, $table, $code, 'YRRP');
                break;

        }

    }

}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Checklist | Livestock Control</title>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="images/favicon.ico">

    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="resources/bootstrap-3.3.7-dist/css/bootstrap.css">
    <link rel="stylesheet" href="resources/css/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/local.css">
    <link rel="stylesheet" href="resources/multi-select/bootstrap-multiselect.css">
    <script src="resources/bootstrap-3.3.7-dist/js/jquery.min.js"></script>
    <script src="resources/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#range").click(function() {
            $("#date2").attr('disabled', !$("#date2").attr('disabled'));
        });

    });
    </script>

</head>

<body>
    <?php echo $vale ?>
    <div class="container">
        <div class="login col-centered">
            <h1 class="text-center">Checklist</h1>

            <form method="post" action="">
                <ul class="list-group">

                    <li class="list-group-item">
                        <div class="checkbox">
                            <label><input type="checkbox" id="range" name="range"> Disable/enable</label>
                        </div>
                        <div class="form-group">
                            <select id="program" name="program" class="form-control">
                                <option value="rsbsa">RSBSA</option>
                                <option value="regular">Regular</option>
                                <option value="agri">Agri-Agra</option>
                                <option value="apcp">LBP - APCP</option>
                                <option value="punla">Punla</option>
                                <option value="saad">SAAD</option>
                                <option value="yrrp">YRRP</option>
                            </select>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group">
                            <label>FROM</label>
                            <input type="date" name="date1" id="date1" class="form-control">
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="form-group">
                            <label>TO</label>
                            <input type="date" name="date2" id="date2" class="form-control disabled">
                        </div>
                    </li>

                    <li class="list-group-item">
                        <input type="submit" name="submit" class="form-control btn-primary" value="Submit">
                    </li>

                </ul>

            </form>
        </div>
    </div>

</body>

</html>