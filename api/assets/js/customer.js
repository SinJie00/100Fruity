// File that returns customerIDs
showCustomerIDSuggestionsFileName = 'http://localhost/100Fruity/api/suggestionCustomerID/';

// Listen to CustomerID text box in customer details tab
$('#customerDetailsCustomerID').keyup(function(){
    showCustomerSuggestions('customerDetailsCustomerID', showCustomerIDSuggestionsFileName, 'customerDetailsCustomerIDSuggestionsDiv');
});

// Function to show suggestions
function showCustomerSuggestions(textBoxID, scriptPath, suggestionsDivID){
	// Get the value entered by the user
	var textBoxValue = $('#' + textBoxID).val();
	
	// Call the showPurchaseIDs.php script only if there is a value in the
	// purchase ID textbox
	if(textBoxValue != ''){
		$.ajax({
			url: scriptPath+textBoxValue,
			method: 'get',
			success: function(data){
				$('#' + suggestionsDivID).fadeIn();
				$('#' + suggestionsDivID).html(data);
			}
		});
	}
}

// Remove the CustomerID suggestions dropdown in the customer details tab
	// when user selects an item from it
	$(document).on('click', '#customerDetailsCustomerIDSuggestionsList li', function(){
		$('#customerDetailsCustomerID').val($(this).text());
		$('#customerDetailsCustomerIDSuggestionsList').fadeOut();
		getCustomerDetailsToPopulateInput();
	});

// Function to send customerID so that customer details can be pulled from db
// to be displayed on customer details tab
function getCustomerDetailsToPopulateInput(){
	// Get the customerID entered in the text box
	var customerDetailsCustomerID = $('#customerDetailsCustomerID').val();
	
	// Call the populateItemDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'http://localhost/100Fruity/api/customer/'+customerDetailsCustomerID,
		method: 'get',
		data: {customerID:customerDetailsCustomerID},
		dataType: 'json',
		success: function(data){
			//$('#customerDetailsCustomerID').val(data.customerID);
			$('#customerDetailsCustomerFullName').val(data.fullName);
			$('#customerDetailsCustomerMobile').val(data.mobile);
			$('#customerDetailsCustomerPhone2').val(data.phone2);
			$('#customerDetailsCustomerEmail').val(data.email);
			$('#customerDetailsCustomerAddress').val(data.address);
			$('#customerDetailsCustomerAddress2').val(data.address2);
			$('#customerDetailsCustomerCity').val(data.city);
			$('#customerDetailsCustomerDistrict').val(data.district).trigger("chosen:updated");
			$('#customerDetailsStatus').val(data.status).trigger("chosen:updated");
		}
	});
}

// Listen to customer add button
$('#addCustomer').on('click', function(){
    var customerDetailsCustomerFullName = $('#customerDetailsCustomerFullName').val();
	var customerDetailsCustomerEmail = $('#customerDetailsCustomerEmail').val();
	var customerDetailsCustomerMobile = $('#customerDetailsCustomerMobile').val();
	var customerDetailsCustomerPhone2 = $('#customerDetailsCustomerPhone2').val();
	var customerDetailsCustomerAddress = $('#customerDetailsCustomerAddress').val();
	var customerDetailsCustomerAddress2 = $('#customerDetailsCustomerAddress2').val();
	var customerDetailsCustomerCity = $('#customerDetailsCustomerCity').val();
	var customerDetailsCustomerDistrict = $('#customerDetailsCustomerDistrict option:selected').text();
	var customerDetailsStatus = $('#customerDetailsStatus option:selected').text();
	
	$.ajax({
		url: 'http://localhost/100Fruity/api/customer',
		method: 'POST',
		data: {
			customerDetailsCustomerFullName:customerDetailsCustomerFullName,
			customerDetailsCustomerEmail:customerDetailsCustomerEmail,
			customerDetailsCustomerMobile:customerDetailsCustomerMobile,
			customerDetailsCustomerPhone2:customerDetailsCustomerPhone2,
			customerDetailsCustomerAddress:customerDetailsCustomerAddress,
			customerDetailsCustomerAddress2:customerDetailsCustomerAddress2,
			customerDetailsCustomerCity:customerDetailsCustomerCity,
			customerDetailsCustomerDistrict:customerDetailsCustomerDistrict,
			customerDetailsStatus:customerDetailsStatus,
		},
		success: function(data){
			$('#customerDetailsMessage').fadeIn();
			$('#customerDetailsMessage').html(data);
		},
		complete: function(data){
			// populateLastInsertedID(customerLastInsertedIDFile, 'customerDetailsCustomerID');
			// searchTableCreator('customerDetailsTableDiv', customerDetailsSearchTableCreatorFile, 'customerDetailsTable');
			// reportsTableCreator('customerReportsTableDiv', customerReportsSearchTableCreatorFile, 'customerReportsTable');
		}
	});
});

// Listen to update button in customer details tab
$('#updateCustomerDetailsButton').on('click', function(){
    var customerDetailsCustomerID = $('#customerDetailsCustomerID').val();
	var customerDetailsCustomerFullName = $('#customerDetailsCustomerFullName').val();
	var customerDetailsCustomerMobile = $('#customerDetailsCustomerMobile').val();
	var customerDetailsCustomerPhone2 = $('#customerDetailsCustomerPhone2').val();
	var customerDetailsCustomerAddress = $('#customerDetailsCustomerAddress').val();
	var customerDetailsCustomerEmail = $('#customerDetailsCustomerEmail').val();
	var customerDetailsCustomerAddress2 = $('#customerDetailsCustomerAddress2').val();
	var customerDetailsCustomerCity = $('#customerDetailsCustomerCity').val();
	var customerDetailsCustomerDistrict = $('#customerDetailsCustomerDistrict').val();
	var customerDetailsStatus = $('#customerDetailsStatus option:selected').text();
	
	$.ajax({
		url: 'http://localhost/100Fruity/api/customer/'+customerDetailsCustomerID,
		method: 'PUT',
		data: {
			//customerDetailsCustomerID:customerDetailsCustomerID,
			customerDetailsCustomerFullName:customerDetailsCustomerFullName,
			customerDetailsCustomerMobile:customerDetailsCustomerMobile,
			customerDetailsCustomerPhone2:customerDetailsCustomerPhone2,
			customerDetailsCustomerAddress:customerDetailsCustomerAddress,
			customerDetailsCustomerEmail:customerDetailsCustomerEmail,
			customerDetailsCustomerAddress2:customerDetailsCustomerAddress2,
			customerDetailsCustomerCity:customerDetailsCustomerCity,
			customerDetailsCustomerDistrict:customerDetailsCustomerDistrict,
			customerDetailsStatus:customerDetailsStatus,
		},
		success: function(data){
			$('#customerDetailsMessage').fadeIn();
			$('#customerDetailsMessage').html(data);
		},
		complete: function(){
			// searchTableCreator('customerDetailsTableDiv', customerDetailsSearchTableCreatorFile, 'customerDetailsTable');
			// reportsTableCreator('customerReportsTableDiv', customerReportsSearchTableCreatorFile, 'customerReportsTable');
			// searchTableCreator('saleDetailsTableDiv', saleDetailsSearchTableCreatorFile, 'saleDetailsTable');
			// reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
		}
	});
});
// Listen to delete button in customer details tab
$('#deleteCustomerIDButton').on('click', function(){
    // Confirm before deleting
    bootbox.confirm('Are you sure you want to delete this customer?', function(result){
        if(result){
            // Get the customerID entered by the user
            var customerDetailsCustomerID = $('#customerDetailsCustomerID').val();
            
            // Call the deleteCustomer.php script only if there is a value in the
            // item number textbox
            if(customerDetailsCustomerID != ''){
                $.ajax({
                    url: 'http://localhost/100Fruity/api/customer/'+customerDetailsCustomerID,
                    method: 'DELETE',
                    success: function(data){
                        $('#customerDetailsMessage').fadeIn();
                        $('#customerDetailsMessage').html(data);
                    },
                    complete: function(){
                        // searchTableCreator('customerDetailsTableDiv', customerDetailsSearchTableCreatorFile, 'customerDetailsTable');
                        // reportsTableCreator('customerReportsTableDiv', customerReportsSearchTableCreatorFile, 'customerReportsTable');
                    }
                });
            }
        }
    });
});