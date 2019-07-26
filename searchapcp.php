<?PHP
session_start();
require_once("connection/conn.php");
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();
$table = $obj->apcp();


$server = $_SERVER['SERVER_ADDR'];




if(isset($_POST['ids'])){
	
$tobeSrch = $_POST['ids'];
if(!empty($tobeSrch)){
$result = $db->prepare("SELECT * FROM $table WHERE idsnumber LIKE ?");
$result->execute([$tobeSrch]);
foreach($result as $row){
	
			if ($row['status'] =="active"){
				echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
				
						if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
						if($server == "127.0.0.1"){	echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
							 echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}
		
				echo '</tr>';
			}
			
			else if($row['status'] =="cancelled") {
				echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
						if($server == "127.0.0.1"){	echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
							 echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}
		
				echo '</tr>';
			}
		}
}
else {
	$result = $db->prepare("SELECT * FROM $table ORDER BY idsnumber DESC LIMIT 0, 100");
	$result->execute();
foreach($result as $row){
	
			if ($row['status'] =="active"){
				echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
				
						if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
						if($server == "127.0.0.1"){	echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
							 echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}
		
				echo '</tr>';
			}
			
			else if($row['status'] =="cancelled") {
				echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-default btn-xs" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-default btn-xs disabled" href="#">'.$row['lslb'].'</a></td>';}
						if($server == "127.0.0.1"){	echo '<td><a class="btn btn-default btn-xs" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
							 echo '<td><a class="btn btn-default btn-xs" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}
		
				echo '</tr>';
			}
		}
	
	
	
	
}

}
?>

