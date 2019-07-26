<?php

session_start();
include("connection/conn.php");
require 'myload.php';

use Classes\programtables;

if(isset($_POST['submit'])){

$rec = htmlentities($_POST['recorded']);
echo $rec;
$obj = new programtables();
$table = $obj->rsbsa();

$result = $db->prepare("DELETE FROM $table WHERE idsnumber = ?");
$result->execute([$rec]);

$result = $db->prepare("ALTER TABLE $table AUTO_INCREMENT=1");
$result->execute();


header("location:".$_SERVER[REQUEST_URI]);
}
?>


<form action="" method="POST">
<p>Delete record?</p>
<input type="hidden" value="<?PHP echo htmlentities($_POST['rowid']); ?>" name="recorded">
<button type="submit" name="delete_records" class="btn btn-success">Submit</button>

</form>


