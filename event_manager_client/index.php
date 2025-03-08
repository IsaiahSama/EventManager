<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once "router.php";
include_once "view.php";
include_once "FormHelper.php";

$SERVER_URL = "http://127.0.0.1:8081/";

$uri = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];

$uri = rtrim($uri, "/\\");

route($uri, $method);
