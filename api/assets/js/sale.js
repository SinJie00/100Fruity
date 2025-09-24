// File that returns itemNumbers for sale tab
 showItemNumberForSaleTabFile = 'http://localhost/100Fruity/api/index.php/fruitSuggestion';
 showCustomerIDSuggestionsForSaleTabFile='http://localhost/100Fruity/api/index.php/customerSuggestion';
 showSaleIDSuggestionsFile='http://localhost/100Fruity/api/index.php/saleSuggestion';
 getItemStockFile='http://localhost/100Fruity/api/index.php/populateFruit/';
 saleLastInsertedIDFile='http://localhost/100Fruity/api/index.php/lastSaleID';

// Listen to item number text box in sale details tab
$('#saleDetailsItemNumber').keyup(function(){
	showSuggestion('saleDetailsItemNumber',showItemNumberForSaleTabFile,'saleDetailsItemNumberSuggestionsDiv');
});

$('#saleDetailsQuantity').keyup(function(){
	calculateTotalInSale();
});

$('#saleDetailsDiscount').keyup(function(){
	calculateTotalInSale();
});



function showSuggestion(textBoxID,path,suggestionsDivID){
	var textBoxValue = $('#' + textBoxID).val();
	if(textBoxValue != ''){
		$.ajax({
			url:path ,
			method: 'POST',
			data: {textBoxValue:textBoxValue},
			success: function(data){
				
				$('#' + suggestionsDivID).fadeIn();
				$('#' + suggestionsDivID).html(data);
			}
		});
	}
	
}



// Remove the item numbers suggestions dropdown in the sale details tab
// when user selects an item from it
$(document).on('click', '#fruitDetailsItemNumberSuggestionsList li', function(){
    $('#saleDetailsItemNumber').val($(this).text());
    $('#fruitDetailsItemNumberSuggestionsList').fadeOut();
    getItemDetailToPopulateForSaleTab();
});

// Function to send itemNumber so that item details can be pulled from db
// to be displayed on sale details tab
function getItemDetailToPopulateForSaleTab(){
	// Get the itemNumber entered in the text box
	var id = $('#saleDetailsItemNumber').val();
	var defaultImgUrl = 'http://localhost/100Fruity/data/item_images/imageNotAvailable.jpg';
	var defaultImageData = '<img class="img-fluid" src="http://localhost/100Fruity/data/item_images/imageNotAvailable.jpg">';
	
	// Call the populateItemDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'http://localhost/100Fruity/api/index.php/populateFruit/'+id,
		method: 'GET',
		data: {id:id},
		dataType: 'json',
		success: function(data){
			//$('#saleDetailsItemNumber').val(data.itemNumber);
			
			$('#saleDetailsItemName').val(data.name);
			// $('#saleDetailsDiscount').val(data.discount);
			$('#saleDetailsTotalStock').val(data.amount);
			$('#saleDetailsUnitPrice').val(data.price);

			newImgUrl = 'http://localhost/100Fruity/data/item_images/' + data.id + '/' + data.imageURL;
			
			// Set the item image
			if(data.imageURL == 'imageNotAvailable.jpg' || data.imageURL == ''){
				$('#saleDetailsImageContainer').html(defaultImageData);
			} else {
				$('#saleDetailsImageContainer').html('<img class="img-fluid" src="' + newImgUrl + '">');
			}
		},
		complete: function() {
			calculateTotalInSale();
		}
	});
}

// Calculate Total sale value in sale details tab
function calculateTotalInSale(){
	var quantityST = $('#saleDetailsQuantity').val();
	var unitPriceST = $('#saleDetailsUnitPrice').val();
	var discountST = $('#saleDetailsDiscount').val();
	var total=parseFloat(Number(unitPriceST) * ((100 - Number(discountST)) / 100) * Number(quantityST)).toFixed(2);
	$('#saleDetailsTotal').val(total);
}


$('#saleDetailsCustomerID').keyup(function () {
	showSuggestion('saleDetailsCustomerID', showCustomerIDSuggestionsForSaleTabFile, 'saleDetailsCustomerIDSuggestionsDiv');
});

// Remove the CustomerID suggestions dropdown in the sale details tab
// when user selects an item from it
$(document).on('click', '#saleDetailsCustomerIDSuggestionsList li', function () {
	$('#saleDetailsCustomerID').val($(this).text());
	$('#saleDetailsCustomerIDSuggestionsList').fadeOut();
	getCustomerDetailsToPopulateSaleTab();
});

	// Function to send customerID so that customer details can be pulled from db
// to be displayed on sale details tab
function getCustomerDetailsToPopulateSaleTab() {
	// Get the customerID entered in the text box
	var customerDetailsCustomerID = $('#saleDetailsCustomerID').val();

	// Call the populateCustomerDetails.php script to get customer details
	// relevant to the customerID which the user entered
	$.ajax({
		url: 'http://localhost/100Fruity/api/index.php/populateCustomer/'+customerDetailsCustomerID,
		method: 'GET',
		data: { customerID: customerDetailsCustomerID },
		dataType: 'json',
		success: function (data) {
			//$('#saleDetailsCustomerID').val(data.customerID);
			$('#saleDetailsCustomerName').val(data.fullName);
		}
	});
}

// Listen to saleID text box in sale details tab
$('#saleDetailsSaleID').keyup(function () {
	showSuggestion('saleDetailsSaleID', showSaleIDSuggestionsFile, 'saleDetailsSaleIDSuggestionsDiv');
});

// Remove the SaleID suggestions dropdown in the sale details tab
// when user selects an item from it
$(document).on('click', '#saleDetailsSaleIDSuggestionsList li', function () {
	$('#saleDetailsSaleID').val($(this).text());
	$('#saleDetailsSaleIDSuggestionsList').fadeOut();
	getSaleDetailsToPopulate();
});

// Function to send saleID so that sale details can be pulled from db
// to be displayed on sale details tab
function getSaleDetailsToPopulate() {
	// Get the saleID entered in the text box
	var saleDetailsSaleID = $('#saleDetailsSaleID').val();

	// Call the populateSaleDetails.php script to get item details
	// relevant to the itemNumber which the user entered
	$.ajax({
		url: 'http://localhost/100Fruity/api/index.php/populateSale/'+saleDetailsSaleID,
		method: 'GET',
		data: { saleDetailsSaleID: saleDetailsSaleID },
		dataType: 'json',
		success: function (data) {
			//$('#saleDetailsSaleID').val(data.saleID);
			$('#saleDetailsItemNumber').val(data.itemNumber);
			$('#saleDetailsCustomerID').val(data.customerID);
			$('#saleDetailsCustomerName').val(data.customerName);
			$('#saleDetailsItemName').val(data.itemName);
			$('#saleDetailsSaleDate').val(data.saleDate);
			$('#saleDetailsDiscount').val(data.discount);
			$('#saleDetailsQuantity').val(data.quantity);
			$('#saleDetailsUnitPrice').val(data.unitPrice);
		},
		complete: function () {
			calculateTotalInSale();
			getItemStockToPopulate('saleDetailsItemNumber', getItemStockFile, 'saleDetailsTotalStock');
		}
	});
}


// Function to send itemNumber so that item stock can be pulled from db
function getItemStockToPopulate(itemNumberTextbox, scriptPath, stockTextbox) {
	// Get the itemNumber entered in the text box
	var itemNumber = $('#' + itemNumberTextbox).val();

	// Call the script to get stock details
	$.ajax({
		url: scriptPath+itemNumber,
		method: 'GET',
		data: { itemNumber: itemNumber },
		dataType: 'json',
		success: function (data) {
			$('#' + stockTextbox).val(data.amount);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			//alert(thrownError);
			//console.warn(xhr.responseText)
		}
	});
}

// Listen to sale add button
$('#addSaleButton').on('click', function () {
	addSale();
});

// Function to call the insertSale.php script to insert sale data to db
// Function to call the insertSale.php script to insert sale data to db
function addSale() {
	var saleDetailsItemNumber = $('#saleDetailsItemNumber').val();
	var saleDetailsItemName = $('#saleDetailsItemName').val();
	var saleDetailsDiscount = $('#saleDetailsDiscount').val();
	var saleDetailsQuantity = $('#saleDetailsQuantity').val();
	var saleDetailsUnitPrice = $('#saleDetailsUnitPrice').val();
	var saleDetailsCustomerID = $('#saleDetailsCustomerID').val();
	var saleDetailsCustomerName = $('#saleDetailsCustomerName').val();
	var saleDetailsSaleDate = $('#saleDetailsSaleDate').val();
	
	$.ajax({
		url: 'http://localhost/100Fruity/api/index.php/sale',
		method: 'POST',
		data: {
			saleDetailsItemNumber:saleDetailsItemNumber,
			saleDetailsItemName:saleDetailsItemName,
			saleDetailsDiscount:saleDetailsDiscount,
			saleDetailsQuantity:saleDetailsQuantity,
			saleDetailsUnitPrice:saleDetailsUnitPrice,
			saleDetailsCustomerID:saleDetailsCustomerID,
			saleDetailsCustomerName:saleDetailsCustomerName,
			saleDetailsSaleDate:saleDetailsSaleDate,
		},
		success: function(data){
			$('#saleDetailsMessage').fadeIn();
			$('#saleDetailsMessage').html(data);
		},
		complete: function(){
			getItemStockToPopulate('saleDetailsItemNumber', getItemStockFile, 'saleDetailsTotalStock');
			populateLastInsertedID(saleLastInsertedIDFile, 'saleDetailsSaleID');
			// searchTableCreator('saleDetailsTableDiv', saleDetailsSearchTableCreatorFile, 'saleDetailsTable');
			// reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
			// searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			// reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

// Function to populate last inserted ID
function populateLastInsertedID(scriptPath, textBoxID) {
	$.ajax({
		url: scriptPath,
		method: 'GET',
		dataType: 'json',
		success: function (data) {
			$('#' + textBoxID).val(data);
		}
	});
}

// Listen to update button in sale details tab
$('#updateSaleDetailsButton').on('click', function () {
	updateSale();
});

// Listen to delete button in sale details tab
$('#deleteSaleButton').on('click', function () {
	deleteSale();
});


// Function to call the updateSale.php script to update sale data to db
function updateSale() {
	var saleDetailsItemNumber = $('#saleDetailsItemNumber').val();
	var saleDetailsSaleDate = $('#saleDetailsSaleDate').val();
	var saleDetailsItemName = $('#saleDetailsItemName').val();
	var saleDetailsQuantity = $('#saleDetailsQuantity').val();
	var saleDetailsUnitPrice = $('#saleDetailsUnitPrice').val();
	var saleDetailsSaleID = $('#saleDetailsSaleID').val();
	var saleDetailsCustomerName = $('#saleDetailsCustomerName').val();
	var saleDetailsDiscount = $('#saleDetailsDiscount').val();
	var saleDetailsCustomerID = $('#saleDetailsCustomerID').val();

	$.ajax({
		url: 'http://localhost/100Fruity/api/index.php/sale/'+saleDetailsSaleID,
		method: 'put',
		data: {
			saleDetailsItemNumber: saleDetailsItemNumber,
			saleDetailsSaleDate: saleDetailsSaleDate,
			saleDetailsItemName: saleDetailsItemName,
			saleDetailsQuantity: saleDetailsQuantity,
			saleDetailsUnitPrice: saleDetailsUnitPrice,
			saleDetailsCustomerName: saleDetailsCustomerName,
			saleDetailsDiscount: saleDetailsDiscount,
			saleDetailsCustomerID: saleDetailsCustomerID,
		},
		success: function (data) {
			$('#saleDetailsMessage').fadeIn();
			$('#saleDetailsMessage').html(data);
		},
		complete: function () {
			getItemStockToPopulate('saleDetailsItemNumber', getItemStockFile, 'saleDetailsTotalStock');
			// searchTableCreator('saleDetailsTableDiv', saleDetailsSearchTableCreatorFile, 'saleDetailsTable');
			// reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
			// searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
			// reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		}
	});
}

function deleteSale(){
	var saleDetailsSaleID = $('#saleDetailsSaleID').val();
	$.ajax({
		url: 'http://localhost/100Fruity/api/index.php/sale/'+saleDetailsSaleID,
		method: 'delete',
		data: {
			id: saleDetailsSaleID,
		},
		success: function (data) {
			$('#saleDetailsMessage').fadeIn();
			$('#saleDetailsMessage').html(data);
		},
		// complete: function () {
		// 	getItemStockToPopulate('saleDetailsItemNumber', getItemStockFile, 'saleDetailsTotalStock');
		// 	// searchTableCreator('saleDetailsTableDiv', saleDetailsSearchTableCreatorFile, 'saleDetailsTable');
		// 	// reportsSaleTableCreator('saleReportsTableDiv', saleReportsSearchTableCreatorFile, 'saleReportsTable');
		// 	// searchTableCreator('itemDetailsTableDiv', itemDetailsSearchTableCreatorFile, 'itemDetailsTable');
		// 	// reportsTableCreator('itemReportsTableDiv', itemReportsSearchTableCreatorFile, 'itemReportsTable');
		// }
	});

}