<?php
require "connection/conn.php";

date_default_timezone_set('Asia/Manila');

if (isset($_POST['send_csv'])) {

    $rsbsaLb = $_FILES['csv1']['tmp_name'];
    $agriLb = $_FILES['csv2']['tmp_name'];
    $yrrpLb = $_FILES['csv3']['tmp_name'];
    $saadLb = $_FILES['csv4']['tmp_name'];
    $apcpLb = $_FILES['csv5']['tmp_name'];
    $punlaLb = $_FILES['csv6']['tmp_name'];

    $rsCount = 0;
    $aaCount = 0;
    $yrrpCount = 0;
    $saadCount = 0;
    $apcpCount = 0;
    $punlaCount = 0;
    try {
        $db->beginTransaction();


        if ($_FILES['csv1']['size'] > 0) {
            $fileRsbsa = fopen($rsbsaLb, "r");
            while (($getdata1 = fgetcsv($fileRsbsa, 10000, ",")) !== false) {
                $result = $db->prepare("UPDATE rsbsa2019 SET lslb = ? WHERE idsnumber = ? AND (lslb is NULL OR lslb = 0)");
                $result->execute([$getdata1[0], $getdata1[1]]);
                $rsCount = $result->rowCount();
            }
        } else {
            echo "rsbsa is empty" . "<br>";
        }

        if ($_FILES['csv2']['size'] > 0) {
            $fileAgri = fopen($agriLb, "r");
            while (($getdata2 = fgetcsv($fileAgri, 10000, ",")) !== false) {
                $result = $db->prepare("UPDATE agriagra2019 SET lslb = ? WHERE idsnumber = ? AND (lslb is NULL OR lslb = 0)");
                $result->execute([$getdata2[0], $getdata2[1]]);
                $aaCount = $result->rowCount();
            }
        } else {
            echo "Agriagra is empty" . "<br>";
        }


        if ($_FILES['csv3']['size'] > 0) {
            $fileYrrp = fopen($yrrpLb, "r");
            while (($getdata3 = fgetcsv($fileYrrp, 10000, ",")) !== false) {
                $result = $db->prepare("UPDATE yrrp2019 SET lslb = ? WHERE idsnumber = ? AND (lslb is NULL OR lslb = 0) ");
                $result->execute([$getdata3[0], $getdata3[1]]);
                $yrrpCount = $result->rowCount();
            }
        } else {
            echo "YRRP is empty" . "<br>";
        }

        if ($_FILES['csv4']['size'] > 0) {
            $fileSaad = fopen($saadLb, "r");
            while (($getdata4 = fgetcsv($fileSaad, 10000, ",")) !== false) {
                $result = $db->prepare("UPDATE saad2019 SET lslb = ? WHERE idsnumber = ? AND (lslb is NULL OR lslb = 0) ");
                $result->execute([$getdata4[0], $getdata4[1]]);
                $saadCount = $result->rowCount();
            }
        } else {
            echo "SAAD is empty" . "<br>";
        }

        if ($_FILES['csv5']['size'] > 0) {
            $fileApcp = fopen($apcpLb, "r");
            while (($getdata4 = fgetcsv($fileApcp, 10000, ",")) !== false) {
                $result = $db->prepare("UPDATE apcp2019 SET lslb = ? WHERE idsnumber = ? AND (lslb is NULL OR lslb = 0) ");
                $result->execute([$getdata4[0], $getdata4[1]]);
                $apcpCount = $result->rowCount();
            }
        } else {
            echo "APCP-LBP is empty" . "<br>";
        }

        if ($_FILES['csv6']['size'] > 0) {
            $filePunla = fopen($punlaLb, "r");
            while (($getdata4 = fgetcsv($filePunla, 10000, ",")) !== false) {
                $result = $db->prepare("UPDATE punla2019 SET lslb = ? WHERE idsnumber = ? AND (lslb is NULL OR lslb = 0) ");
                $result->execute([$getdata4[0], $getdata4[1]]);
                $punlaCount = $result->rowCount();
            }
        } else {
            echo "ACPC-PUNLA is empty" . "<br>";
        }
        $db->commit();
    } catch (Exception $e) {
        echo $e->getMessage();
    }



    echo 'rsbsa: ' . $rsCount . '<br>';
    echo 'agriagra: ' . $aaCount . '<br>';
    echo 'yrrp: ' . $yrrpCount . '<br>';
    echo 'SAAD: ' . $saadCount . '<br>';
    echo 'APCP-LBP: ' . $apcpCount . '<br>';
    echo 'ACPC-Punla: ' . $punlaCount . '<br>';

    #var_dump($agriLb);
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>CSV</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>
    <form method="post" action="" enctype="multipart/form-data">
        <label for='csv1'>RSBSA</label> <br><input type="file" name="csv1"><br><br>
        <label for='csv2'>AGRIAGRA</label> <br><input type="file" name="csv2"><br><br>
        <label for='csv3'>YRRP</label> <br><input type="file" name="csv3"><br><br>
        <label for='csv4'>SAAD</label> <br><input type="file" name="csv4"><br><br>
        <label for='csv5'>APCP-LBP</label> <br><input type="file" name="csv5"><br><br>
        <label for='csv6'>PUNLA</label> <br><input type="file" name="csv6"><br><br>
        <input type="submit" name="send_csv">
    </form>
</body>

</html>