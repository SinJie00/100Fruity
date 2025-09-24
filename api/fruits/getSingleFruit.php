<?php
header('Access-Control-Allow-Origin: *');
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

$id = $_GET['id'];
$sql = "SELECT * FROM fruit WHERE id= $id";

try{
    $db = new db();
    $db = $db->connect();
    $stmt = $db->query($sql);
    $user = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;

    $output = '<table id="customerDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Fruit ID</th>
						<th>Name</th>
						<th>Quantity</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>';
    echo json_encode($user);

}catch (PDOException $e){
    $data = array(
        "status"=>"fail"
    );
    echo json_encode($data);
}


?>