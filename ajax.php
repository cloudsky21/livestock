<?php
include("connection/conn.php");

$var = $_POST['id'];

$result  = $db->prepare("SELECT * FROM farmers WHERE ids = ?");
$result->execute([$var]);
?>
<table class="table table-striped">
 <thead>
	<tr>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Middle Name</th>
		<th>Birthday</th>
		<th>Address</th>
	</tr>
</thead>
<tbody>	
<?php
foreach ($result as $row){

echo '<tr>';	
echo '<td>'.$row['surname'].'</td>';	
echo '<td>'.$row['firstname'].'</td>';
echo '<td>'.$row['middlename'].'</td>';
echo '<td>'.$row['bday'].'</td>';
echo '<td>'.$row['address'].'</td>';
echo '</tr>';	
}

?>
</table>
</tbody>