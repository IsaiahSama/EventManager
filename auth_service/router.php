<?php

// This file will be responsible for creating the endpoints to be used.

include_once "controllers/AuthController.php";

$routes = array();

$routes["GET"] = [
	['#^/auth/user$#', "AuthController::getUser"],
];

$routes["POST"] = [
	['#^/auth/register$#', "AuthController::postRegisterAPI"],
	['#^/auth/login$#', "AuthController::postLoginAPI"],
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
			call_user_func_array($path[1], array_slice($matches, 1));
			return;
		}
	}

	render("views/errors/404.php");
}
