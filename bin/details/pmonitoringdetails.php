<?PHP
session_start();
include("../../connection/conn.php");
require '../../myload.php';

use Classes\monitoring;

$table = "processmonitoring";
$obj = new monitoring($table, $db);


date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['token'])) {
    header("location: ../logmeOut");
}


$ids = htmlentities($_POST['rowid']);


$result = $db->prepare("SELECT * FROM $table WHERE processid = ?");
$result->execute([$ids]);

foreach ($result as $row) {

    $dateRecieved = date("M j, Y h:i A", strtotime($row['date_received']));
    $dateAdded = date("M j, Y h:i A", strtotime($row['date_added']));
    $pID = sprintf("%04d", $row['processid']) .'-'. $row['year'];
    $IU = $row['sender'];
    $appsCount = $row['total'];
    $cancelledCount = $row['cancelled'];
    #Preprocess
    #$pProcessStart = date("M j, Y h:i A", strtotime($row['pProcessStart']));
    $pProcessStart = (!empty((int) $row['pProcessStart']) ? date("M j, Y h:i A", strtotime($row['pProcessStart'])) : "EMPTY");
    $pProcessEnd = (!empty((int) $row['pProcessEnd']) ? date("M j, Y h:i A", strtotime($row['pProcessEnd'])) : "EMPTY");
    $pProcessCount = $row['pProcessCount'];
    $pProcessUser = strtoupper($row['pProcessUser']);
    #FMS
    $seriesFms = (!empty((int) $row['fmsSeries']) ? date("M j, Y h:i A", strtotime($row['fmsSeries'])) : "EMPTY");
    $fmsStart = (!empty((int) $row['fmsStart']) ? date("M j, Y h:i A", strtotime($row['fmsStart'])) : "EMPTY");
    $fmsEnd = (!empty((int) $row['fmsEnd']) ? date("M j, Y h:i A", strtotime($row['fmsEnd'])) : "EMPTY");
    $fmsCount = $row['fmsCount'];
    #Logbook
    $lbStart = (!empty((int) $row['lbStart']) ? date("M j, Y h:i A", strtotime($row['lbStart'])) : "EMPTY");
    $lbEnd = (!empty((int) $row['lbEnd']) ? date("M j, Y h:i A", strtotime($row['lbEnd'])) : "EMPTY");
    $lbCount = $row['lbCount'];
    $lbUser = strtoupper($row['lbUser']);
    $lbSeries = $row['lbSeries'];
    #Underwrite
    $uStart = (!empty((int) $row['uStart']) ? date("M j, Y h:i A", strtotime($row['uStart'])) : "EMPTY");
    $uEnd = (!empty((int) $row['uStart']) ? date("M j, Y h:i A", strtotime($row['uEnd'])) : "EMPTY");
    $uUser = strtoupper($row['uUser']);
    #Evaluate
    $eStart = (!empty((int) $row['cEvalStart']) ? date("M j, Y h:i A", strtotime($row['cEvalStart'])) : "EMPTY");
    $eEnd = (!empty((int) $row['cEvalStart']) ? date("M j, Y h:i A", strtotime($row['cEvalEnd'])) : "EMPTY");
    $eUser = strtoupper($row['cEvalUser']);
}



?>
<table class="table table-condensed table-sm table-hover">
    <tbody>
        <tr>
            <th scope="row">ProcessID</th>
            <td>
                <strong class="text-warning">
                    <?PHP echo $pID; ?>
                </strong>
            </td>
        </tr>
        <tr>
            <th scope="row">Received</th>
            <td>
                <?PHP echo $dateRecieved; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">IU/PEO/Group</th>
            <td>
                <?PHP echo $IU; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Total Apps</th>
            <td>
                <?PHP echo $appsCount; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Cancelled</th>
            <td>
                <?PHP echo $cancelledCount; ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-condensed table-sm table-hover">
    <tbody>
        <tr>
            <th colspan="3" class="text-center">PRE-PROCESS</th>
        </tr>
        <tr>
            <th scope="row">User</th>
            <td>
                <?PHP echo $pProcessUser; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Start</th>
            <td>
                <?PHP echo $pProcessStart; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Finish</th>
            <td>
                <?PHP echo $pProcessEnd; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Count</th>
            <td>
                <?PHP echo $pProcessCount; ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-condensed table-sm table-hover">
    <tbody>
        <tr>
            <th colspan="3" class="text-center">FMS</th>
        </tr>
        <tr>
            <th scope="row">Series</th>
            <td>
                <?PHP echo $seriesFms; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Start</th>
            <td>
                <?PHP echo $fmsStart; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Finish</th>
            <td>
                <?PHP echo $fmsEnd; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Count</th>
            <td>
                <?PHP echo $fmsCount; ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-condensed table-sm table-hover">
    <tbody>
        <tr>
            <th colspan="3" class="text-center">LOGBOOK</th>
        </tr>
        <tr>
            <th scope="row">Start</th>
            <td>
                <?PHP echo $lbStart; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Finish</th>
            <td>
                <?PHP echo $lbEnd; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Count</th>
            <td>
                <?PHP echo $lbCount; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Series</th>
            <td>
                <?PHP echo $lbSeries; ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-condensed table-sm table-hover">
    <tbody>
        <tr>
            <th colspan="3" class="text-center">Underwrite</th>
        </tr>
        <tr>
            <th scope="row">Start</th>
            <td>
                <?PHP echo $uStart; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Finish</th>
            <td>
                <?PHP echo $uEnd; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Encoder</th>
            <td>
                <?PHP echo $uUser; ?>
            </td>
        </tr>
    </tbody>
</table>

<table class="table table-condensed table-sm table-hover">
    <tbody>
        <tr>
            <th colspan="3" class="text-center">Evaluate</th>
        </tr>
        <tr>
            <th scope="row">Start</th>
            <td>
                <?PHP echo $eStart; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Finish</th>
            <td>
                <?PHP echo $eEnd; ?>
            </td>
        </tr>
        <tr>
            <th scope="row">Encoder</th>
            <td>
                <?PHP echo $eUser; ?>
            </td>
        </tr>
    </tbody>
</table>