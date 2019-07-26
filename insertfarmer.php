<?php
include("connection/conn.php");
$notice="";

$ids = $_POST['ids'];
$surname = strtoupper($_POST['snn']);
$firstname = strtoupper($_POST['fnn']);
$middlename = strtoupper($_POST['mnn']);
$bday = date("Y-m-d",strtotime($_POST['bdd']));
$address = strtoupper($_POST['adres']);


$result = $db->prepare("INSERT INTO farmers (surname,firstname,middlename,bday,address,ids)
					VALUES(?,?,?,?,?,?)");

$result->execute([$surname, $firstname, $middlename, $bday, $address, $ids]);

$cnt = $result->rowCount();
if($cnt > 0){

$notice = "Success";



}
else
{
$notice = "failed";

}	



?>

<tr>
	<td><?php echo $notice; ?></td>
</tr>	

