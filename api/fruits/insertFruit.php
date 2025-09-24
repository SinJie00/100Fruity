<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['fruitDetailsName'])){
		
		$fruitName = htmlentities($_POST['fruitDetailsName']);
		$amount = htmlentities($_POST['fruitDetailsAmount']);
		$price = htmlentities($_POST['fruitDetailsPrice']);
		
		if(isset($fruitName)) {
			
			// Check if Full name is empty or not
			if($fruitName == ''){
				// Full Name is empty
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Full Name.</div>';
				exit();
			}
			
			// Start the insert process
			$sql = 'INSERT INTO fruit(name, amount, price) VALUES(:name, :amount, :price)';
			$stmt = $conn->prepare($sql);
			$stmt->execute(['name' => $fruitName, 'amount' => $amount, 'price' => $price]);
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Fruit added to database</div>';
		} else {
			// One or more fields are empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>