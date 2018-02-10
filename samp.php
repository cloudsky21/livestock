<?php
include 'connection/conn.php';

$fields = array ("groupname","proponent","program");
$values = array ("DA/LGU BILIRAN","ROEL G. NAPALIT","RSBSA");
$table = "ids";



$placeholders = substr(str_repeat('?,', sizeOf($fields)), 0, -1);

$stmt = $db->prepare(
    sprintf(
        "INSERT INTO %s (%s) VALUES (%s)", 
        $table, 
        implode(',', $fields), 
        $placeholderss
    )
);
$stmt->execute($values);

if($stmt->rowcount()>0){
	echo "inserted";
}
else
{
	echo "problem";
}


?>