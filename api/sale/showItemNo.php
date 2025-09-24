<?php


    function showItemNoSuggestion($id){
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $output = '';
		$itemNumberString = '%' . htmlentities($id) . '%';

        
		
		// Construct the SQL query to get the item name
		$sql = 'SELECT id FROM fruit WHERE id LIKE ?';
		$stmt = $conn->prepare($sql);
		$stmt->execute([$itemNumberString]);
		
		// If we receive any results from the above query, then display them in a list
		if($stmt->rowCount() > 0){
			$output = '<ul class="list-unstyled suggestionsList" id="fruitDetailsItemNumberSuggestionsList">';
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