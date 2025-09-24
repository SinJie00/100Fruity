$(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "http://localhost/100Fruity/api/customersNum",
        success: function (numCustomers) {
            $('#numcustomer').html(numCustomers);
        },
        error: function (xhr, resp, text) {
            alert("error " + xhr + ", " + resp + ", " + text);
        },
    });

    $.ajax({
        type: "GET",
        url: "http://localhost/100Fruity/api/fruitsNum",
        success: function (numFruits) {
            $('#numfruit').html(numFruits);
        },
        error: function (xhr, resp, text) {
            alert("error " + xhr + ", " + resp + ", " + text);
        },
    });

    $.ajax({
        type: "GET",
        url: "http://localhost/100Fruity/api/totalSale",
        success: function (totalSale) {
            $('#totalsale').html('RM'+totalSale);
        },
        error: function (xhr, resp, text) {
            alert("error " + xhr + ", " + resp + ", " + text);
        },
    });
});