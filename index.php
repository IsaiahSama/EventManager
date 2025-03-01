<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once "router.php";
include_once "view.php";
include_once "data/db.php";
include_once "utils/OperationStatus.php";

# $uri = explode("/", $_SERVER["REQUEST_URI"]);

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];

route($uri, $method);
