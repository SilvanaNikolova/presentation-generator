<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "router.php";

$router = new Router();

$requestURL = $_SERVER["REQUEST_URI"];

$router->performAction($requestURL);

?>