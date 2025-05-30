<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once "router.php";
include_once "db.php";
include_once "utils/OperationStatus.php";
include_once "utils/APIResponse.php";
include_once "utils/validators/Validator.php";

$redis = new Redis();
$redis->connect('redis', 6379);

# $uri = explode("/", $_SERVER["REQUEST_URI"]);

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];

if (strpos($uri, "/event_management_service") != false) {
	$fragments = explode("/", $uri);
	unset($fragments[1]);
	$uri = implode("/", $fragments);
}

$uri = rtrim($uri, "/\\");


route($uri, $method);
