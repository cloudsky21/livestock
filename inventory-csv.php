<?php
require "connection/conn.php";
require 'myload.php';

date_default_timezone_set('Asia/Manila');

use Classes\farmers;

if (isset($_POST['send_csv'])) {
    $filename = $_FILES['csv']['tmp_name'];
    $unwanted = array("?" => "Ñ");


    if ($_FILES['csv']['size'] > 0) {
        $file = fopen($filename, "r");

        while (($getdata = fgetcsv($file, 10000, ",")) !== false) {
            
            $db->begintransaction();
            try {
                
                $check_farmer = new farmers();
                $check_farmer->param($getdata[20], $getdata[8], $getdata[18], $getdata[6], $getdata[7]);

                $farmer = strtr(mb_strtoupper($getdata[8]), $unwanted);
                $processedDate = date("Y-m-d", strtotime($getdata[1]));
                $expiry = date("Y-m-d", strtotime($getdata[16]));
                $starting = date("Y-m-d", strtotime($getdata[15]));



                $sql = "INSERT INTO rsbsa2018 (
                    Year, 
                    date_r, 
                    program, 
                    groupName,
                    ids1, 
                    lsp, 
                    province, 
                    town, 
                    assured,
                    farmers, 
                    heads, 
                    animal, 
                    premium, 
                    amount_cover, 
                    rate, 
                    Dfrom, 
                    Dto, 
                    status, 
                    office_assignment,                    
                    prepared,                    
                    f_id) VALUES (
                '" . $getdata[0] . "', #year
                '" . $processedDate. "', #date_r
                '" . $getdata[2] . "', # program
                '" . $getdata[3] . "', # groupName
                '" . $getdata[4] . "', # ids1
                '" . $getdata[5] . "', # lsp
                '" . $getdata[6] . "', # province
                '" . $getdata[7] . "', # town
                '" . $farmer. "',   # assured
                '" . $getdata[9] . "', # farmers
                '" . $getdata[10] . "', # heads,
                '" . $getdata[11] . "', #  animal
                '" . $getdata[12] . "', # premium 
                '" . $getdata[13] . "', # amount_cover
                '" . $getdata[14] . "', # rate
                '" . $starting. "', #  Dfrom,
                '" . $expiry. "', # Dto 
                '" . $getdata[17] . "', # status 
                '" . $getdata[18] . "', # office_assignment
                '" . $getdata[19] . "', #  prepared
                '" . $getdata[20] . "')"; # f_id

                $result = $db->prepare($sql);
                //echo $sql;
                $result->execute();

                if (!$result->rowcount() > 0) {
                    echo "<script type=\"text/javascript\">
                        Console.log(\"Invalid File:Please Upload CSV File.\");
                        window.location = \"csv.php\"
                         </script>";
                } else {
                    echo "<script type=\"text/javascript\">
                    alert(\"CSV File has been successfully Imported. '.$i.'\");
                    window.location = \"csv.php\"
                </script>";
                }


                $db->commit();
            } catch (Exception $e) {
                echo $e;
                $db->rollback();

            }

        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CSV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">   
    
</head>
<body>
    <form method="post" action="" enctype="multipart/form-data">
    <input type="file" name="csv">
    <input type="submit" name="send_csv">
    </form>
</body>
</html>

