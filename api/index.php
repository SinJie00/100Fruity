<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

require '../vendor/autoload.php';
require 'sale/insertSale.php';
require 'sale/getAllSales.php';
require 'sale/showItemNo.php';
require 'sale/getFruit.php';
require 'sale/showCustomerID.php';
require 'sale/getCustomer.php';
require 'sale/showSaleID.php';
require 'sale/getSale.php';
require 'sale/getLastSaleID.php';
require 'sale/editSale.php';
require 'sale/deleteSale.php';
require_once 'constants.php';
require_once 'db.php';

//include 'homePage.php';
class db{
    private $host='localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = '100fruity';

    public function connect(){
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
        $dbConnection = new PDO($mysql_connect_str, $this->user,$this->password);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];
$app = new \Slim\App($config);

$app->get('/hello/{name}', function(Request $request, Response $response, array $args){
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

//login user
$app->post('/login', function(Request $request, Response $response, array $args){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `user` WHERE `email`=:email AND `password`=:password LIMIT 1";
    try{
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email, 'password' => $password]);
        if($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['login'] = "logged in";
            $_SESSION['username'] = $row['username'];
            $_SESSION['userID'] = $row['userID'];
			echo json_encode($row);
		}
    }catch (PDOException $e){
        $data = array(
            "status"=>"fail to login"
        );
        echo json_encode($data);
    } 
});

//register user
$app->post('/register', function(Request $request, Response $response, array $args){
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $sql = 'INSERT INTO user(fullName,username,email,password,status) VALUES(:fullName,:username,:email,:phone,:password,:status)';
    try{
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql);
        $stmt->execute(['fullName' => $fullname,'username' => $username,'email' => $email,'phone' => $phone,'password' => $password,'status' => 'Active']);
        $count = $stmt->rowCount();
        $data = array(
        "status" => "successfully register ",
        "rowcount" =>$count,
        "table"=> " user",
        );
        echo json_encode($data);   
    }catch (PDOException $e){
        $data = array(
            "status"=>"fail to register user"
        );
        echo json_encode($data);
    } 
});

//get profile 
$app->get('/profile', function(Request $request, Response $response, array $args){
    session_start();
    $userID = $_SESSION['userID'];
    $sql = "SELECT * FROM `user` WHERE `userID`=$userID";
    try{
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
    }catch (PDOException $e){
        $data = array(
            "status"=>"fail"
        );
        echo json_encode($data);
    } 
});

//dashboard
//get number of customers
$app->get('/customersNum', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM `customer`";

try {
    $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql);
	$stmt->execute();
    $numCustomers = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $numCustomers = $numCustomers + 1;
    }
    echo $numCustomers;
} catch (PDOException $e) {
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}
});

//get number of fruits
$app->get('/fruitsNum', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM `fruit`";

    try {
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $numFruits = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $numFruits = $numFruits + 1;
        }
        echo $numFruits;
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

//get total sale
$app->get('/totalSale', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM `sale`";

try {
    $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $purchase = 0;
    $totalPurchase = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $purchase = $row['unitPrice']*$row['quantity']*((100-$row['discount'])/100);
        $totalPurchase += $purchase;
    }
    $totalPurchase = number_format((float)$totalPurchase, 2, '.', '');
    echo $totalPurchase;
} catch (PDOException $e) {
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}
});

$app->get('/allFruits', function(Request $request, Response $response, array $args){
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM fruit";
    try{
        
	$fruitStatement = $conn->prepare($sql);
	$fruitStatement->execute();
    $output = '<table id="fruitDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Fruit ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>';
        while($row = $fruitStatement->fetch(PDO::FETCH_ASSOC)){
            $output .= '<tr>' .
                            '<td>' . $row['id'] . '</td>' .
                            '<td>' . $row['name'] . '</td>' .
                            '<td>' . $row['amount'] . '</td>' .
                            '<td>' . $row['price'] . '</td>'  .
                        '</tr>';
        }
        $output .= '</tbody>
					<tfoot>
						<tr>
                        <th>Fruit ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
						</tr>
					</tfoot>
				</table>';
	    echo $output; 
    
    }catch (PDOException $e){
        $data = array(
            "status"=>"fail"
        );
        echo json_encode($data);
    } 
});

$app->get('/fruit/{id}',  function(Request $request, Response $response, array $args){
    $id = $args['id'];
    $sql = "SELECT * FROM fruit WHERE id=$id";
    
    try{
        $db = new db();
        $db = $db->connect();
        $stmt = $db->query($sql);
        $user = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
    
        $output = '<table id="fruitDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
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

});

     $app->post('/fruit', function(Request $request, Response $response, array $args){
        if(isset($_POST['fruitDetailsName'])){
		
            $fruitName = htmlentities($_POST['fruitDetailsName']);
            $amount = htmlentities($_POST['fruitDetailsAmount']);
            $price = htmlentities($_POST['fruitDetailsPrice']);
            
            if(isset($fruitName) && isset($amount) && isset($price)) {
                
                // Check if Full name is empty or not
                if($fruitName == ''){
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Fruit Name.</div>';
                    exit();
                }else if($amount == '' || $amount =='0'){
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Amount.</div>';
                    exit();
                }else if($price == ''|| $price =='0'){
                    echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Price.</div>';
                    exit();
                }
                try {
                $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Start the insert process
                $sql = 'INSERT INTO fruit(name, amount, price) VALUES(:name, :amount, :price)';
                $stmt = $conn->prepare($sql);
                $stmt->execute(['name' => $fruitName, 'amount' => $amount, 'price' => $price]);
                echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Fruit added to database</div>';
            
            
                /* $data = array(
                    "status" => "success",
                    "rowcount" =>$count
                );
                echo json_encode($data); */
            
            } catch (PDOException $e) {
                $data = array(
                    "status" => "fail"
                );
                echo json_encode($data);
            }
            
            } else {
                // One or more fields are empty
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
                exit();
            }
        }
            
                
            
    });
$app->delete('/fruit/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
        
    try{
        $sql = "DELETE FROM fruit WHERE id= '$id'";
    
        $db = new db();
        $db = $db->connect();
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $count = $stmt->rowCount();
        $db = null;
        $data = $count;
        //echo json_encode($data);
        if($data > 0){
			 echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item deleted.</div>';
            exit();
            
        } else {
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in DB. Therefore, can\'t delete.</div>';
            exit();
        }
    
    }catch (PDOException $e){
        $data = array(
            "status"=>"fail"
        );
        echo json_encode($data);
    }
    
});

$app->PUT('/fruit/{id}', function(Request $request, Response $response, array $args){
    if($request->getParsedBody()['fruitDetailsItemNumber']!=''){
    $id = $args['id'];
    $num = $request->getParsedBody()['fruitDetailsItemNumber'];
    $name = $request->getParsedBody()['fruitDetailsItemName'];
    $amount = $request->getParsedBody()['fruitDetailsAmount'];
    $price = $request->getParsedBody()['fruitDetailsPrice'];
    if(isset($num) &&isset($name) && isset($amount) && isset($price)) {
                
        // Check if Full name is empty or not
        if($name == ''){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Fruit Name.</div>';
            exit();
        }else if($amount == '' || $amount =='0'){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Amount.</div>';
            exit();
        }else if($price == ''|| $price =='0'){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Price.</div>';
            exit();
        }else if($num==''){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a fruit number.</div>';
            exit();
        }
        try {
        // Construct the UPDATE query
        $db = new db();
        // Connect
        $db = $db->connect();
			$updateItemDetailsSql = 'UPDATE fruit SET name = :itemName, price = :price, amount = :amount WHERE id = :itemNumber';
			$updateItemDetailsStatement = $db->prepare($updateItemDetailsSql);
			$updateItemDetailsStatement->execute(['itemName' => $name, 'amount' => $amount, 'price' => $price, 'itemNumber' => $num]);
			$count = $updateItemDetailsStatement->rowCount();
			$successAlert = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Fruit details updated.</div>';
			$data = ['alertMessage' => $successAlert];
			echo json_encode($count);
        } catch (PDOException $e) {
            $data = array(
                "status" => "fail"
            );
            echo json_encode($data);
        }
        
        } else {
            // One or more fields are empty
            $errorAlert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			$data = ['alertMessage' => $errorAlert];
			echo json_encode($data);
        }
    }
        
            
        
});

//SALE (Chiaw Torng)
$app->post('/sale', function (Request $request, Response $response, array $args) {
    if(isset($_POST['saleDetailsItemNumber'])){
    $itemNumber = htmlentities($_POST['saleDetailsItemNumber']);
    $itemName = htmlentities($_POST['saleDetailsItemName']);
    $discount = htmlentities($_POST['saleDetailsDiscount']);
    $quantity = htmlentities($_POST['saleDetailsQuantity']);
    $unitPrice = htmlentities($_POST['saleDetailsUnitPrice']);
    $customerID = htmlentities($_POST['saleDetailsCustomerID']);
    $customerName = htmlentities($_POST['saleDetailsCustomerName']);
    $saleDate = htmlentities($_POST['saleDetailsSaleDate']);
       
    $result=createSale($itemNumber,$customerID,$customerName,$itemName, $saleDate,$discount,$quantity,$unitPrice);
    echo $result;
    }
});

$app->get('/allSales', function(Request $request, Response $response, array $args){
    $result=getSales();
    echo $result;
    
});

$app->get('/populateFruit/{id}',  function(Request $request, Response $response, array $args){
 
    $id = htmlentities($args['id']);
    $result=getFruitDetail($id);
    echo $result;

});
$app->post('/fruitSuggestion',  function(Request $request, Response $response, array $args){
    if(isset($_POST['textBoxValue'])){     
    $id = $_POST['textBoxValue'];
     $result=showItemNoSuggestion($id);
    echo $result;
    }
});

$app->post('/customerSuggestion',  function(Request $request, Response $response, array $args){
    if(isset($_POST['textBoxValue'])){     
    $id = $_POST['textBoxValue'];
     $result=showCustomerNumberSuggestion($id);
    echo $result;
    }
});

$app->get('/populateCustomer/{id}',  function(Request $request, Response $response, array $args){
 
    $id = htmlentities($args['id']);
    $result=getCustomerDetail($id);
    echo $result;

});

$app->post('/saleSuggestion',  function(Request $request, Response $response, array $args){
    if(isset($_POST['textBoxValue'])){     
    $id = $_POST['textBoxValue'];
     $result=showSaleIDSuggestion($id);
    echo $result;
    }
});
$app->get('/populateSale/{id}',  function(Request $request, Response $response, array $args){
 
    $id = htmlentities($args['id']);
    $result=getSaleDetail($id);
    echo $result;

});

$app->get('/lastSaleID',  function(Request $request, Response $response, array $args){
 
    
    $result=getLastSaleID();
    echo $result;

});

$app->put('/sale/{id}', function (Request $request, Response $response, array $args) {

    if($request->getParsedBody()['saleDetailsItemNumber']!=''){
    $id = htmlentities($args['id']);
    $itemNumber = htmlentities($request->getParsedBody()['saleDetailsItemNumber']);
    $itemName = htmlentities($request->getParsedBody()['saleDetailsItemName']);
    $discount = htmlentities($request->getParsedBody()['saleDetailsDiscount']);
    $quantity = htmlentities($request->getParsedBody()['saleDetailsQuantity']);
    $unitPrice = htmlentities($request->getParsedBody()['saleDetailsUnitPrice']);
    $customerID = htmlentities($request->getParsedBody()['saleDetailsCustomerID']);
    $customerName = htmlentities($request->getParsedBody()['saleDetailsCustomerName']);
    $saleDate = htmlentities($request->getParsedBody()['saleDetailsSaleDate']);
       
    $result=editSale($id,$itemNumber,$customerID,$customerName,$itemName, $saleDate,$discount,$quantity,$unitPrice);
    echo $result;
    }
});

$app->delete('/sale/{id}', function(Request $request, Response $response, array $args){
    $id = htmlentities($args['id']);
    $result=deleteSale($id);
    echo $result;
    

});



/* CUSTOMER */
//get all customer
$app->get('/allCustomers', function (Request $request, Response $response, array $args) {
    $sql = "SELECT * FROM customer";

try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $customerDetailsSearchStatement = $db->prepare($sql);
	$customerDetailsSearchStatement->execute();

    $output = '<table id="customerReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Customer ID</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Phone 2</th>
						<th>Address</th>
						<th>Address 2</th>
						<th>City</th>
						<th>District</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>';

    // Create table rows from the selected data
	while($row = $customerDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td>' . $row['customerID'] . '</td>' .
						'<td>' . $row['fullName'] . '</td>' .
						'<td>' . $row['email'] . '</td>' .
						'<td>' . $row['mobile'] . '</td>' .
						'<td>' . $row['phone2'] . '</td>' .
						'<td>' . $row['address'] . '</td>' .
						'<td>' . $row['address2'] . '</td>' .
						'<td>' . $row['city'] . '</td>' .
						'<td>' . $row['district'] . '</td>' .
						'<td>' . $row['status'] . '</td>' .
					'</tr>';
	}

    $output .= '</tbody>
					<tfoot>
						<tr>
							<th>Customer ID</th>
							<th>Full Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Phone 2</th>
							<th>Address</th>
							<th>Address 2</th>
							<th>City</th>
							<th>District</th>
							<th>Status</th>
						</tr>
					</tfoot>
				</table>';
	echo $output;

    $db = null;
} catch (PDOException $e) {
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}
});

//get a customer
$app->get('/customer/{id}', function (Request $request, Response $response, array $args) {
    $customerID = $args['id'];
    $sql = "SELECT * FROM customer WHERE customerID = :customerID";

try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $customerDetailsStatement = $db->prepare($sql);
    $customerDetailsStatement->execute(['customerID' => $customerID]);

    // If data is found for the given item number, return it as a json object
		if($customerDetailsStatement->rowCount() > 0) {
			$row = $customerDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$customerDetailsStatement->closeCursor();

    $db = null;
} catch (PDOException $e) {
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}
});

//get customer id suggestion
$app->get('/suggestionCustomerID/{id}', function (Request $request, Response $response, array $args) {
    $customerID = $args['id'];

try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

		$output = '';
		
		// Construct the SQL query to get the customer ID
		$sql = 'SELECT customerID FROM customer WHERE customerID LIKE ?';
		$stmt = $db->prepare($sql);
		$stmt->execute([$customerID]);
		
		// If we receive any results from the above query, then display them in a list
		if($stmt->rowCount() > 0){
			
			// Given customer ID is available in DB. Hence create the dropdown list
			$output = '<ul class="list-unstyled suggestionsList" id="customerDetailsCustomerIDSuggestionsList">';
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$output .= '<li>' . $row['customerID'] . '</li>';
			}
			echo '</ul>';
		} else {
			$output = '';
		}
		$stmt->closeCursor();
		echo $output;

    $db = null;
} catch (PDOException $e) {
    $data = array(
        "status" => "fail"
    );
    echo json_encode($data);
}
});

//add customer
$app->post('/customer', function (Request $request, Response $response, array $args) {
    $fullName = htmlentities($_POST['customerDetailsCustomerFullName']);
    $email = htmlentities($_POST['customerDetailsCustomerEmail']);
    $mobile = htmlentities($_POST['customerDetailsCustomerMobile']);
    $phone2 = htmlentities($_POST['customerDetailsCustomerPhone2']);
    $address = htmlentities($_POST['customerDetailsCustomerAddress']);
    $address2 = htmlentities($_POST['customerDetailsCustomerAddress2']);
    $city = htmlentities($_POST['customerDetailsCustomerCity']);
    $district = htmlentities($_POST['customerDetailsCustomerDistrict']);
    $status = htmlentities($_POST['customerDetailsStatus']);
    
    if(isset($fullName) && isset($mobile) && isset($address)) {
        // Validate mobile number
        if(filter_var($mobile, FILTER_VALIDATE_INT) === 0 || filter_var($mobile, FILTER_VALIDATE_INT)) {
            // Valid mobile number
        } else {
            // Mobile is wrong
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
            exit();
        }
        
        // Validate second phone number only if it's provided by user
        if(!empty($phone2)){
            if(filter_var($phone2, FILTER_VALIDATE_INT) === false) {
                // Phone number 2 is not valid
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid mobile number 2</div>';
                exit();
            }
        }
        
        // Validate email only if it's provided by user
        if(!empty($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                // Email is not valid
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
                exit();
            }
        }
        
        // Validate address
        if($address == ''){
            // Address 1 is empty
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Address 1</div>';
            exit();
        }
        
        // Check if Full name is empty or not
        if($fullName == ''){
            // Full Name is empty
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Full Name.</div>';
            exit();
        }
        
        // Get DB Object
        try{
            $db = new db();
            // Connect
            $db = $db->connect();
            // Start the insert process
            $sql = 'INSERT INTO customer(fullName, email, mobile, phone2, address, address2, city, district, status) VALUES(:fullName, :email, :mobile, :phone2, :address, :address2, :city, :district, :status)';
            $stmt = $db->prepare($sql);
            $stmt->execute(['fullName' => $fullName, 'email' => $email, 'mobile' => $mobile, 'phone2' => $phone2, 'address' => $address, 'address2' => $address2, 'city' => $city, 'district' => $district, 'status' => $status]);
            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer added to database</div>';
        } catch (PDOException $e) {
            $data = array(
                "status" => "fail"
            );
            echo json_encode($data);
        }
        
        
    } else {
        // One or more fields are empty
        echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
        exit();
    }
});

//update customer
$app->put('/customer/{id}', function (Request $request, Response $response, array $args) {
    $customerDetailsCustomerID = $args['id'];
    $customerDetailsCustomerFullName = $request->getParsedBody()["customerDetailsCustomerFullName"];
    $customerDetailsCustomerMobile = $request->getParsedBody()["customerDetailsCustomerMobile"];
    $customerDetailsCustomerPhone2 = $request->getParsedBody()["customerDetailsCustomerPhone2"];
    $customerDetailsCustomerEmail = $request->getParsedBody()["customerDetailsCustomerEmail"];
    $customerDetailsCustomerAddress = $request->getParsedBody()["customerDetailsCustomerAddress"];
    $customerDetailsCustomerAddress2 = $request->getParsedBody()["customerDetailsCustomerAddress2"];
    $customerDetailsCustomerCity = $request->getParsedBody()["customerDetailsCustomerCity"];
    $customerDetailsCustomerDistrict = $request->getParsedBody()["customerDetailsCustomerDistrict"];
    $customerDetailsStatus = $request->getParsedBody()["customerDetailsStatus"];

    // Validate mobile number
			if(filter_var($customerDetailsCustomerMobile, FILTER_VALIDATE_INT) === 0 || filter_var($customerDetailsCustomerMobile, FILTER_VALIDATE_INT)) {
				// Mobile number is valid
			} else {
				// Mobile number is not valid
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid mobile number</div>';
				exit();
			}
			
			// Check if CustomerID field is empty. If so, display an error message
			// We have to specifically tell this to user because the (*) mark is not added to that field
			if(empty($customerDetailsCustomerID)){
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter the CustomerID to update that customer.</div>';
				exit();
			}
			
			// Validate second phone number only if it's provided by user
			if(!empty($customerDetailsCustomerPhone2)){
				if(filter_var($customerDetailsCustomerPhone2, FILTER_VALIDATE_INT) === 0 || filter_var($customerDetailsCustomerPhone2, FILTER_VALIDATE_INT)) {
					// Phone number 2 is valid
				} else {
					// Phone number 2 is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for phone number 2.</div>';
					exit();
				}
			}
			
			// Validate email only if it's provided by user
			if(!empty($customerDetailsCustomerEmail)) {
				if (filter_var($customerDetailsCustomerEmail, FILTER_VALIDATE_EMAIL) === false) {
					// Email is not valid
					echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid email</div>';
					exit();
				}
			}
    try {
            $db = new db();
            // Connect
            $db = $db->connect();
        // Check if the given CustomerID is in the DB
			$customerIDSelectSql = 'SELECT customerID FROM customer WHERE customerID = :customerDetailsCustomerID';
			$customerIDSelectStatement = $db->prepare($customerIDSelectSql);
			$customerIDSelectStatement->execute(['customerDetailsCustomerID' => $customerDetailsCustomerID]);
			
			if($customerIDSelectStatement->rowCount() > 0) {
				
				// CustomerID is available in DB. Therefore, we can go ahead and UPDATE its details
				// Construct the UPDATE query
				$updateCustomerDetailsSql = 'UPDATE customer SET fullName = :fullName, email = :email, mobile = :mobile, phone2 = :phone2, address = :address, address2 = :address2, city = :city, district = :district, status = :status WHERE customerID = :customerID';
				$updateCustomerDetailsStatement = $db->prepare($updateCustomerDetailsSql);
				$updateCustomerDetailsStatement->execute(['fullName' => $customerDetailsCustomerFullName, 'email' => $customerDetailsCustomerEmail, 'mobile' => $customerDetailsCustomerMobile, 'phone2' => $customerDetailsCustomerPhone2, 'address' => $customerDetailsCustomerAddress, 'address2' => $customerDetailsCustomerAddress2, 'city' => $customerDetailsCustomerCity, 'district' => $customerDetailsCustomerDistrict, 'status' => $customerDetailsStatus, 'customerID' => $customerDetailsCustomerID]);
				
				// UPDATE customer name in sale table too
				$updateCustomerInSaleTableSql = 'UPDATE sale SET customerName = :customerName WHERE customerID = :customerID';
				$updateCustomerInSaleTableStatement = $db->prepare($updateCustomerInSaleTableSql);
				$updateCustomerInSaleTableStatement->execute(['customerName' => $customerDetailsCustomerFullName, 'customerID' => $customerDetailsCustomerID]);
				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer details updated.</div>';
				exit();
			} else {
				// CustomerID is not in DB. Therefore, stop the update and quit
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>CustomerID does not exist in DB. Therefore, update not possible.</div>';
				exit();
			}
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }
});

//delete customer
$app->delete('/customer/{id}', function (Request $request, Response $response, array $args) {
    $customerDetailsCustomerID = $args['id'];

    try{
        $db = new db();
        // Connect
        $db = $db->connect();
        // Check if the customer is in the database
			$customerSql = 'SELECT customerID FROM customer WHERE customerID=:customerID';
			$customerStatement = $db->prepare($customerSql);
			$customerStatement->execute(['customerID' => $customerDetailsCustomerID]);
			
			if($customerStatement->rowCount() > 0){
				
				// Customer exists in DB. Hence start the DELETE process
				$deleteCustomerSql = 'DELETE FROM customer WHERE customerID=:customerID';
				$deleteCustomerStatement = $db->prepare($deleteCustomerSql);
				$deleteCustomerStatement->execute(['customerID' => $customerDetailsCustomerID]);

				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer deleted.</div>';
				exit();
				
			} else {
				// Customer does not exist, therefore, tell the user that he can't delete that customer 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer does not exist in DB. Therefore, can\'t delete.</div>';
				exit();
			}
    } catch(PDOException $e){
        $data = array(
            "status" => "fail"
        );
        echo json_encode($data);
    }

});






$app->run();
