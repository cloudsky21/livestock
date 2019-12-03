<?php
session_start();
require_once "../connection/conn.php";
require '../myload.php';
date_default_timezone_set('Asia/Manila');

use Classes\programtables;
use Classes\util;

$obj = new programtables();
$util = new util('rsbsa', $db);

$table = $obj->yrrp();



if (isset($_POST['t_rsbsa'])) {

	$rsbsatbl = $obj->rsbsa();

	if (!empty($_POST['chkPrint'])) {
		foreach ($_POST['chkPrint'] as $key => $value) {


			try {
				$db->beginTransaction();

				$transact_1 = $db->prepare("SELECT Year, date_r, groupName, ids1, lsp, status, office_assignment, province, town, assured, farmers, heads, animal, premium, amount_cover, rate, Dfrom, Dto, loading, iu, prepared, tag, f_id, comments, lslb, idsnumber
				FROM `$table` WHERE $table.idsnumber = ?");
				$transact_1->execute([$value]);

				foreach ($transact_1 as $row) {
					$dYear = $row['Year'];
					$d_rec = $row['date_r'];
					$group = $row['groupName'];
					$program = 'RSBSA';
					$rsbsa_type = 'PPPP';
					$ids1 = $row['ids1'];
					$lsp = $row['lsp'];
					$status = $row['status'];
					$office = $row['office_assignment'];
					$province = $row['province'];
					$town = $row['town'];
					$assured = $row['assured'];
					$fcount = $row['farmers'];
					$fhead = $row['heads'];
					$animals = $row['animal'];
					$lslb = $row['lslb'];

					switch ($animals) {
						case 'Carabao-Breeder':
						case 'Carabao-Fattener':
						case 'Carabao-Dairy':
						case 'Carabao-Draft':
						case 'Cattle-Breeder':
						case 'Cattle-Fattener':
						case 'Cattle-Dairy':
						case 'Cattle-Draft':
						case 'Horse-Draft':


							$ac_default = 15000;

							$rate = 5;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;


						case 'Swine-Breeder':
							$ac_default = 10000;

							$rate = 3.5;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Swine-Fattener':
							$ac_default = 7000;

							$rate = 1.75;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Sheep-Breeder':
						case 'Sheep-Fattener':
						case 'Goat-Breeder':
						case 'Goat-Fattener':

							$ac_default = 6000;

							$rate = 6;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Poultry-Layers':
						case 'Poultry-Pullets':

							$ac_default = 200;

							$rate = 2.6;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Poultry-Broilers':


							$ac_default = 200;

							$rate = 1;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;
					}


					$d_from = date("Y-m-d", strtotime($row['Dfrom']));
					$d_to = date("Y-m-d", strtotime($row['Dto']));
					$prem_loading = 'All Diseases Covered';
					$tag = $row['tag'];
					$iu = $row['iu'];
					$prepared = $row['prepared'];
					$f_id = $row['f_id'];
					$notes = $row['comments'] . '/ Moved from YRRP -' . sprintf("%04d", $row['idsnumber']);
				}


				$columns = array(
					"Year", "date_r", "program", "groupName", "ids1", "lsp", "province", "town", "assured",
					"farmers", "heads", "animal", "premium", "amount_cover", "rate", "Dfrom", "Dto", "status", "office_assignment",
					"loading", "iu", "prepared", "tag", "f_id", "comments", "idsprogram", "lslb"
				);

				$placeholders = substr(str_repeat('?,', sizeOf($columns)), 0, -1);
				$result = $db->prepare(
					sprintf(
						"INSERT INTO %s (%s) VALUES (%s)",
						$rsbsatbl,
						implode(',', $columns),
						$placeholders
					)
				);

				$result->execute([
					$dYear, $d_rec, $program, $group, $ids1, $lsp, $province, $town, $assured,
					$fcount, $fhead, $animals, $premium, $ac, $rate, $d_from, $d_to, $status, $office, $prem_loading, $iu, $prepared, $tag, $f_id, $notes, $rsbsa_type, $lslb
				]);
				$lastInsert = $db->lastInsertId();


				$update_result_agri = $db->prepare("UPDATE `$table` SET status = ?, comments = ? WHERE idsnumber = ?");
				$update_result_agri->execute(["cancelled", "Moved to RSBSA", $value]);

				$update_print = $util->updatePrintForm($lastInsert, 'PPPP', $value, 'YRRP');
				$db->commit();

				echo '<script type="text/javascript">setTimeout("window.close();", 2000);</script>';
			} catch (PDOException $e) {
				$db->rollback();
				echo "ERROR: " . $e->getMessage();
			}
		}
	}
} else if (isset($_POST['t_agri'])) {

	$agriagratbl = $obj->agriagra();

	if (!empty($_POST['chkPrint'])) {
		foreach ($_POST['chkPrint'] as $key => $value) {


			try {
				$db->beginTransaction();

				$transact_1 = $db->prepare("SELECT Year, date_r, groupName, ids1, lsp, status, office_assignment, province, town, assured, farmers, heads, animal, premium, amount_cover, rate, Dfrom, Dto, loading, iu, prepared, tag, f_id, lslb, idsnumber
				FROM `$table` WHERE $table.idsnumber = ?");
				$transact_1->execute([$value]);

				foreach ($transact_1 as $row) {
					$dYear = $row['Year'];
					$d_rec = $row['date_r'];
					$group = $row['groupName'];
					$program = 'RSBSA';
					$agri_type = 'PPPP';
					$ids1 = $row['ids1'];
					$lsp = $row['lsp'];
					$status = $row['status'];
					$office = $row['office_assignment'];
					$province = $row['province'];
					$town = $row['town'];
					$assured = $row['assured'];
					$fcount = $row['farmers'];
					$fhead = $row['heads'];
					$animals = $row['animal'];
					$lslb = $row['lslb'];

					switch ($animal) {
						case 'Carabao-Breeder':
						case 'Carabao-Fattener':
						case 'Carabao-Dairy':
						case 'Carabao-Draft':
						case 'Cattle-Breeder':
						case 'Cattle-Fattener':
						case 'Cattle-Dairy':
						case 'Cattle-Draft':
						case 'Horse-Draft':


							$ac_default = 15000;

							$rate = 5;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;


						case 'Swine-Breeder':
							$ac_default = 10000;

							$rate = 3.5;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Swine-Fattener':
							$ac_default = 7000;

							$rate = 1.75;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Sheep-Breeder':
						case 'Sheep-Fattener':
						case 'Goat-Breeder':
						case 'Goat-Fattener':

							$ac_default = 6000;

							$rate = 6;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Poultry-Layers':
						case 'Poultry-Pullets':

							$ac_default = 200;

							$rate = 2.6;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;

						case 'Poultry-Broilers':


							$ac_default = 200;

							$rate = 1;
							$ac = $ac_default * $fhead;
							$premium = ($rate / 100) * $ac;

							break;
					}


					$d_from = date("Y-m-d", strtotime($row['Dfrom']));
					$d_to = date("Y-m-d", strtotime($row['Dto']));
					$prem_loading = 'All Diseases Covered';
					$tag = $row['tag'];
					$iu = $row['iu'];
					$prepared = $row['prepared'];
					$f_id = $row['f_id'];
					$notes = $row['comments'] . '/ Moved from YRRP -' . sprintf("%04d", $row['idsnumber']);
				}


				$columns = array(
					"Year", "date_r", "program", "groupName", "ids1", "lsp", "province", "town", "assured",
					"farmers", "heads", "animal", "premium", "amount_cover", "rate", "Dfrom", "Dto", "status", "office_assignment",
					"loading", "iu", "prepared", "tag", "f_id", "comments", "idsprogram", "lslb"
				);

				$placeholders = substr(str_repeat('?,', sizeOf($columns)), 0, -1);
				$result = $db->prepare(
					sprintf(
						"INSERT INTO %s (%s) VALUES (%s)",
						$agriagratbl,
						implode(',', $columns),
						$placeholders
					)
				);

				$result->execute([
					$dYear, $d_rec, $program, $group, $ids1, $lsp, $province, $town, $assured,
					$fcount, $fhead, $animals, $premium, $ac, $rate, $d_from, $d_to, $status, $office, $prem_loading, $iu, $prepared, $tag, $f_id, $notes, $agri_type, $lslb
				]);
				$lastInsert = $db->lastInsertId();


				$update_result_agri = $db->prepare("UPDATE `$table` SET status = ?, comments = ? WHERE idsnumber = ?");
				$update_result_agri->execute(["cancelled", "Moved to AGRI-AGRA", $value]);

				$update_print = $util->updatePrintForm($lastInsert, 'AGRI', $value, 'YRRP');
				$db->commit();

				echo '<script type="text/javascript">setTimeout("window.close();", 2000);</script>';
			} catch (PDOException $e) {
				$db->rollback();
				echo "ERROR: " . $e->getMessage();
			}
		}
	}
} else if (isset($_POST['evaluateBtn'])) {
	if (!empty($_POST['chkPrint'])) {
		foreach ($_POST['chkPrint'] as $key => $value) {
			$result = $db->prepare("UPDATE `$table` SET status = 'evaluated' WHERE idsnumber = ?");
			$result->execute([$value]);
		}
		header('location: ../programs/agriagra');
	}
} else if (isset($_POST['cancelBtn'])) {
	if (!empty($_POST['chkPrint'])) {
		foreach ($_POST['chkPrint'] as $key => $value) {
			$result = $db->prepare('UPDATE $table SET status = "cancelled" WHERE idsnumber = ?');
			$result->execute([$value]);
		}
		header('location:' . $_SERVER[REQUEST_URI]);
	}
} else if (isset($_POST['activeBtn'])) {
	if (!empty($_POST['chkPrint'])) {
		foreach ($_POST['chkPrint'] as $key => $value) {
			$result = $db->prepare('UPDATE $table SET status = "active" WHERE idsnumber = ?');
			$result->execute([$value]);
		}
		header('location:' . $_SERVER[REQUEST_URI]);
	}
} else if (isset($_POST['printBtn'])) {


	if (!empty($_POST['chkPrint'])) {

		$row = $_POST['chkPrint'];
		foreach ($row as $key => $value) {



			$used_program = "YRRP";
			$result = $db->prepare("SELECT * FROM `$table` WHERE idsnumber = ?");
			$result->execute([$value]);
			foreach ($result as $row) {
				$assured = strtoupper($row['assured']);
				$address = strtoupper($row['town']) . ', ' . strtoupper($row['province']);
				$animal = strtoupper($row['animal']);
				$lsp = strtoupper($row['lsp']) . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'];
				$premium_loading = strtoupper($row['loading']);
				$d_rcv = date("F j, Y", strtotime($row['date_r']));
				$groupname = strtoupper($row['groupName']);
				$lender = "";
				$dfrom = date('F j, Y', strtotime($row['Dfrom']));
				$dto = date('F j, Y', strtotime($row['Dto']));
				$sum_insured = number_format($row['amount_cover'], 2);
				$rate = number_format($row['rate'], 2);
				$premium = number_format($row['premium'], 2);
				$heads = number_format($row['heads']);
				$farmers = number_format($row['farmers']);
				$lslb = $row['lslb'];
				$iu = $row['iu'];
				$prepared = $row['prepared'];
				$f_id = $row['f_id'];
				$tag = $row['tag'];
				$status = $row['status'];
				$or = 'Y99999-' . substr($_SESSION['insurance'], -2) . '-' . sprintf("%04d", $row['idsnumber']) . '-L';
			}

			$rcount = $result->rowCount();
			if ($rcount > 0) {
				if ($lslb == '0') {
					$lslb = "";
				} else {
					$lslb = $lslb;
				}
				switch ($status) {
					case 'active':
						# active
						$displaystat = "Note: Subject to possible changes.";
						break;

					case 'cancelled':
						# cancelled
						$displaystat = "Note: Cancelled Application.";
						break;

					default:
						# Evaluated
						$displaystat = "Note: Evaluated";
						break;
				}

				$displaydata = '

				<table class="table table-condensed table-bordered font-md">
					<tr>
						<td colspan="2"><h6>PHILIPPINE CROP INSURANCE CORPORATION - REGIONAL OFFICE VIII</h6></td>	
						<td colspan="2"><h5 class="text-center">LIVESTOCK PROCESSING SLIP <strong>(' . $used_program . ')</strong></h5></td>
					</tr>
					<tr>
						<th scope="row"><label>NAME</label></th>
							<td><strong>' . $assured . '</strong> <small>(ID: ' . $f_id . ')</small></td>
						<td><small>' . $displaystat . '</small></td>
						<td></td>
					</tr>
					<tr>
						<th scope="row"><label>ADDRESS</label></th>
							<td>' . $address . '</td>
						<th scope="row"><label>LOGBOOK</label></th>
							<td style="font-size: 14pt;"><strong>' . $lslb . '</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>KIND OF ANIMAL + PURPOSE</label></th>
							<td><strong>' . $animal . '</strong></td>
						<th scope="row"><label>POLICY NO.</label></th>
							<td style="font-size: 14pt;"><strong>' . $lsp . '</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>GROUP</label></th>
							<td><strong>' . $groupname . '</strong></td>	
						<th scope="row"><label>DATE RECEIVED</label></th>
							<td>' . $d_rcv . '</td>
					</tr>
					<tr>
						<th scope="row"><label>PREMIUM LOADING</label></th>
							<td>' . $premium_loading . '</td>
						<th scope="row"><label>COLC/CTC/TAG</label></th>	
							<td>' . $tag . '</td>
					</tr>
					<tr>
						<th scope="row"><label>EFFECTIVITY DATE</label></th>
							<td>' . $dfrom . '</td>
						<th scope="row"><label>EXPIRY DATE</label></th>
							<td>' . $dto . '</td>	
					</tr>	
					<tr>
						<th scope="row"><label>OR NO.</label></th>
							<td><strong>' . $or . '</strong></td>
						<th scope="row"><label>BASIC PREMIUM</label></th>
							<td><strong>' . $premium . '</strong></td>
					</tr>
					<tr>
						<th scope="row"><label>TOTAL SUM INSURED</label></th>
							<td>' . $sum_insured . '</td>
						<th scope="row"><label>PREMIUM RATE</label></th>
							<td>' . $rate . ' %</td>
					</tr>
					<tr>
						<th scope="row"><label>FARMERS</label></th>
							<td>' . $farmers . '</td>
						<th scope="row"><label>HEADS</label></th>
							<td>' . $heads . '</td>
					</tr>
				</table>';
			}

			?>
<!DOCTYPE html>
<html>

<head>
    <title>PROCESSING SLIP</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="shortcut icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="../resources/bootswatch-3/solar/bootstrap.css">
    <link rel="stylesheet" href="../resources/css/local.css">

</head>

<body>


    <?php echo $displaydata ?>
    <div class="container">
        <div class="row">
            <p class="col-xs-4"><strong>BENITA M. ALBERTO</strong> <br><small>OIC-CHIEF, Marketing and Sales
                    Division</small></p>
            <p class="col-xs-4"><strong><?php echo $prepared ?></strong> <br><small>Prepared By</small></p>
            <p class="col-xs-4"><strong><?php echo $iu ?></strong> <br><small>IU/Solicitor/AT</small></p>
        </div>
    </div>

    <p class="text-center">
        __________________________________________________________________________________________________________________________________________________________________________________________
    </p>





</body>

</html>

<?php
					}
				} else {
					echo 'Use checbox to select policy for processing slip. This tab will close after 3 seconds..';
					echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';
				}
			}



			?>