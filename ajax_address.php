<?php
session_start();
include("connection/conn.php");


$peo = htmlentities($_POST['id']);

	$result = $db->prepare("SELECT town FROM location WHERE province = ? GROUP BY town");
	$result->execute([$peo]);



		foreach($result as $row){
	
	
			echo '<option value="'.$row['town'].'">'.$row['town'].'</option>';
		}


?>