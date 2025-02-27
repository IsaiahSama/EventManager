<?php 

// This file will be responsible for creating the endpoints to be used.

include_once "controllers/AuthController.php";

$routes = array();

$routes["GET"] = [
	['/\/register/', "AuthController::getRegister"],
	['/\/Login/', "AuthController::getLogin"],
];

$routes["POST"] = [
	['/\/register/', "AuthController::postRegister"],
	['/\/login/', "AuthController::postLogin"],
];

function route($uri, $method){
	global $routes;
	$paths = $routes[$method];

	foreach($paths as $path){
		if (preg_match($path[0], $uri)) {
			call_user_func_array($path[1], array());
			return;
		}
	}

	render("views/errors/404.php");
}
