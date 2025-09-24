<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
require_once('../constants.php');
require_once('../db.php');
    
    $sql = "SELECT * FROM fruit";

    try {
        
    $sql = "SELECT * FROM fruit";
	$fruitStatement = $conn->prepare($sql);
	$fruitStatement->execute();
        $output = '<table id="fruitDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Fruit ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody>';
        while($row = $fruitStatement->fetch(PDO::FETCH_ASSOC)){
            $output .= '<tr>' .
                            '<td>' . $row['id'] . '</td>' .
                            '<td>' . $row['name'] . '</td>' .
                            '<td>' . $row['amount'] . '</td>' .
                            '<td>' . $row['price'] . '</td>' .
                            '<td>' . '
                            <a class="btn btn-primary" href="updateFruitPage.php" >Update</a>' 
                            . '</td>' .
                        '</tr>';
        }
        $output .= '</tbody>
					<tfoot>
						<tr>
                        <th>Fruit ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th></th>
						</tr>
					</tfoot>
				</table>';
	    echo $output;

        //echo json_encode($fruit);
    } catch (PDOException $e) {
        $data = array(
            "status" => "fail"
        );
        echo json_encode($e);
    }
    
        
    ?>
    