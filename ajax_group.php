<?php	
session_start();
include("connection/conn.php");
date_default_timezone_set('Asia/Manila');

	$keyword = $_POST['query'];
	
	$table = "control".$_COOKIE['rrrrassdawds'];	
	$sql = $db->prepare("SELECT groupName FROM $table WHERE groupName LIKE '?%'");
	$sql->execute([$keyword]);
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$groupResult[] = $row["groupName"];
		}
		echo json_encode($groupResult);
	}
	
?>