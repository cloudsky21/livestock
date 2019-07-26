<?PHP
session_start();
date_default_timezone_set('Asia/Manila');

include("../../connection/conn.php"); 
require '../../myload.php';

use Classes\programtables;

$obj = new programtables();
$table = $obj->regular();

$ids = htmlentities($_POST['rowid']);

$result = $db->prepare("SELECT * FROM $table WHERE idsnumber = ?");
$result->execute([$ids]);

foreach ($result as $row){
	
	$d_received = date("m/d/Y", strtotime($row['date_r']));
	$group = $row['groupName'];
	$lsp = $row['lsp'].sprintf("%04d",$ids);
	$province = $row['province'];
	$town = $row['town'];
	$assured = $row['assured'];
	$fcount = $row['farmers'];
	$fhead = $row['heads'];
	$animals = $row['animal'];
	$premium = $row['premium'];
	$ac = $row['amount_cover'];
	$rate = $row['rate'];
	$d_from = date("m/d/Y",strtotime($row['Dfrom']));
	$d_to = date("m/d/Y",strtotime($row['Dto']));
	$rcpt_number = $row['receiptNumber'];
	$rcpt_amt = $row['receiptAmt'];
	$s_charge = number_format($row['s_charge'],2);
	
	
}



?>

<table class="table table-condensed table-sm table-hover">
	<tbody>
		<tr>
			<th scope="row">Policy Number</th>
			<td><?PHP echo $lsp; ?></td>
		</tr>
		<tr>
			<th scope="row">Date Received</th>
			<td><?PHP echo $d_received; ?></td>
		</tr>
		<tr>
			<th scope="row">Receipt Number</th>
			<td><?PHP echo $rcpt_number; ?></td>
		</tr>
		<tr>
			<th scope="row">Receipt Amount</th>
			<td><?PHP echo number_format($rcpt_amt,2); ?></td>
		</tr>
		<tr>
			<th scope="row">Group Name</th>
			<td><?PHP echo $group; ?></td>
		</tr>
		<tr>
			<th scope="row">Assured</th>
			<td><?PHP echo $assured; ?></td>
		</tr>
		<tr>
			<th scope="row">Farmers</th>
			<td><?PHP echo $fcount; ?></td>
		</tr>
		<tr>
			<th scope="row">Heads</th>
			<td><?PHP echo $fhead; ?></td>
		</tr>
		<tr>
			<th scope="row">Amount Cover</th>
			<td><?PHP echo number_format($ac,2); ?></td>
		</tr>
		<tr>
			<th scope="row">Rate</th>
			<td><?PHP echo $rate; ?></td>
		</tr>
		<tr>
			<th scope="row">Premium</th>
			<td><?PHP echo number_format($premium,2); ?></td>
		</tr>
		<tr>
			<th scope="row">Service Charge</th>
			<td><?PHP echo $s_charge; ?></td>
		</tr>
		<tr>
			<th scope="row">Start of Cover</th>
			<td><?PHP echo $d_from; ?></td>
		</tr>
		<tr>
			<th scope="row">End of Cover</th>
			<td><?PHP echo $d_to; ?></td>
		</tr>
		<tr>
			<th scope="row">Applications</th>
			<td><?PHP if(file_exists('uploads/REGULAR/'.$_SESSION['insurance'].'/'.$ids.'REG.pdf')){ echo '<a href="uploads/REGULAR/'.$_SESSION['insurance'].'/'.$ids.'REG.pdf" download'.$_SESSION['insurance'].'/>'.$ids.'.pdf</a><br>';} else { echo "<strong>No File Uploaded</strong>";} ?></td>
		</tr>
	</tbody>
</table>