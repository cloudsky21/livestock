<?PHP
session_start();
include("../connection/conn.php"); 
date_default_timezone_set('Asia/Manila');



$ids = htmlentities($_POST['rowid']);

$result = $db->prepare("SELECT * FROM controlr WHERE idsnumber = ?");
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


<ul class="list-group">
	<h2><?PHP echo $lsp; ?></h2>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Date Received</h4>
		<p><?PHP echo $d_received; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Receipt Number</h4>
		<p><?PHP echo $rcpt_number; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Receipt Amount</h4>
		<p><?PHP echo number_format($rcpt_amt,2); ?></p>
	</li>	
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Group Name or Lending Institution</h4>
		<p><?PHP echo $group; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Assured Farmers</h4>
		<p><?PHP echo $assured; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Number of Farmers Assured</h4>
		<p><?PHP echo $fcount; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Heads / Animal Count</h4>
		<p><?PHP echo $fhead; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Amount Cover</h4>
		<p><?PHP echo number_format($ac,2); ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Rate</h4>
		<p><?PHP echo $rate; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Premium</h4>
		<p><?PHP echo number_format($premium,2); ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Service Charge</h4>
		<p><?PHP echo $s_charge; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Start of Cover</h4>
		<p><?PHP echo $d_from; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">End of Cover</h4>
		<p><?PHP echo $d_to; ?></p>
	</li>
	<li class="list-group-item">
		<h4 class="list-group-item-heading">Applications</h4>
		<p><?PHP if(file_exists('uploads/REGULAR/'.$_SESSION['insurance'].'/'.$ids.'REG.pdf')){ echo '<a href="uploads/REGULAR/'.$_SESSION['insurance'].'/'.$ids.'REG.pdf" download'.$_SESSION['insurance'].'/>'.$ids.'.pdf</a><br>';} else { echo "<strong>No File Uploaded</strong>";} ?></p>
	</li>

</ul>

