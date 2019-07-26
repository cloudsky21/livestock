<?php

function checklist($rcv, $db, $table, $ORcode, $program)
{
    include 'add-ons/mpdf/mpdf.php';

    date_default_timezone_set('Asia/Manila');

    $mpdf = new mPDF();
    $html = '<!DOCTYPE html>';
    $html .= '<html>';
    $html .= '<head>';
    $html .= '<link rel="stylesheet" href="resources/css/media.css" />';
    $html .= '<link rel="shortcut icon" href="images/favicon.ico">';
    $html .= '</head>';
    $html .= '<body style="font-size: 9pt; font-family: calibri">';
    $html .= '<h2 class="text-center">' . $program . '</h2>';
    $html .= '<table class="table table-condensed table-striped table-sm">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>#</th>';
    $html .= '<th>OR Number</th>';
    $html .= '<th>Group</th>';
    $html .= '<th>LIP No.</th>';
    $html .= '<th>Premium</th>';
    $html .= '<th>Date</th>';
    $html .= '</tr>';
    $html .= '</thead>';

    $rcvd = $rcv;
    $i = 1;
    $result = $db->prepare("SELECT * FROM $table WHERE (lslb is NULL or Lslb = '0') and (date_r = ? and status = 'active') ORDER BY idsnumber DESC");
    $result->execute([$rcvd]);
    foreach ($result as $row) {
        $html .= '<tr>';
        $html .= '<td><input type="checkbox" style="font-size: 20px;"></td>';
        $html .= '<td>' . $i++ . '</td>';
        $html .= '<td><span class="color-red">' . $ORcode . '</span>' . sprintf("%04d", $row['idsnumber']) . '-L</td>';
        $html .= '<td>' . $row['groupName'] . '</td>';
        $html .= '<td>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '&nbsp;' . $row['idsprogram'] . '</td>';
        $html .= '<td>' . $row['premium'] . '</td>';
        $html .= '<td>' . date("m-d-Y", strtotime($row['date_r'])) . '</td>';
        $html .= '</tr>';

    }
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';

    $mpdf->WriteHTML($html);

    $mpdf->Output();
    exit;

}

function checklistRange($rcv1, $rcv2, $db, $table, $ORcode, $program)
{
    include 'add-ons/mpdf/mpdf.php';

    date_default_timezone_set('Asia/Manila');

    $mpdf = new mPDF();
    $html = '<!DOCTYPE html>';
    $html .= '<html>';
    $html .= '<head>';
    $html .= '<link rel="stylesheet" href="resources/css/media.css" />';
    $html .= '<link rel="shortcut icon" href="images/favicon.ico">';
    $html .= '</head>';
    $html .= '<body style="font-size: 9pt; font-family: calibri">';
    $html .= '<h2 class="text-center">' . $program . '</h2>';
    $html .= '<table class="table table-condensed table-striped table-sm">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>#</th>';
    $html .= '<th>OR Number</th>';
    $html .= '<th>Group</th>';
    $html .= '<th>LIP No.</th>';
    $html .= '<th>Premium</th>';
    $html .= '<th>Date</th>';
    $html .= '</tr>';
    $html .= '</thead>';

    $i = 1;
    $count = 0;
    $ac = 0;
    $heads = 0;
    $result = $db->prepare("SELECT * FROM $table WHERE (lslb is NULL or Lslb = '0') and (date_r BETWEEN ? and ? and status = 'active') ORDER BY idsnumber ASC");
    $result->execute([$rcv1, $rcv2]);
    foreach ($result as $row) {
        $html .= '<tr>';
        $html .= '<td><input type="checkbox" style="font-size: 20px;"></td>';
        $html .= '<td>' . $i++ . '</td>';
        $html .= '<td><span class="color-red">' . $ORcode . '</span>' . sprintf("%04d", $row['idsnumber']) . '-L</td>';
        $html .= '<td>' . $row['groupName'] . '</td>';
        if ($row['idsprogram'] == 'AGRI-ARB' || $row['idsprogram'] == 'PPPP-ARB') {
            $html .= '<td><span class="color-blue">' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</td>';
        } else {
            $html .= '<td>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '-' . $row['idsprogram'] . '</td>';
        }
        $html .= '<td>' . $row['premium'] . '</td>';
        $html .= '<td>' . date("m-d-Y", strtotime($row['date_r'])) . '</td>';
        $html .= '</tr>';

        $count = $count + $row['premium'];
        $ac = $ac + $row['amount_cover'];
        $heads = $heads + $row['heads'];

    }
    $html .= '</table>';
    $html .= '<small>Total premium: ' . number_format($count, 2) . '</small>';
    $html .= '<br><small>Total Sum Insured: ' . number_format($ac, 2) . '</small>';
    $html .= '<br><small>Total Heads: ' . number_format($heads, 2) . '</small>';
    $html .= '</body>';
    $html .= '</html>';

    $mpdf->WriteHTML($html);

    $mpdf->Output();
    exit;

}

function checklistRegular($rcv, $db, $table, $program)
{
    include 'add-ons/mpdf/mpdf.php';

    date_default_timezone_set('Asia/Manila');

    $mpdf = new mPDF();
    $html = '<!DOCTYPE html>';
    $html .= '<html>';
    $html .= '<head>';
    $html .= '<link rel="stylesheet" href="resources/css/media.css" />';
    $html .= '<link rel="shortcut icon" href="images/favicon.ico">';
    $html .= '</head>';
    $html .= '<body style="font-size: 9pt; font-family: calibri">';
    $html .= '<h2 class="text-center">' . $program . '</h2>';
    $html .= '<table class="table table-condensed table-striped table-sm">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>#</th>';
    $html .= '<th>OR Number</th>';
    $html .= '<th>Group</th>';
    $html .= '<th>LIP No.</th>';
    $html .= '<th>Premium</th>';
    $html .= '<th>Date</th>';
    $html .= '</tr>';
    $html .= '</thead>';

    $rcvd = $rcv;
    $i = 1;
    $result = $db->prepare("SELECT * FROM $table WHERE (lslb is NULL or Lslb = '0') and (date_r = ? and status = 'active') ORDER BY idsnumber DESC");
    $result->execute([$rcvd]);
    foreach ($result as $row) {
        $docstamp = ($row['premium'] * (12.5 / 100));
        $tax = ($row['premium'] * (5 / 100));
        $gross = $row['premium'] + $docstamp + $tax;

        $html .= '<tr>';
        $html .= '<td><input type="checkbox" style="font-size: 20px;"></td>';
        $html .= '<td>' . $i++ . '</td>';
        $html .= '<td><span class="color-red">' . $row['receiptNumber'] . '</span></td>';
        $html .= '<td>' . $row['groupName'] . '</td>';
        $html .= '<td>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '</td>';
        $html .= '<td>' . number_format($gross, 2) . '</td>';
        $html .= '<td>' . date("m-d-Y", strtotime($row['date_r'])) . '</td>';
        $html .= '</tr>';

    }
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';

    $mpdf->WriteHTML($html);

    $mpdf->Output();
    exit;

}

function checklistRegularRange($rcv1, $rcv2, $db, $table, $program)
{
    include 'add-ons/mpdf/mpdf.php';

    date_default_timezone_set('Asia/Manila');

    $mpdf = new mPDF();
    $html = '<!DOCTYPE html>';
    $html .= '<html>';
    $html .= '<head>';
    $html .= '<link rel="stylesheet" href="resources/css/media.css" />';
    $html .= '<link rel="shortcut icon" href="images/favicon.ico">';
    $html .= '</head>';
    $html .= '<body style="font-size: 9pt; font-family: calibri">';
    $html .= '<h2 class="text-center">' . $program . '</h2>';
    $html .= '<table class="table table-condensed table-striped table-sm">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th></th>';
    $html .= '<th>#</th>';
    $html .= '<th>OR Number</th>';
    $html .= '<th>Group</th>';
    $html .= '<th>LIP No.</th>';
    $html .= '<th>Premium</th>';
    $html .= '<th>Date</th>';
    $html .= '</tr>';
    $html .= '</thead>';

    $i = 1;
    $result = $db->prepare("SELECT * FROM $table WHERE (lslb is NULL or Lslb = '0') and (date_r BETWEEN ? and ? and status = 'active') ORDER BY idsnumber ASC");
    $result->execute([$rcv1, $rcv2]);
    foreach ($result as $row) {

        $docstamp = ($row['premium'] * (12.5 / 100));
        $tax = ($row['premium'] * (5 / 100));
        $gross = $row['premium'] + $docstamp + $tax;

        $html .= '<tr>';
        $html .= '<td><input type="checkbox" style="font-size: 20px;"></td>';
        $html .= '<td>' . $i++ . '</td>';
        $html .= '<td><span class="color-red">' . $row['receiptNumber'] . '</span></td>';
        $html .= '<td>' . $row['groupName'] . '</td>';
        $html .= '<td>' . $row['lsp'] . '' . sprintf("%04d", $row['idsnumber']) . '</td>';
        $html .= '<td>' . number_format($gross, 2) . '</td>';
        $html .= '<td>' . date("m-d-Y", strtotime($row['date_r'])) . '</td>';
        $html .= '</tr>';

    }
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';

    $mpdf->WriteHTML($html);

    $mpdf->Output();
    exit;

}