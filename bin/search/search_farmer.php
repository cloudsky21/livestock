<?php
require_once("../../connection/conn.php");
date_default_timezone_set('Asia/Manila');

if(isset($_POST['id']))
{
	$string = $_POST['id'];
	$result = $db->prepare("SELECT name, province, city FROM farmers WHERE id = ? ORDER BY id DESC");
	$result->execute([$string]);

	if($result->rowCount() > 0) {
		foreach($result as $row)
		{

			$data[] = array(
				'name' => strtoupper($row['name']),
				'province' => strtoupper($row['province']),
				'town' => strtoupper($row['city'])
			);
		}
		echo json_encode($data);	
	} 
	


	
}
?>