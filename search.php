<?PHP
session_start();
require("connection/conn.php");
require 'myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\Rsbsa;
use Classes\programtables;

$mytable = new programtables();
$table = $mytable->rsbsa();


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
				$result = $db->prepare("SELECT * FROM $table WHERE assured LIKE ? ORDER BY assured");
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
					echo '<td>'.$row['heads'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-success btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-success btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					if($server == "127.0.0.1") {	
						echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';} 
						else { echo '<td></td>';}		
					if (!$row['lslb']!="0") {echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';} else { echo '<td></td>';}

					echo '</tr>';
				}

				else if($row['status'] =="cancelled") {
					echo '<tr class="table-warning">';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					echo '<td>'.$row['heads'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-success btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="glyphicon glyphicon-list"> </span></a></td>';

					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-edit"/></span></a></td>';} else { echo '<td></td>';}		
					if (!$row['lslb']!="0") {echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-trash"/></i></a></td>';} else { echo '<td></td>';}
					echo '</tr>';
				}
				else if($row['status'] =="Evaluated") 
				{ 
					echo '<tr>';
					echo '<td><span class="badge badge-warning">Evaluated</span></td>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					echo '<td class="text-center">'.$row['heads'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-info btn-sm" href="../policy/policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';}
					echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
					echo '<td>&nbsp;</td>';						
					echo '</tr>';
				}
				else if($row['status'] =="Hold") 
				{ 
					echo '<tr>';
					echo '<td><span class="badge badge-danger">Hold</span></td>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					echo '<td class="text-center">'.$row['heads'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-info btn-sm" href="../policy/policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';}
					echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
					echo '<td>&nbsp;</td>';						
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
					echo '<td>'.$row['heads'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-success btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-success btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}

				else if($row['status'] =="cancelled") {
					echo '<tr class="table-warning">';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					echo '<td>'.$row['heads'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-success btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-success btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="glyphicon glyphicon-list"> </span></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}
				else
				{
					echo '<tr>';
					echo '<td><span class="badge badge-warning">Evaluated</span></td>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					echo '<td class="text-center">'.$row['heads'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-info btn-sm" href="../policy/policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';}
					echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
					echo '<td>&nbsp;</td>';						
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
					echo '<td>'.$row['heads'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-success btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="fa fa-list"> </span></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}

				else if($row['status'] =="cancelled") {
					echo '<tr class="table-warning">';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td>'.$row['groupName'].'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					//echo '<td><a class="btn btn-xs" role="button" href="#" data-toggle="modal" data-target="#aF" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="glyphicon glyphicon-plus" ></span></a></td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					echo '<td>'.$row['heads'].'</td>';
					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-outline-success btn-sm" href="policy.php?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-success btn-sm disabled" href="#">'.$row['lslb'].'</a></td>';}
					echo '<td><a class="btn btn-outline-success btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><span class="fa fa-list"> </span></a></td>';
					if($server == "127.0.0.1"){	echo '<td><a class="btn btn-outline-warning btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-edit"/></span></a></td>';		
					echo '<td><a class="btn btn-outline-danger btn-sm" data-target="#deleteModal" id="delete_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><span class="fa fa-trash"/></span></a></td>';} else {}

					echo '</tr>';
				}
				else
				{
					echo '<tr>';
					echo '<td><span class="badge badge-warning">Evaluated</span></td>';
					echo '<td>'.date("m/d/Y", strtotime($row['date_r'])).'</td>';
					echo '<td href="#infoModal" id="info_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><strong>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</strong></td>';
					echo '<td href="#addmembers" id="members" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static">'.$row['assured'].'</td>';
					echo '<td>'.$row['town'].', '.$row['province'].'</td>';
					echo '<td>'.$row['animal'].'</td>';
					echo '<td class="text-center">'.$row['heads'].'</td>';

					if (!$row['lslb']=="0") { echo '<td><a class="btn btn-info btn-sm" href="../policy/policy?lslb='.$row['lslb'].'" target="_blank">'.$row['lslb'].'</a></td>';}else {echo '<td><a class="btn btn-outline-primary btn-sm disabled"></a></td>';}
					echo '<td><a class="btn btn-info btn-sm" href="../printing/processingslip?ids='.$row['idsnumber'].'PPPP" target="_blank"><i class="fa fa-file-o"> </i></a></td>';
					echo '<td><a class="btn btn-info btn-sm" href="#editModal" id="edit_id" data-toggle="modal" data-id="'.$row['idsnumber'].'" data-backdrop="static"><i class="fa fa-edit"></i></a></td>';
					echo '<td>&nbsp;</td>';						
					echo '</tr>';
				}
			}
			break;
		}

	}
	
	
}
?>