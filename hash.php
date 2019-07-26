<?php
require("connection/conn.php");
date_default_timezone_set('Asia/Manila');
/**
 * In this case, we want to increase the default cost for BCRYPT to 12.
 * Note that we also switched to BCRYPT, which will always be 60 characters.
 */

if(isset($_POST['submit'])){
	

		//$hash = password_hash($_POST['user1'], PASSWORD_BCRYPT);
		//echo $hash;

	$result = $db->prepare("SELECT * FROM users WHERE usrid = ? ");
	$result->execute([$_POST['user1']]);

	foreach ($result as $row) {

		if (password_verify($_POST['pass1'], $row['pswd'])) {
			echo 'Password is valid!';

		} else {
			echo 'Invalid password.';
		}
	}
}

if(isset($_POST['register'])){

	$user = htmlentities($_POST['userid']);
	$hash = password_hash($_POST['password'], PASSWORD_BCRYPT, array("cost" => 10));

	insert($db,$user, $hash);




}
?>

<form method="post" action="" id="form1" autocomplete="false">
	<input type="text" name="user1">
	<input type="password" name="pass1">
	<button type="submit" name="submit">submit</button>
</form>


<form method="post" action="" id="form2" autocomplete="false">
	<input type="text" name="userid">
	<input type="password" name="password">
	<button type="submit" name="register">submit</button>
</form>


<?php
function insert($db, $id, $password){

	$result=$db->prepare("INSERT INTO users(usrid,pswd,surname,firstname,middlename,actype,office) VALUES(?,?,?,?,?,?,?)");
	$result->execute([$id, $password,"Lorem","Ipsum","dummy","Guest","Regional Office"]);
	return true;

}

?>


