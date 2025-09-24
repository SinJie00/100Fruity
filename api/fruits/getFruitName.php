<?php
	require_once('../constants.php');
	require_once('../db.php');

	// Execute the script if the POST request is submitted
	if(isset($_POST['itemNumber'])){
		
		$itemNumber = htmlentities($_POST['itemNumber']);
		
		$itemDetailsSql = 'SELECT * FROM fruit WHERE id = :itemNumber';
		$itemDetailsStatement = $conn->prepare($itemDetailsSql);
		$itemDetailsStatement->execute(['itemNumber' => $itemNumber]);
		
		// If data is found for the given item number, return it as a json object
		if($itemDetailsStatement->rowCount() > 0) {
			$row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
		$itemDetailsStatement->closeCursor();
	}
?>