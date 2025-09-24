<?php
require_once ("fruitRestHandler.php");

$view = "";
if (isset($_GET["view"]))
    $view = $_GET["view"];
/*
 * controls the RESTful services
 * URL mapping
 */
switch ($view) {

    case "all":
        // to handle REST Url /mobile/list/
        $mobileRestHandler = new FruitRestHandler();
        $mobileRestHandler->getAllFruits();
        break;

    case "single":
        // to handle REST Url /mobile/show/<id>/
        $mobileRestHandler = new FruitRestHandler();
        $mobileRestHandler->getFruit($_GET["id"]);
        break;

    case "":
        // 404 - not found;
        break;
}
?>