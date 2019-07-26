<?php
require_once("../connection/conn.php");
date_default_timezone_set('Asia/Manila');

	
if(isset($_GET['term']))
{
$string = $_GET['term'];
$result = $db->prepare("SELECT name FROM groupName WHERE name LIKE ? ORDER BY id DESC");
$result->execute(['%'.$string.'%']);

foreach($result as $row)
{

	$data[] = $row['name'];
}


echo json_encode($data);
}
?>