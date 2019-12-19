<?php
class Database{
	private $username = "root";
	private $password = "";
	private $host = "localhost";
	private $db_name = "botnet";
	private $charset = "utf8mb4";
	public  $salt = "Yi89TTJ3bSxIcGxyVURhIzltXTdJcGtnJVdTdjNpU3BNSF9vU1BXe1N5JkoxP00pSC50MkY2TVdCdDZuNg==";
	public  $admin_email = "admin@localhost";
	public function Connect(){

    try{
		$dsn = "mysql:host=".$this->host.";dbname=".$this->db_name.";charset=".$this->charset;
		$pdo = new PDO($dsn, $this->username, $this->password);	
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
	}
	  catch(PDOException $err){
      	die('Unable to connect: '.$err->getMessage());
	}
	return $pdo;
	}

	public function dataExist(){
		$pdo = $this->Connect();
		$sql = $pdo->prepare("SHOW TABLES LIKE 'clients'");
		$sql->execute();
		if ($sql->rowCount()) {
			
		} else {

		}
	}

	public function redirect($url){
		ob_start();
		header('Location: ' . $url);
		exit;
		ob_flush();
	}

}
?>
