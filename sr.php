<?PHP
include("connection/conn.php");

$ids = htmlentities($_GET['img']); // 380
$result = $db->prepare("SELECT image1 FROM control WHERE idsnumber = ?");
$result->execute([$ids]);

$row = $result->fetch(PDO::FETCH_ASSOC);


$name=$ids;

$select_image="select * from control where idsnumber='$name'";

$var = $db->query($select_image);
$result= $var->fetch(PDO::FETCH_ASSOC);




echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['image1'] ).'" />';



?>


