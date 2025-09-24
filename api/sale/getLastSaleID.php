
<?php
	// require_once('../../inc/config/constants.php');
	// require_once('../../inc/config/db.php');
    function getLastSaleID(){
        $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT MAX(saleID) FROM sale";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo $row['MAX(saleID)'];

    }
	
	
?>