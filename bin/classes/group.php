<?php
namespace Classes;

class group {
	
	
	public function param ($param)
	{
		include('../connection/conn.php');

		$exist = $this->check($param);

		switch (TRUE) {
			case ($exist == '0'):
				$result =$db->prepare("INSERT INTO groupName (name) VALUES(?)");
				$result->execute([$param]);
				break;
			
			default:				
				break;
		}
		
		return $exist;
	}

	public function check($name)
	{
		include('../connection/conn.php');

		$result = $db->prepare('SELECT name FROM groupName WHERE name = ? LIMIT 1');
		$result->execute([$name]);

		$count = $result->rowcount();
		return $count;
	}
}



?>