<?php

// This file will be responsible for creating the endpoints to be used.

include_once "controllers/AuthController.php";

$routes = array();

$routes["GET"] = [
	['#^/register$#', "AuthController::getRegisterPage"],
	['#^/login$#', "AuthController::getLoginPage"],
	['#^/user$#', "AuthController::getUser"],
];

$routes["POST"] = [
	['#^/register$#', "AuthController::postRegister"],
	['#^/api/register$#', "AuthController::postRegisterAPI"],
	['#^/login$#', "AuthController::postLogin"],
	['#^/api/login$#', "AuthController::postLoginAPI"],
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
