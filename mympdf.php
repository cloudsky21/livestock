<?php
function checklist($rcv,$db) {
include('add-ons/mpdf/mpdf.php');

date_default_timezone_set('Asia/Manila');

$mpdf = new mPDF();
$html = '<!DOCTYPE html>';
$html .= '<html>';
$html .= '<head>';
$html .= '<link rel="stylesheet" href="resources/css/media.css" />';
$html .= '</head>';
$html .= '<body>';
$html .= '<table class="table table-condensed table-bordered">';
$html .='<thead>';
$html .='<tr>';
$html .='<th>#</th>';
$html .='<th>Policy Number</th>';
$html .='<th>Group</th>';
$html .='<th>Premium</th>';
$html .='</tr>';
$html .='</thead>';



$rcvd = $rcv;
$i = 1;
$result = $db->prepare("SELECT * FROM control2017 WHERE lslb = 0 and date_r = ? ORDER BY idsnumber DESC");
$result->execute([$rcvd]);
foreach ($result as $row){
	$html .= '<tr>';
	$html .= '<td>'.$i++.'</td>';
	$html .= '<td><input type="checkbox"> '.$row['lsp'].''.sprintf("%04d", $row['idsnumber']).'&nbsp;'.$row['idsprogram'].'</td>';	
	$html .= '<td>'.$row['groupName'].'</td>';	
	$html .= '<td>'.number_format($row['premium'],2).'</td>';	
	$html .= '</tr>';

}
$html .='</table>';
$html .='</body>';
$html .='</html>';


$mpdf->WriteHTML ($html);

$mpdf->Output();
exit;

}
?>