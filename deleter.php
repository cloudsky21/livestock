<?php



if(isset($_POST['submit'])){

$rec = htmlentities($_POST['recorded']);
echo $rec;

$result = $db->prepare("DELETE FROM controlr WHERE idsnumber = ?");
$result->execute([$rec]);

$result = $db->prepare("ALTER TABLE controlr AUTO_INCREMENT=1");
$result->execute();

header("location: ".$_SERVER[REQUEST_URI]);
}
?>


<form action="deleter.php" method="POST">
<p>Delete record?</p>
<input type="hidden" value="<?PHP echo htmlentities($_POST['rowid']); ?>" name="recorded">
<button type="submit" name="submit" class="btn btn-success">Submit</button>

</form>


