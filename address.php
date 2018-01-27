<?php
session_start();
include("connection/conn.php");


$peo = htmlentities($_POST['id']);


$result = $db->prepare("SELECT * FROM location WHERE office = ? ORDER BY barangay");
$result->execute([$peo]);



foreach($result as $row){
	
	
	echo '<tr>';
		echo '<td>'.$row['office'].'</td>';
		echo '<td>'.$row['province'].'</td>';
		echo '<td>'.$row['town'].'</td>';
		echo '<td>'.$row['barangay'].'</td>';
	echo '<tr>';	
	
	
}


?>