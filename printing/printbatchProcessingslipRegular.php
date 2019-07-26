<?php
session_start();
require_once "../connection/conn.php";
require '../myload.php';

date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

$table = $obj->regular();

if (isset($_POST['printBtn'])) {

    if (!empty($_POST['chkPrint'])) {

        $row = $_POST['chkPrint'];
        foreach ($row as $key => $value) {

            $used_program = "REGULAR PROGRAM";
            $result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
            $result->execute([$value]);
            foreach ($result as $row) {
                $assured = strtoupper($row['assured']); /* Name of Farmer */
                $address = strtoupper($row['town']) . ', ' . strtoupper($row['province']); /* Address of Farmer (Format: Town, Province) */
                $animal = strtoupper($row['animal']); /* Kind of Animal */
                $lsp = strtoupper($row['lsp']) . '' . sprintf("%04d", $row['idsnumber']); /* Policy Number */
                $premium_loading = strtoupper($row['loading']); /* Addition premium */
                $d_rcv = date("F j, Y", strtotime($row['date_r'])); /* Date Received or date processed */
                $groupname = strtoupper($row['groupName']); /* Name of Group or Association */
                $lender = "";
                $dfrom = date('F j, Y', strtotime($row['Dfrom'])); /* Date of Effectivity */
                $dto = date('F j, Y', strtotime($row['Dto'])); /* Date of Expiry */
                $sum_insured = number_format($row['amount_cover'], 2); /* Amount Covered */
                $rate = number_format($row['rate'], 2); /* Premium Rate (Percentage) */
                $premium = $row['premium']; /* premium  - fetch from db */
                $doc_stamp = ($row['premium'] * (12.5 / 100)); /* Doc Stamp */
                $tax = ($row['premium'] * (5 / 100)); /* Tax */

                $total_gpremium = $premium + $doc_stamp + $tax; /* Total premium */

                $heads = $row['heads']; /* number of heads */
                $farmers = $row['farmers']; /* number of farmers */
                $lslb = $row['lslb']; /* Logbook Number */
                $or_num = $row['receiptNumber']; /* OR number */
                $or_amt = number_format($row['receiptAmt'], 2); /* OR Amount */
                $s_charge = number_format($row['s_charge'], 2); /* Service Charge */
                $remit = $total_gpremium - $s_charge; /* Deduction of Total premium from service charge */
                $iu = $row['iu']; /* Name of underwriter */
                $prepared = $row['prepared']; /* Name of Encoder */

            }

            if ($row['heads'] > 1) {
                $sum_insured_per_head = ' <small><i>(' . number_format(($row['amount_cover'] / $row['heads']), 2) . ')</i></small>';
                $rate_per_head_gps = ' <small><i>(' . number_format(($total_gpremium / $row['heads']), 2) . ')</i></small>';
                $rate_per_head_prem = ' <small><i>(' . number_format(($row['premium'] / $row['heads']), 2) . ')</i></small>';
            } else {
                $sum_insured_per_head = "";
                $rate_per_head_gps = "";
                $rate_per_head_prem = '';
            }

            $rcount = $result->rowCount();
            if ($rcount > 0) {
                if ($lslb == '0') {$lslb = "";} else { $lslb = $lslb;}
                $displaydata = '

		<table class="table table-condensed table-bordered">
		<tr>
		<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>
		<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>(' . $used_program . ')</strong></h5></td>
		</tr>
		<tr>
		<td><label>NAME</label></td>
		<td colspan="3">' . $assured . '</td>
		</tr>
		<tr>
		<td><label>ADDRESS</label></td>
		<td>' . $address . '</td>
		<td><label>LOGBOOK</label></td>
		<td><strong style="color:red; font-size: 14pt;">' . $lslb . '</strong></td>
		</tr>
		<tr>
		<td><label>KIND OF ANIMAL + PURPOSE</label></td>
		<td>' . $animal . '</td>
		<td><label>POLICY NO.</label></td>
		<td><h4><strong>' . $lsp . '</strong></h4></td>
		</tr>
		<tr>
		<td><label>GROUP</label></td>
		<td>' . $groupname . '</td>
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
		<td><strong>' . $or_num . '</strong></td>
		<td><label>OR AMOUNT</label></td>
		<td>' . $or_amt . '</td>
		</tr>
		<tr>
		<td><label>TOTAL SUM INSURED</label></td>
		<td><strong>' . $sum_insured . ' ' . $sum_insured_per_head . '</strong></td>
		<td><label>PREMIUM RATE</label></td>
		<td>' . $rate . ' %</td>
		</tr>

		<tr>
		<td><label>BASIC PREMIUM</label></td>
		<td><strong>' . number_format($premium, 2) . ' ' . $rate_per_head_prem . ' </strong></td>
		<td><label>GROSS PREMIUM</label></td>
		<td><strong>' . number_format($total_gpremium, 2) . ' ' . $rate_per_head_gps . '</strong></td>
		</tr>

		<tr>
		<td><label>DOC. STAMP</label></td>
		<td>' . number_format($doc_stamp, 2) . '</td>
		<td><label>TAX</label></td>
		<td>' . number_format($tax, 2) . '</td>
		</tr>

		<tr>
		<td><label>SERVICE CHARGE</label></td>
		<td>' . $s_charge . '</td>
		<td><label>AMOUNT REMITTED</label></td>
		<td><strong>' . number_format($remit, 2) . '</strong></td>
		</tr>

		<tr>
		<td><label>FARMERS</label></td>
		<td>' . $farmers . '</td>
		<td><label>HEADS</label></td>
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

    } else {
        echo 'Use checbox to select policy for processing slip. This tab will close after 3 seconds..';
        echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';
    }

}

?>