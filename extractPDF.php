<?php
session_start();
include('add-ons/mpdf/mpdf.php');
require_once("connection/conn.php");
require 'myload.php';

date_default_timezone_set('Asia/Manila');

use Classes\programtables;

$obj = new programtables();

$table = $obj->tableList();

$mpdf = new mPDF('c','A4-L');
$mpdf->setFooter('{PAGENO}');

if(isset($_POST['submit'])) {
	
	$office = htmlentities($_POST['office']);
	$from = date("Y-m-d",strtotime($_POST['date_from']));
	$to = date("Y-m-d",strtotime($_POST['date_to']));

	$html = '<!DOCTYPE html>';
	$html .= '<html>';
	$html .= '<head>';
	$html .= '<link rel="stylesheet" href="resources/css/media.css">';		
	$html .= '</head>';
	$html .= '<body style="font-size: 9pt; font-family: calibri">';	
	$html .= '<h3>'.strtoupper($office).'</h3>';	
	$html .= '<table class="table table-condensed table-sm table-bordered" autosize="2.4">';	
	$html .='<thead>';
	$html .='<tr>';
	$html .='<th>#</th>';
	$html .='<th>Assured</th>';	
	$html .='<th>LIP</th>';
	$html .='<th>Program</th>';
	$html .='<th>Start<br>of Cover</th>';
	$html .='<th>Expiry</th>';
	$html .='<th>Animal+Purpose</th>';
	$html .='<th>Heads</th>';
	$html .='<th>AC</th>';
	$html .='<th>GPS</th>';	
	$html .='<th>Tag/COLC/CTC</th>';
	$html .='<th>LB</th>';
	$html .='</tr>';
	$html .='</thead>';
	$i = 1;

	foreach ($table as $value) {

		if(preg_match('/(regular)/', $value, $matches)) {
			$table = $obj->regular();
			$result = $db->prepare("SELECT * FROM $table WHERE ((office_assignment = ?) and (date_r BETWEEN ? and ?)) and (status != 'cancelled' or status != 'hold') ORDER BY assured ASC");
			$result->execute([$office, $from, $to]);
			foreach ($result as $row){

				$newForm = "";

				$html .= '<tr>';
				$html .= '<td>'.$i++.')</td>';
				$html .= '<td>
				<dl>
				<dt><b><u>'.$row['assured'].'</u></b></dt>
				<dd><strong>ID:</strong> '.$row['f_id'].'</dd>
				<dd><strong>Address:</strong> '.$row['town'].', '.$row['province'].'</dd>
				</dl>
				</td>';			
				$html .= '<td>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'</td>';
				$html .= '<td>Regular</td>';
				$html .= '<td>'.date("m-d-Y", strtotime($row['Dfrom'])).'</td>';
				$html .= '<td>'.date("m-d-Y", strtotime($row['Dto'])).'</td>';		
				$html .= '<td>'.$row['animal'].'</td>';	
				$html .= '<td>'.$row['heads'].'</td>';	
				$html .= '<td>'.number_format($row['amount_cover'],2).'</td>';	
				$html .= '<td>'.number_format($row['premium'],2).'</td>';

				$dissect = explode(',', $row['tag']);

				foreach($dissect as $new_format) {
					$newForm .= $new_format."<br>";	
				}	

				$html .= '<td>'.$newForm.'</td>';
			/*
			if(!$row['lslb'] == 0 || !empty($row['lslb'])) {
				$html .= '<td>'.$row['lslb'].'</td>';
			} else {
				$html .= '<td></td>';
			}
			*/
			$html .= (!$row['lslb'] == 0 || !empty($row['lslb'])) ? '<td>'.$row['lslb'].'</td>' : '<td></td>';			
			$html .= '</tr>';

		} /* End regular */

	} else {
		$result = $db->prepare("SELECT * FROM $value WHERE (((office_assignment = ?) and (date_r BETWEEN ? and ?)) and (status = 'active' or status = 'evaluated')) ORDER BY assured ASC");
		$result->execute([$office, $from, $to]);
		foreach ($result as $row){

			$newForm = "";

			$html .= '<tr>';
			$html .= '<td>'.$i++.')</td>';
			$html .= '<td>
			<dl>
			<dt><b><u>'.$row['assured'].'</u></b></dt>
			<dd><strong>ID:</strong> '.$row['f_id'].'</dd>
			<dd><strong>Address:</strong> '.$row['town'].', '.$row['province'].'</dd>
			</dl>
			</td>';			
			$html .= '<td>'.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'-'.$row['idsprogram'].'</td>';
			$html .= '<td>'.$row['program'].'</td>';
			$html .= '<td>'.date("m-d-Y", strtotime($row['Dfrom'])).'</td>';	
			$html .= '<td>'.date("m-d-Y", strtotime($row['Dto'])).'</td>';		
			$html .= '<td>'.$row['animal'].'</td>';	
			$html .= '<td>'.$row['heads'].'</td>';	
			$html .= '<td>'.number_format($row['amount_cover'],2).'</td>';	
			$html .= '<td>'.number_format($row['premium'],2).'</td>';

			$dissect = explode(',', $row['tag']);
			
			foreach($dissect as $new_format) {
				$newForm .= $new_format."<br>";	
			}	
			
			$html .= '<td>'.$newForm.'</td>';
			/*
			if(!$row['lslb'] == 0 || !empty($row['lslb'])) {
				$html .= '<td>'.$row['lslb'].'</td>';
			} else {
				$html .= '<td></td>';
			}
			*/
			$html .= (!$row['lslb'] == 0 || !empty($row['lslb'])) ? '<td>'.$row['lslb'].'</td>' : '<td></td>';			
			$html .= '</tr>';

		}
	}


}
$html .='</table>';
$html .='</body>';
$html .='</html>';

	#echo $html;
$mpdf->WriteHTML($html);

$mpdf->Output($office.'-'.date("mdY"),'I');
exit;	


}
else
{
	echo 'No data to be extracted';
	echo '<script type="text/javascript">setTimeout("window.close();", 3000);</script>';

}



?>