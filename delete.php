<?PHP
include("connection/conn.php");
session_start();

if(isset($_POST['submit'])){

$rec = htmlentities($_POST['recorded']);
echo $rec;
$table = "control".$_SESSION['insurance'];
$result = $db->prepare("DELETE FROM $table WHERE idsnumber = ?");
$result->execute([$rec]);

$result = $db->prepare("ALTER TABLE $table AUTO_INCREMENT=1");
$result->execute();



header("location: rsbsa.php");
}
?>


<form action="delete.php" method="POST">
<p>Delete record?</p>
<input type="hidden" value="<?PHP echo htmlentities($_POST['rowid']); ?>" name="recorded">
<button type="submit" name="submit" class="btn btn-success">Submit</button>

</form>


