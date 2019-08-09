<?PHP
session_start();
include("../../connection/conn.php");
require '../../myload.php';

use Classes\programtables;

$obj = new programtables();
$table = $obj->apcp();

date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['token'])) {
	header("location: ../logmeOut");
}

$ids = htmlentities($_POST['rowid']);

$result = $db->prepare("SELECT * FROM $table WHERE idsnumber = ?");
$result->execute([$ids]);

foreach ($result as $row) {

	$d_received = date("m/d/Y", strtotime($row['date_r']));
	$program = $row['program'];
	$group = $row['groupName'];
	$lsp = $row['lsp'] . sprintf("%04d", $ids) . "-" . $row['idsprogram'];
	$province = $row['province'];
	$town = $row['town'];
	$assured = $row['assured'];
	$fcount = $row['farmers'];
	$fhead = $row['heads'];
	$animals = $row['animal'];
	$premium = $row['premium'];
	$ac = $row['amount_cover'];
	$rate = $row['rate'];
	$d_from = date("m/d/Y", strtotime($row['Dfrom']));
	$d_to = date("m/d/Y", strtotime($row['Dto']));
	$prem_loading = $row['loading'];
	$tag = $row['tag'];
	$f_id = $row['f_id'];
	$notes = $row['comments'];
	if ($row['heads'] > 1) {
		$sum_insured_per_head = ' <small><i>(' . number_format(($row['amount_cover'] / $row['heads']), 2) . ')</i></small>';
		$rate_per_head = ' <small><i>(' . number_format(($row['premium'] / $row['heads']), 2) . ')</i></small>';
	} else {
		$sum_insured_per_head = "";
		$rate_per_head = "";
	}
}



?>
<table class="table table-condensed table-sm table-hover">
    <tbody>
        <tr>
            <th scope="row">Policy Number</th>
            <td>
                <strong class="text-warning">
                    <?PHP echo $lsp; ?>
                </strong>
            </td>
        </tr>
        <tr>
            <th scope="row">Date Received</th>
            <td>
                <?PHP echo $d_received; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Program Type</th>
            <td>
                <?PHP echo $program; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Group Name</th>
            <td>
                <?PHP echo $group; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Farmer ID</th>
            <td>
                <?PHP echo $f_id; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Assured Farmers</th>
            <td>
                <?PHP echo $assured; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Farmers</th>
            <td>
                <?PHP echo $fcount; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Heads</th>
            <td>
                <?PHP echo $fhead; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">COLC / CTC / TAG</th>
            <td class="text-success">
                <?PHP echo $tag; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Amount Cover</th>
            <td>
                <?PHP echo number_format($ac, 2) . $sum_insured_per_head; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Rate</th>
            <td>
                <?PHP echo $rate; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Premium</th>
            <td>
                <?PHP echo number_format($premium, 2) . $rate_per_head; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Start of Cover</th>
            <td>
                <?PHP echo $d_from; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">End of Cover</th>
            <td>
                <?PHP echo $d_to; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Premium Loading</th>
            <td>
                <?PHP echo $prem_loading; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Applications</th>
            <td>
                <?PHP if (file_exists('../uploads/RSBSA/' . $_SESSION['insurance'] . '/' . $ids . 'RSBSA.pdf')) {
					echo '<a href="../uploads/RSBSA/' . $_SESSION['insurance'] . '/' . $ids . 'RSBSA.pdf" download>' . $ids . '.pdf</a><br>';
				} else {
					echo "<strong>No File Uploaded</strong>";
				} ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Notes</th>
            <td>
                <?PHP echo $notes; ?>
            </td>
        </tr>
    </tbody>
</table>