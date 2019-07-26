<?php
session_start();
require_once "../connection/conn.php";
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

$table = $obj->saad();

if (isset($_POST['printBtn'])) {
    if (!empty($_POST['chkPrint'])) {

        $row = $_POST['chkPrint'];
        foreach ($row as $key => $value) {

            $used_program = "SAAD";
            $result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ? order by idsnumber DESC");
            $result->execute([$value]);
            foreach ($result as $row) {
                $assured = strtoupper($row['assured']);
                $address = strtoupper($row['town']) . ', ' . strtoupper($row['province']);
                $animal = strtoupper($row['animal']);
                $lsp = strtoupper($row['lsp']) . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'];
                $premium_loading = strtoupper($row['loading']);
                $d_rcv = date("F j, Y", strtotime($row['date_r']));
                $groupname = strtoupper($row['groupName']);
                $lender = "";
                $dfrom = date('F j, Y', strtotime($row['Dfrom']));
                $dto = date('F j, Y', strtotime($row['Dto']));
                $sum_insured = number_format($row['amount_cover'], 2);
                $rate = number_format($row['rate'], 2);
                $premium = number_format($row['premium'], 2);
                $heads = number_format($row['heads']);
                $farmers = number_format($row['farmers']);
                $lslb = $row['lslb'];
                $iu = $row['iu'];
                $prepared = $row['prepared'];
                $or = '222222-' . substr($_SESSION['insurance'], -2) . '-SAAD-' . sprintf("%04d", $row['idsnumber']) . '-L';
                $status = $row['status'];
                $f_id = $row['f_id'];

            }

            $rcount = $result->rowCount();
            if ($rcount > 0) {
                if ($lslb == '0') {$lslb = "";} else { $lslb = $lslb;}
                switch ($status) {
                    case 'active':
                        # active
                        $displaystat = "Note: Subject to possible changes.";
                        break;

                    case 'cancelled':
                        # cancelled
                        $displaystat = "Note: Cancelled Application.";
                        break;

                    default:
                        # Evaluated
                        $displaystat = "Note: Evaluated";
                        break;
                }

                $displaydata = '

				<table class="table table-condensed table-bordered font-md">
				<tr>
				<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>
				<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>(' . $used_program . ')</strong></h5></td>
				</tr>
				<tr>
				<th scope="row"><label>NAME</label></th>
				<td><strong>' . $assured . '</strong> <small>(ID: ' . $f_id . ')</small></td>
				<td><small>' . $displaystat . '</small></td>
				<td></td>
				</tr>
				<tr>
				<td><label>ADDRESS</label></td>
				<td>' . $address . '</td>
				<td><label>LOGBOOK</label></td>
				<td><h4><strong>' . $lslb . '</strong></h4></td>
				</tr>
				<tr>
				<td><label>KIND OF ANIMAL + PURPOSE</label></td>
				<td>' . $animal . '</td>
				<td><label>POLICY NO.</label></td>
				<td><h4><strong>' . $lsp . '</strong></h4></td>
				</tr>
				<tr>
				<td><label>GROUP</label></td>
				<td><strong>' . $groupname . '</strong></td>
				<td><label>DATE RECEIVED</label></td>
				<td>' . $d_rcv . '</td>
				</tr>
				<tr>
				<td><label>PREMIUM LOADING</label></td>
				<td colspan="3">' . $premium_loading . '</td>
				</tr>

				<tr>
				<td><label>EFFECTIVITY DATE</label></td>
				<td>' . $dfrom . '</td>
				<td><label>EXPIRY DATE</label></td>
				<td>' . $dto . '</td>
				</tr>
				<tr>
				<td><label>OR NO.</label></td>
				<td><strong>' . $or . '</strong></td>
				<td><label>BASIC PREMIUM</label></td>
				<td><strong>' . $premium . '</strong></td>
				</tr>
				<tr>
				<td><label>TOTAL SUM INSURED</label></td>
				<td>' . $sum_insured . '</td>
				<td><label>PREMIUM RATE</label></td>
				<td>' . $rate . ' %</td>
				</tr>

				<tr>
				<td><label>FARMERS</label></td>
				<td>' . $farmers . '</td>
				<td><label>HEADS</label></td>
				<td>' . $heads . '</td>
				</tr
				>
				</table>';

            }

            ?>
<!DOCTYPE html>
<html>

<head>
    <title>PROCESSING SLIP</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="shortcut icon" href="../images/favicon.ico">

    <link rel="stylesheet" href="../resources/bootswatch-3/solar/bootstrap.css">
    <link rel="stylesheet" href="../resources/css/local.css">

</head>

<body>


    <?php echo $displaydata ?>
    <div class="container">
        <p class="col-xs-4">BENITA M. ALBERTO<br><small>OIC-CHIEF, Marketing and Sales Division</small></p>
        <p class="col-xs-4"><?php echo $prepared ?> <br><small>Prepared By</small></p>
        <p class="col-xs-4"><?php echo $iu ?> <br><small>IU/Solicitor/AT</small></p>
    </div>

    <p class="text-center">
        __________________________________________________________________________________________________________________________________________________________________________________________
    </p>





</body>

</html>

<?php
}

    }

} # end isset printBtn

if (isset($_POST['pIDSBtn'])) {
    $displaydata = "";
    if (!empty($_POST['chkPrint'])) {

        $row = $_POST['chkPrint'];
        foreach ($row as $key => $value) {

            $used_program = "SAAD";
            $result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ? order by idsnumber DESC");
            $result->execute([$value]);
            foreach ($result as $row) {
                $assured = strtoupper($row['assured']);
                $address = strtoupper($row['town']) . ', ' . strtoupper($row['province']);
                $animal = strtoupper($row['animal']);
                $lsp = strtoupper($row['lsp']) . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'];
                $premium_loading = strtoupper($row['loading']);
                $d_rcv = date("F j, Y", strtotime($row['date_r']));
                $groupname = strtoupper($row['groupName']);
                $lender = "";
                $dfrom = date('F j, Y', strtotime($row['Dfrom']));
                $dto = date('F j, Y', strtotime($row['Dto']));
                $sum_insured = number_format($row['amount_cover'], 2);
                $rate = number_format($row['rate'], 2);
                $premium = number_format($row['premium'], 2);
                $heads = number_format($row['heads']);
                $farmers = number_format($row['farmers']);
                $lslb = $row['lslb'];
                $iu = $row['iu'];
                $prepared = $row['prepared'];
                $or = '222222-' . substr($_SESSION['insurance'], -2) . '-SAAD-' . sprintf("%04d", $row['idsnumber']) . '-L';
                $status = $row['status'];
                $f_id = $row['f_id'];

                $rcount = $result->rowCount();
                if ($rcount > 0) {
                    if ($lslb == '0') {$lslb = "";} else { $lslb = $lslb;}

                    $displaydata .= '



					<tr>
						<td>' . $groupname . '</td>
						<td><b>' . $assured . '</b><br><small>' . $address . '</small></td>
						<td>' . $animal . '<br><b>' . $lsp . '<br></b><br><small><b style="color:red">' . $or . '</b></small></td>
						<td><b>' . $heads . '</b></td>
						<td>' . $sum_insured . '</td>
						<td>' . $premium . '</td>
						<td>' . $rate . '%</td>
						<td>' . $dfrom . '</td>
						<td>' . $dto . '</td>
						<td>' . $lslb . '</td>


					</tr>
				';

                }

            }

        }
    }
    ?>
<!DOCTYPE html>
<html>

<head>
    <title>Livestock Transmital Report</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="shortcut icon" href="../images/favicon.ico">

    <link rel="stylesheet" href="../resources/bootswatch-3/solar/bootstrap.css">
    <link rel="stylesheet" href="../resources/css/local.css">

</head>

<body>
    <table class="table table-condensed table-bordered font-md">
        <tr>
            <td colspan="2">
                <h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6>
            </td>
            <td colspan="8">
                <h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>(<?php echo $used_program ?> )</strong></h5>
            </td>
        </tr>

        <tr>
            <th scope="row"><label>GROUP</label></th>
            <th scope="row"><label>FARMER</label></th>
            <th scope="row"><label>ANIMAL</label></th>
            <th scope="row"><label>HEADS</label></th>
            <th scope="row"><label>AC</label></th>
            <th scope="row"><label>PREMIUM</label></th>
            <th scope="row"><label>RATE</label></th>
            <th scope="row"><label>EFFECTIVITY</label></th>
            <th scope="row"><label>EXPIRY</label></th>
            <th scope="row"><label>LOGBOOK#</label></th>
        </tr>

        <?php echo $displaydata ?>
    </table>

    <div class="container">
        <p class="col-xs-4">BENITA M. ALBERTO<br><small>OIC-CHIEF, Marketing and Sales Division</small></p>
        <p class="col-xs-4"><?php echo $prepared ?> <br><small>Prepared By</small></p>
        <p class="col-xs-4"><?php echo $iu ?> <br><small>IU/Solicitor/AT</small></p>
    </div>

    <p class="text-center">
        __________________________________________________________________________________________________________________________________________________________________________________________
    </p>





</body>

</html>
<?php

}

?>