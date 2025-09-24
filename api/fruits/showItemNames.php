<?php
	require_once('../constants.php');
	require_once('../db.php');
	
	// Check if the POST request is received and if so, execute the script
	if(isset($_POST['textBoxValue'])){
		$output = '';
		$itemNameString = '%' . htmlentities($_POST['textBoxValue']) . '%';
		
		// Construct the SQL query to get the item name
		$sql = 'SELECT name FROM fruit WHERE name LIKE ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$itemNameString]);
		
		// If we receive any results from the above query, then display them in a list
		if($stmt->rowCount() > 0){
			$output = '<ul class="list-unstyled suggestionsList" id="fruitDetailsItemNamesSuggestionsList">';
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$output .= '<li>' . $row['name'] . '</li>';
			}
			echo '</ul>';
		} else {
			$output = '';
		}
		$stmt->closeCursor();
		echo $output;
	}
?>