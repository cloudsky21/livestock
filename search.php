<?PHP
session_start();
require_once("connection/conn.php");
date_default_timezone_set('Asia/Manila');

$table = "control".$_COOKIE['rrrrassdawds'];
$server = $_SERVER['SERVER_ADDR'];






if(isset($_POST['ids'])){
	
	$tobeSrch = htmlentities($_POST['ids']);

	$str1 = substr($tobeSrch,0,1);
	$str2 = substr($tobeSrch, 1);
	if(!empty($tobeSrch)){
		switch ($str1) {
			case "f":
			# code...
			echo $str1.'<br>';


			if($_SESSION['office']=="Regional Office")  
			{
				$result = $db->prepare("SELECT * FROM $table WHERE assured LIKE ?");
				$result->execute(['%'.$str2.'%']);
			}
			else
			{
				$result = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? && assured LIKE ?");
				$result->execute([$_SESSION['office'], '%'.$str2.'%']);	
			}

			foreach($result as $row){

				if ($row['status'] =="active"){
					echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-primary btn-sm" href="../processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';		
					echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-trash-o"></i></a></td>';} else {}

					echo '</tr>';
				}

				else if($row['status'] =="cancelled") {
					echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" class="color-1"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-primary btn-sm" href="../processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="glyphicon glyphicon-list"> </span></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}
			}



			break;

			case "i":
			# code...
			echo $str1."<br";


			if($_SESSION['office']=="Regional Office")  
			{
				$result = $db->prepare("SELECT * FROM $table WHERE idsnumber LIKE ?");
				$result->execute([$str2]);
			}
			else
			{
				$result = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? && idsnumber LIKE ?");
				$result->execute([$_SESSION['office'], $str2]);	
			}

			foreach($result as $row){

				if ($row['status'] =="active"){
					echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-primary btn-sm" href="../processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}

				else if($row['status'] =="cancelled") {
					echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" class="color-1"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-primary btn-sm" href="../processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="glyphicon glyphicon-list"> </span></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}
			}


			break;

			case "l":
			#code..

			echo $str1."<br";


			if($_SESSION['office']=="Regional Office")  
			{
				$result = $db->prepare("SELECT * FROM $table WHERE lslb LIKE ?");
				$result->execute([$str2]);
			}
			else
			{
				$result = $db->prepare("SELECT * FROM $table WHERE office_assignment = ? && lslb LIKE ?");
				$result->execute([$_SESSION['office'], $str2]);	
			}

			foreach($result as $row){

				if ($row['status'] =="active"){
					echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-primary btn-sm" href="../processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="fa fa-list"> </span></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}

				else if($row['status'] =="cancelled") {
					echo '<tr>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static" class="color-1"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-primary btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-primary btn-sm" href="../processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="fa fa-list"> </span></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-primary btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-primary btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}
			}
			break;
		}

	}
	
	
}
?>