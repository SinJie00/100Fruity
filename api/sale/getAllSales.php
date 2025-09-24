<?php
function getSales(){
    $conn = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM sale";
    try{
        
	$saleStatement = $conn->prepare($sql);
	$saleStatement->execute();
    $output = '<table id="saleDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Sale ID</th>
                <th>Item Number</th>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Item Name</th>
                <th>Sale Date</th>
                <th>Discount %</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>';
        while($row = $saleStatement->fetch(PDO::FETCH_ASSOC)){
            $total=$row['unitPrice']*$row['quantity']*(100-$row['discount'])/100;
            $total=round($total,2);

            $output .= '<tr>' .
                            '<td>' . $row['saleID'] . '</td>' .
                            '<td>' . $row['itemNumber'] . '</td>' .
                            '<td>' . $row['customerID'] . '</td>' .
                            '<td>' . $row['customerName'] . '</td>'  .
                            '<td>' . $row['itemName'] . '</td>'  .
                            '<td>' . $row['saleDate'] . '</td>'  .
                            '<td>' . $row['discount'] . '</td>'  .
                            '<td>' . $row['quantity'] . '</td>'  .
                            '<td>' . $row['unitPrice'] . '</td>'  .
                            '<td>' . $total . '</td>'  .
                        '</tr>';
        }
        $output .= '</tbody>
					
				</table>';
	    echo $output; 
    
    }catch (PDOException $e){
        $data = array(
            "status"=>"fail"
        );
        echo json_encode($data);
    }
}

?>