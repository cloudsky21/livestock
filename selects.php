<?php
session_start();
include("connection/conn.php");


$peo = htmlentities($_POST['id']);

if($peo == "all"){
	$result = $db->prepare("SELECT * FROM location WHERE 1 ORDER BY barangay");
	$result->execute();



		foreach($result as $row){
	
	
			echo '<option value="'.$row['town'].', '.$row['barangay'].'">'.$row['town'].', '.$row['barangay'].'</option>';
		}

}

	else
		{
			$result = $db->prepare("SELECT town, barangay FROM location WHERE office = ? ORDER BY barangay");
			$result->execute([$peo]);
				
				foreach($result as $row){
					echo '<option value="'.$row['town'].', '.$row['barangay'].'">'.$row['town'].', '.$row['barangay'].'</option>';
				}


		}







?>