$('#addFruit').on('click', function () {
    addFruit();
});

// Function to call the insertFruit.php script to insert fruit data to db
function addFruit() {
    var fruitDetailsName = $('#fruitDetailsName').val();
    var fruitDetailsAmount = $('#fruitDetailsAmount').val();
    var fruitDetailsPrice = $('#fruitDetailsPrice').val();
    $.ajax({
        url: "http://localhost/100Fruity/api/fruit",
        method: 'POST',
        data: {
            fruitDetailsName: fruitDetailsName,
            fruitDetailsAmount: fruitDetailsAmount,
            fruitDetailsPrice: fruitDetailsPrice,
        },
        success: function (data) {
            $('#fruitDetailsMessage').fadeIn();
            $('#fruitDetailsMessage').html(data);
        },
        complete: function () {
            //populateLastInsertedID(fruitLastInsertedIDFile, 'fruitDetailsID');
            //searchTableCreator('customerDetailsTableDiv', customerDetailsSearchTableCreatorFile, 'fruitDetailsTable');
            //reportsTableCreator('customerReportsTableDiv', customerReportsSearchTableCreatorFile, 'customerReportsTable');
        }
    });
}

// File that returns item name
getFruitNameFile = 'api/fruits/getFruitName.php';
// File that returns itemNumbers in image tab
showFruitNumberSuggestionsForImageTabFile = 'api/fruits/showItemNumberForImageTab.php';

// File that returns itemNumbers
showFruitNumberSuggestionsFile = 'api/fruits/showItemNumber.php';

// File that returns itemNames
showFruitNamesFile = 'api/fruits/showItemNames.php';

// Listen to item number text box in item image tab
$('#fruitImageItemNumber').keyup(function () {
    showFruitSuggestions('fruitImageItemNumber', showFruitNumberSuggestionsForImageTabFile, 'fruitImageItemNumberSuggestionsDiv');
});
// Listen to item number text box in item details tab
$('#fruitDetailsItemNumber').keyup(function () {
    showFruitSuggestions('fruitDetailsItemNumber', showFruitNumberSuggestionsFile, 'fruitDetailsItemNumberSuggestionsDiv');
});
// Listen to item name text box in item details tab
$('#fruitDetailsItemName').keyup(function () {
    showFruitSuggestions('fruitDetailsItemName', showFruitNamesFile, 'fruitDetailsItemNameSuggestionsDiv');
});

// Remove the item numbers suggestions dropdown in the item image tab
// when user selects an item from it
$(document).on('click', '#fruitImageItemNumberSuggestionsList li', function () {
    $('#fruitImageItemNumber').val($(this).text());
    $('#fruitImageItemNumberSuggestionsList').fadeOut();
    getFruitName('fruitImageItemNumber', getFruitNameFile, 'fruitImageItemName');
});


// Function to send itemNumber so that item name can be pulled from db
function getFruitName(itemNumberTextBoxID, scriptPath, itemNameTextbox) {
    // Get the itemNumber entered in the text box
    var itemNumber = $('#' + itemNumberTextBoxID).val();

    // Call the script to get item details
    $.ajax({
        url: scriptPath,
        method: 'POST',
        data: { itemNumber: itemNumber },
        dataType: 'json',
        success: function (data) {
            $('#' + itemNameTextbox).val(data.name);
        },
        error: function (xhr, ajaxOptions, thrownError) {
        }
    });
}


// Function to show suggestions
function showFruitSuggestions(textBoxID, scriptPath, suggestionsDivID) {
    // Get the value entered by the user
    var textBoxValue = $('#' + textBoxID).val();

    // Call the showPurchaseIDs.php script only if there is a value in the
    // purchase ID textbox
    if (textBoxValue != '') {
        $.ajax({
            url: scriptPath,
            method: 'POST',
            data: { textBoxValue: textBoxValue },
            success: function (data) {
                $('#' + suggestionsDivID).fadeIn();
                $('#' + suggestionsDivID).html(data);
            }
        });
    }
}

// Remove the item numbers suggestions dropdown in the item details tab
// when user selects an item from it
$(document).on('click', '#fruitDetailsItemNumberSuggestionsList li', function () {
    $('#fruitDetailsItemNumber').val($(this).text());
    $('#fruitDetailsItemNumberSuggestionsList').fadeOut();
    getFruitDetailsToPopulate($('#fruitDetailsItemNumber').val());
});


// Function to send itemNumber so that item details can be pulled from db
// to be displayed on item details tab
function getFruitDetailsToPopulate() {
    // Get the itemNumber entered in the text box
    console.log($('#fruitDetailsItemNumber').val());
    var itemNumber = $('#fruitDetailsItemNumber').val();
    var defaultImgUrl = 'data/item_images/imageNotAvailable.jpg';
    var defaultImageData = '<img class="img-fluid" src="data/item_images/imageNotAvailable.jpg">';

    // Call the populateItemDetails.php script to get item details
    // relevant to the itemNumber which the user entered
    $.ajax({
        url: 'api/fruits/populateItemDetails.php',
        method: 'POST',
        data: { itemNumber: itemNumber },
        dataType: 'json',
        success: function (data) {
            //$('#itemDetailsItemNumber').val(data.itemNumber);
            $('#fruitDetailsItemName').val(data.name);
            $('#fruitDetailsAmount').val(data.amount);
            $('#fruitDetailsPrice').val(data.price);

            newImgUrl = 'data/item_images/' + data.id + '/' + data.imageURL;
            console.log(newImgUrl);
            // Set the item image
            if (data.imageURL == 'imageNotAvailable.jpg' || data.imageURL == '') {
                $('#imageContainer').html(defaultImageData);
            } else {
                $('#imageContainer').html('<img class="img-fluid" src="' + newImgUrl + '">');
            }
        }
    });
}


// File that updates an image
updateFruitImageFile = 'api/fruits/updateFruitImage.php';
// Listen to image update button
$('#fruitUpdateImageButton').on('click', function () {
    processFruitImage('fruitImageForm', updateFruitImageFile, 'fruitImageMessage');
});


// Function to call the script that process imageURL in DB
function processFruitImage(imageFormID, scriptPath, messageDivID) {
    var form = $('#' + imageFormID)[0];
    var formData = new FormData(form);
    $.ajax({
        url: scriptPath,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            $('#' + messageDivID).html(data);
        }
    });
}