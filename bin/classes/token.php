<?php
namespace Classes;

class token 
{
	private $db;
	
	public function __construct()
	{
		
		require 'connection/conn.php';
		$this->db = $db;
		

	}

	public function generateToken($user)
	{
		$db = $this->db;
		$token = password_hash($user, PASSWORD_BCRYPT, array("cost" => 10));
		return $token;
	}

	public function insertToken($db, $token,$id, $i_y)
	{
		$db = $this->db;
		$query = $db->prepare("UPDATE users SET token = ?, y_chosen = ? WHERE usrid = ?");
		$query->execute([$token, $i_y, $id]);

		$result = $query->rowCount();


		return $result;
	}

	public function destroyToken($db,$id)
	{
		$db = $this->db;
		$query = $db->prepare("UPDATE users SET token = ' ' WHERE usrid = ?");
		$query->execute([$id]);

	}

	public function _mode($type, $id) {
		$db = $this->db;
		$query = $db->prepare("UPDATE users SET mode = ? WHERE usrid = ?");
		$query->execute([$type, $id]);
	}
}
?>