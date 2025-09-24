<?php
/* header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

class db{
    private $host='localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'shop_inventory';

    public function connect(){
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
        $dbConnection = new PDO($mysql_connect_str, $this->user,$this->password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}

 */
	// Connect to database
	try{
		$conn = new PDO(DSN, DB_USER, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e){
		$errorMessage = $e->getMessage();
		echo $errorMessage;
		exit();
	}
?>