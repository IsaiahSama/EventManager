<?php

// This file will be responsible for creating the endpoints to be used.

include_once "FrontController.php";

$routes = array();

$routes["GET"] = [
	["#^$#", "FrontController::getHomePage"],
	["#^/register$#", "FrontController::getRegisterPage"],
	["#^/login$#", "FrontController::getLoginPage"],
	["#^/event/create$#", "FrontController::getEventCreatePage"],
	["#^/event/update#", "FrontController::getEventUpdatePage"],
	["#^/event/([0-9]+)$#", "FrontController::viewEventPage"],
	["#^/event/all$#", "FrontController::viewEventsPage"],
	["#^/user/events$#", "FrontController::getUserEventsPage"],
	["#^/user/event/register$#", "FrontController::getUserEventRegisterPage"],
];

$routes["POST"] = [
	// Event ID
	["#^/register$#", "FrontController::postRegister"],
	["#^/login$#", "FrontController::postLogin"],
	["#^/event/create$#", "FrontController::postEventCreate"],
	["#^/event/([0-9]+)/update#", "FrontController::postEventUpdate"],
	["#^/user/event/([0-9]+)/register#", "FrontController::postUserEventRegister"],
];

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

	render("views/errors/404");
}
