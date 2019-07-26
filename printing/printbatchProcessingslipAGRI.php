<?php
session_start();
require_once "../connection/conn.php";
require '../myload.php';

date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

$table = $obj->agriagra();
$rsbsatbl = $obj->rsbsa();

if (isset($_POST['t_rsbsa'])) {
    if (!empty($_POST['chkPrint'])) {
        foreach ($_POST['chkPrint'] as $key => $value) {
            try
            {
                $db->beginTransaction();
                $sql =
                    "INSERT INTO
					`$rsbsatbl` (Year, date_r, groupName, ids1, lsp, status, office_assignment, province, town, assured, farmers, heads, animal, premium, amount_cover, rate, Dfrom, Dto, loading, iu, prepared, tag, f_id)
					SELECT Year, date_r, groupName, ids1, lsp, status, office_assignment, province, town, assured, farmers, heads, animal, premium, amount_cover, rate, Dfrom, Dto, loading, iu, prepared, tag, f_id
					FROM `$table` WHERE $table.idsnumber = ?";
                $result = $db->prepare($sql);
                $result->execute([$value]);
                $lastInsert = $db->lastInsertId();

                $update_result_agri = $db->prepare("UPDATE `$table` SET status = ?, comments = ? WHERE idsnumber = ?");
                $update_result_agri->execute(["cancelled", "Moved to RSBSA", $value]);
                $db->commit();
                echo 'IDS Transferred';
                echo '<script type="text/javascript">setTimeout("window.close();", 2000);</script>';
            } catch (PDOException $e) {
                $db->rollback();
                echo "ERROR: " . $e->getMessage();
            }
        }
    }
}

if (isset($_POST['evaluateBtn'])) {
    if (!empty($_POST['chkPrint'])) {
        foreach ($_POST['chkPrint'] as $key => $value) {
            $result = $db->prepare("UPDATE `$table` SET status = 'evaluated' WHERE idsnumber = ?");
            $result->execute([$value]);
        }
        header('location: ../programs/agriagra');
    }
} else if (isset($_POST['cancelBtn'])) {
    if (!empty($_POST['chkPrint'])) {
        foreach ($_POST['chkPrint'] as $key => $value) {
            $result = $db->prepare('UPDATE $table SET status = "cancelled" WHERE idsnumber = ?');
            $result->execute([$value]);
        }
        header('location:' . $_SERVER[REQUEST_URI]);
    }
} else if (isset($_POST['activeBtn'])) {
    if (!empty($_POST['chkPrint'])) {
        foreach ($_POST['chkPrint'] as $key => $value) {
            $result = $db->prepare('UPDATE $table SET status = "active" WHERE idsnumber = ?');
            $result->execute([$value]);
        }
        header('location:' . $_SERVER[REQUEST_URI]);
    }
} else if (isset($_POST['printBtn'])) {

    if (!empty($_POST['chkPrint'])) {

        $row = $_POST['chkPrint'];
        foreach ($row as $key => $value) {

            $used_program = "NON-RSBSA";
            $result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
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
                if ($row['idsprogram'] == 'AGRI') {
                    $or = 'AA2018-' . substr($_SESSION['insurance'], -2) . '-' . sprintf("%04d", $row['idsnumber']) . '-L';
                } else {
                    $or = 'AARB18-' . substr($_SESSION['insurance'], -2) . '-' . sprintf("%04d", $row['idsnumber']) . '-L';
                }
                $status = $row['status'];
                $tag = $row['tag'];
                $f_id = $row['f_id'];

                if ($row['heads'] > 1) {
                    $sum_insured_per_head = ' <small><i>(' . number_format(($row['amount_cover'] / $row['heads']), 2) . ')</i></small>';
                    $rate_per_head = ' <small><i>(' . number_format(($row['premium'] / $row['heads']), 2) . ')</i></small>';
                } else {
                    $sum_insured_per_head = "";
                    $rate_per_head = "";
                }

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
					</tr>
					<tr>
						<th scope="row"><label>ADDRESS</label></th>
							<td>' . $address . '</td>
						<th scope="row"><label>LOGBOOK</label></th>
							<td style="font-size: 14pt;"><strong>' . $lslb . '</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>KIND OF ANIMAL + PURPOSE</label></th>
							<td><strong>' . $animal . '</strong></td>
						<th scope="row"><label>POLICY NO.</label></th>
							<td style="font-size: 14pt;"><strong>' . $lsp . '</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>GROUP</label></th>
							<td><strong>' . $groupname . '</strong></td>
						<th scope="row"><label>DATE RECEIVED</label></th>
							<td>' . $d_rcv . '</td>
					</tr>
					<tr>
						<th scope="row"><label>PREMIUM LOADING</label></th>
							<td>' . $premium_loading . '</td>
						<th scope="row"><label>COLC/CTC/TAG</label></th>
							<td>' . $tag . '</td>
					</tr>
					<tr>
						<th scope="row"><label>EFFECTIVITY DATE</label></th>
							<td>' . $dfrom . '</td>
						<th scope="row"><label>EXPIRY DATE</label></th>
							<td>' . $dto . '</td>
					</tr>
					<tr>
						<th scope="row"><label>OR NO.</label></th>
							<td><strong>' . $or . '</strong></td>
						<th scope="row"><label>BASIC PREMIUM</label></th>
                            <td><strong>' . $premium . $rate_per_head . '</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>TOTAL SUM INSURED</label></th>
                            <td>' . $sum_insured . $sum_insured_per_head . ' </td>
						<th scope="row"><label>PREMIUM RATE</label></th>
							<td>' . $rate . ' %</td>
					</tr>
					<tr>
						<th scope="row"><label>FARMERS</label></th>
							<td>' . $farmers . '</td>
						<th scope="row"><label>HEADS</label></th>
							<td>' . $heads . '</td>
					</tr>
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
        <p class="col-xs-4"><strong>BENITA M. ALBERTO</strong> <br><small>OIC-CHIEF, Marketing and Sales
                Division</small></p>
        <p class="col-xs-4"><strong><?php echo $prepared ?></strong> <br><small>Prepared By</small></p>
        <p class="col-xs-4"><strong><?php echo $iu ?></strong> <br><small>IU/Solicitor/AT</small></p>
    </div>

    <p class="text-center">
        __________________________________________________________________________________________________________________________________________________________________________________________
    </p>





</body>

</html>

<?php
}
    } else {
        echo 'Use checbox to select policy for processing slip. This tab will close after 3 seconds..';
        echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';
    }
}

?>