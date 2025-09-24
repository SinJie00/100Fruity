<?php

function deleteSale($id){
    $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($id)){
        // Check if saleID is empty
        if($id == ''){ 
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a Sale ID.</div>';
            exit();
        }
        // Check if the sale is in DB
        $saleSql = 'SELECT * FROM sale WHERE saleID = :saleID';
        $saleStatement = $conn->prepare($saleSql);
        $saleStatement->execute(['saleID' => $id]);
        
        if($saleStatement->rowCount() <= 0){
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Sale ID does not exist.</div>';
            exit();
            
        } else{
            try{
            $saleRow = $saleStatement->fetch(PDO::FETCH_ASSOC);
            $saleQty = $saleRow['quantity'];
            $fruitID=$saleRow['itemNumber'];
            $fruitSql = 'SELECT * FROM fruit WHERE id = :id';
            $fruitStatement = $conn->prepare($fruitSql);
            $fruitStatement->execute(['id' => $fruitID]);
            $fruitRow = $fruitStatement->fetch(PDO::FETCH_ASSOC);
            $fruitAmount=$fruitRow['amount'];
            $newAmount=$fruitAmount+$saleQty;
            $amountSql = 'UPDATE fruit SET amount = :amount WHERE id = :id';
            $amountStatement = $conn->prepare($amountSql);
            $amountStatement->execute(['amount' => $newAmount, 'id' => $fruitID]);

            
            $sql = "DELETE FROM sale WHERE saleID = '$id'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            // $count = $stmt->rowCount();
        
            // $db = null;
            // $data = array(
            //     // "rowAffected" => $count,
            //     "status" => "success"
            // );
            echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Sale deleted successfully.</div>';
            } catch (PDOException $e) {
                // $data = array(
                //     "status" => "fail"
                // );
                echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Fail to Delete.</div>';
            }
        }

    }
}
?>