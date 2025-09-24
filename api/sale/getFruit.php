<?php
	// require_once('../../inc/config/constants.php');
	// require_once('../../inc/config/db.php');

    function getFruitDetail($id){
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $itemDetailsSql = 'SELECT * FROM fruit WHERE id = :id';
            $itemDetailsStatement = $conn->prepare($itemDetailsSql);
            $itemDetailsStatement->execute(['id' => $id]);
            
            // If data is found for the given item number, return it as a json object
            if($itemDetailsStatement->rowCount() > 0) {
                $row = $itemDetailsStatement->fetch(PDO::FETCH_ASSOC);
                echo json_encode($row);
            }
            $itemDetailsStatement->closeCursor();
        }

    

	
	
?>