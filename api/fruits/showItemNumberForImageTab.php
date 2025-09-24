<?php
	require_once('../constants.php');
	require_once('../db.php');
	
	// Check if the POST request is received and if so, execute the script
	if(isset($_POST['textBoxValue'])){
		$output = '';
		$itemNumberString = '%' . htmlentities($_POST['textBoxValue']) . '%';
		
		// Construct the SQL query to get the item name
		$sql = 'SELECT id FROM fruit WHERE id LIKE ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$itemNumberString]);
		
		// If we receive any results from the above query, then display them in a list
		if($stmt->rowCount() > 0){
			$output = '<ul class="list-unstyled suggestionsList" id="fruitImageItemNumberSuggestionsList">';
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$output .= '<li>' . $row['id'] . '</li>';
			}
			echo '</ul>';
		} else {
			$output = '';
		}
		$stmt->closeCursor();
		echo $output;
	}
?>