<?php

class DB{
	private $dbHost     = "localhost";
	private $dbUsername = "btrulead_masterlogin";
	private $dbPassword = "laX+{FN}VV.]";
	private $dbName     = "btrulead_leads";
	private $imgTbl     = 'email_drips_custom';
	
	function __construct(){
		if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
	}
	
	function getRows(){
		$query = $this->db->query("SELECT * FROM ".$this->imgTbl." ORDER BY sort ASC");
		if($query->num_rows > 0){
			while($row = $query->fetch_assoc()){
				$result[] = $row;
			}
		}else{
			$result = FALSE;
		}
		return $result;
	}
	
	function updateOrder($id_array){
		$count = 1;
		foreach ($id_array as $id){
			$update = $this->db->query("UPDATE ".$this->imgTbl." SET sort = $count WHERE id = $id");
			$count ++;	
		}
		return TRUE;
	}
}
?>