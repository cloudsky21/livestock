<?PHP
session_start();
include("../../connection/conn.php"); 
require '../../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();
$table = $obj->acpc();



if(!isset($_SESSION['token'])) { header("location: ../logmeOut");}
$ids = htmlentities($_POST['rowid']);
$result = $db->prepare("SELECT * FROM $table WHERE idsnumber = ?");
$result->execute([$ids]);
foreach ($result as $row){	
	$d_received = date("m/d/Y", strtotime($row['date_r']));
	$program = $row['program'];
	$group = $row['groupName'];
	$lsp = $row['lsp'].sprintf("%04d",$ids)."-".$row['idsprogram'];
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
	$prem_loading = $row['loading'];	
}
?>

<table class="table table-condensed table-sm">
	<tbody>
		<tr>
			<th scope="row">Policy Number</th>
			<td><strong class="text-warning"><?PHP echo $lsp; ?></strong></td>
		</tr>
		<tr>
			<th scope="row">Date Received</th>
			<td><?PHP echo $d_received; ?></td>
		</tr>
		<tr>
			<th scope="row">Program Type</th>
			<td><?PHP echo $program; ?></td>
		</tr>
		<tr>
			<th scope="row">Group Name</th>
			<td><?PHP echo $group; ?></td>
		</tr>
		<tr>
			<th scope="row">Assured Farmers</th>
			<td><?PHP echo $assured; ?></td>
		</tr>
		<tr>
			<th scope="row">Number of Farmers</th>
			<td><?PHP echo $fcount; ?></td>
		</tr>
		<tr>
			<th scope="row">Heads / Animal Count</th>
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
			<th scope="row">Start of Cover</th>
			<td><?PHP echo $d_from; ?></td>
		</tr>
		<tr>
			<th scope="row">End of Cover</th>
			<td><?PHP echo $d_to; ?></td>
		</tr>
		<tr>
			<th scope="row">Premium Loading</th>
			<td><?PHP echo $prem_loading; ?></td>
		</tr>
		<tr>
			<th scope="row">Applications</th>
			<td><?PHP if(file_exists('../uploads/ACPC/'.$_SESSION['insurance'].'/'.$ids.'ACPC.pdf')){ echo '<a href="../uploads/ACPC/'.$_SESSION['insurance'].'/'.$ids.'ACPC.pdf" download>'.$ids.'.pdf</a><br>';} else { echo "<strong>No File Uploaded</strong>";} ?></td>
		</tr>
	</tbody>
</table>
