<?php

// This file will be responsible for creating the endpoints to be used.

include_once "controllers/AuthController.php";
include_once "controllers/EventController.php";

$routes = array();

$routes["GET"] = [
	['#^/user/([0-9]+)/events$#', "AuthController::getUserEvents"],
];

$routes["POST"] = [
	['#^/events/([0-9]+)/register$#', "EventController::registerUser"],
];

$routes["PUT"] = [];

$routes["DELETE"] = [];

function route($uri, $method)
{
	global $routes;
	$paths = $routes[$method];

	$matches = [];
	foreach ($paths as $path) {
		if (preg_match($path[0], $uri, $matches)) {
			call_user_func_array($path[1], $matches);
			return;
		}
	}

	render("views/errors/404.php");
}
